import os
import re
import zipfile
import html

def xml_escape(text):
    return html.escape(text, quote=False)

def create_docx(md_path, docx_path):
    with open(md_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Split into lines
    raw_lines = content.splitlines()

    body_elements = []

    def make_run(text, bold=False, italic=False, font_size=24, font_family="Times New Roman", color="000000"):
        rPr_parts = [f'<w:rFonts w:ascii="{font_family}" w:hAnsi="{font_family}" w:cs="{font_family}"/>']
        if bold:
            rPr_parts.append('<w:b/><w:bCs/>')
        if italic:
            rPr_parts.append('<w:i/><w:iCs/>')
        rPr_parts.append(f'<w:sz w:val="{font_size}"/><w:szCs w:val="{font_size}"/>')
        if color != "000000":
            rPr_parts.append(f'<w:color w:val="{color}"/>')
        rPr = "".join(rPr_parts)
        return f'<w:r><w:rPr>{rPr}</w:rPr><w:t xml:space="preserve">{xml_escape(text)}</w:t></w:r>'

    def make_paragraph(runs_xml, align="both", space_before=0, space_after=120, line_spacing=360, left_indent=0):
        # 360 is 1.5 lines spacing (240 = 1.0 line)
        pPr_parts = []
        if align != "both":
            pPr_parts.append(f'<w:jc w:val="{align}"/>')
        else:
            pPr_parts.append('<w:jc w:val="both"/>')
        
        spacing_attr = f'w:line="{line_spacing}" w:lineRule="auto"'
        if space_before > 0:
            spacing_attr += f' w:before="{space_before}"'
        if space_after > 0:
            spacing_attr += f' w:after="{space_after}"'
        pPr_parts.append(f'<w:spacing {spacing_attr}/>')

        if left_indent > 0:
            pPr_parts.append(f'<w:ind w:left="{left_indent}"/>')

        pPr = "".join(pPr_parts)
        return f'<w:p><w:pPr>{pPr}</w:pPr>{runs_xml}</w:p>'

    def parse_inline_runs(text, base_size=24, base_font="Times New Roman"):
        # Match bold **text** and italic *text*
        runs = []
        tokens = re.split(r'(\*\*.*?\*\*|\*.*?\*)', text)
        for token in tokens:
            if not token:
                continue
            if token.startswith('**') and token.endswith('**') and len(token) >= 4:
                runs.append(make_run(token[2:-2], bold=True, font_size=base_size, font_family=base_font))
            elif token.startswith('*') and token.endswith('*') and len(token) >= 2:
                runs.append(make_run(token[1:-1], italic=True, font_size=base_size, font_family=base_font))
            else:
                runs.append(make_run(token, font_size=base_size, font_family=base_font))
        return "".join(runs)

    def make_table(rows_data):
        if not rows_data:
            return ""
        col_count = max(len(r) for r in rows_data)
        tbl_pr = (
            '<w:tblPr>'
            '<w:tblW w:w="0" w:type="auto"/>'
            '<w:jc w:val="center"/>'
            '<w:tblBorders>'
            '<w:top w:val="single" w:sz="6" w:space="0" w:color="999999"/>'
            '<w:bottom w:val="single" w:sz="6" w:space="0" w:color="999999"/>'
            '<w:left w:val="none"/>'
            '<w:right w:val="none"/>'
            '<w:insideH w:val="single" w:sz="4" w:space="0" w:color="DDDDDD"/>'
            '<w:insideV w:val="none"/>'
            '</w:tblBorders>'
            '<w:tblCellMar>'
            '<w:top w:w="120" w:type="dxa"/>'
            '<w:bottom w:w="120" w:type="dxa"/>'
            '<w:left w:w="180" w:type="dxa"/>'
            '<w:right w:w="180" w:type="dxa"/>'
            '</w:tblCellMar>'
            '</w:tblPr>'
        )

        rows_xml = []
        for r_idx, row in enumerate(rows_data):
            cells_xml = []
            is_header = (r_idx == 0)
            for c_idx in range(col_count):
                cell_text = row[c_idx] if c_idx < len(row) else ""
                shd = '<w:shd w:val="clear" w:color="auto" w:fill="F0F4F8"/>' if is_header else ''
                tcPr = f'<w:tcPr>{shd}</w:tcPr>'
                runs = parse_inline_runs(cell_text, base_size=22)
                p = make_paragraph(runs, align="left", space_before=20, space_after=40, line_spacing=260)
                cells_xml.append(f'<w:tc>{tcPr}{p}</w:tc>')
            rows_xml.append(f'<w:tr>{"".join(cells_xml)}</w:tr>')

        return f'<w:tbl>{tbl_pr}{"".join(rows_xml)}</w:tbl>'

    in_table = False
    table_rows = []
    in_code = False
    code_lines = []

    for line in raw_lines:
        s = line.strip()

        # Code block handling
        if s.startswith('```'):
            if in_code:
                in_code = False
                code_text = "\n".join(code_lines)
                code_lines = []
                # Make code paragraph
                lines_runs = []
                for cl in code_text.splitlines():
                    lines_runs.append(make_run(cl, font_size=19, font_family="Consolas", color="2B2B2B"))
                    lines_runs.append('<w:r><w:br/></w:r>')
                p = make_paragraph("".join(lines_runs), align="left", space_before=80, space_after=120, line_spacing=240, left_indent=400)
                body_elements.append(p)
            else:
                in_code = True
                code_lines = []
            continue

        if in_code:
            code_lines.append(line.rstrip())
            continue

        # Table handling
        if s.startswith('|') and '|' in s[1:]:
            if re.match(r'^\|[\s\-:]+(\|[\s\-:]+)+\|$', s):
                continue
            cells = [c.strip() for c in s.split('|')[1:-1]]
            table_rows.append(cells)
            in_table = True
            continue
        elif in_table:
            in_table = False
            body_elements.append(make_table(table_rows))
            table_rows = []

        # Page breaks and spacers
        if s.startswith('---') or s == '\\newpage':
            body_elements.append('<w:p><w:r><w:br w:type="page"/></w:r></w:p>')
            continue

        if s.startswith('<div') or s.startswith('</div>') or s == '<br>':
            continue

        if not s:
            continue

        # Headings
        if s.startswith('# '):
            text = s[2:].strip()
            runs = parse_inline_runs(text, base_size=28) # 14pt
            body_elements.append(make_paragraph(runs, align="center", space_before=240, space_after=160, line_spacing=360))
        elif s.startswith('## '):
            text = s[3:].strip()
            runs = parse_inline_runs(text, base_size=24) # 12pt Bold
            body_elements.append(make_paragraph(runs, align="left", space_before=200, space_after=80, line_spacing=360))
        elif s.startswith('### '):
            text = s[4:].strip()
            runs = parse_inline_runs(text, base_size=24) # 12pt Bold/Italic
            body_elements.append(make_paragraph(runs, align="left", space_before=140, space_after=40, line_spacing=360))
        elif s.startswith('- ') or s.startswith('* '):
            text = s[2:].strip()
            bullet_run = make_run("•  ", bold=True, font_size=24)
            content_runs = parse_inline_runs(text, base_size=24)
            body_elements.append(make_paragraph(bullet_run + content_runs, align="both", space_before=40, space_after=60, line_spacing=360, left_indent=360))
        else:
            # Check if cover page alignment
            runs = parse_inline_runs(s, base_size=24)
            align = "both"
            if "MAKERERE UNIVERSITY" in s or "FACULTY OF COMPUTING" in s or "DESIGN AND DEVELOPMENT" in s or "A Project Report Submitted" in s or "November, 2026" in s:
                align = "center"
            body_elements.append(make_paragraph(runs, align=align, space_before=40, space_after=100, line_spacing=360))

    if in_table and table_rows:
        body_elements.append(make_table(table_rows))

    # Section Properties: Margins: Left 1.25 in (1800 dxa), Right 1.0 in (1440 dxa), Top 1.0 in (1440 dxa), Bottom 1.0 in (1440 dxa)
    sectPr = (
        '<w:sectPr>'
        '<w:pgSz w:w="11906" w:h="16838"/>' # A4 size
        '<w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1800" w:header="720" w:footer="720" w:gutter="0"/>'
        '<w:cols w:space="720"/>'
        '<w:docGrid w:linePitch="360"/>'
        '</w:sectPr>'
    )
    body_elements.append(sectPr)

    document_xml = (
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>\n'
        '<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"'
        ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">\n'
        '<w:body>\n' +
        "\n".join(body_elements) +
        '\n</w:body>\n</w:document>'
    )

    content_types_xml = (
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>\n'
        '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">\n'
        '  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>\n'
        '  <Default Extension="xml" ContentType="application/xml"/>\n'
        '  <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>\n'
        '  <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>\n'
        '</Types>'
    )

    rels_xml = (
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>\n'
        '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">\n'
        '  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>\n'
        '</Relationships>'
    )

    doc_rels_xml = (
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>\n'
        '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">\n'
        '  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>\n'
        '</Relationships>'
    )

    styles_xml = (
        '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>\n'
        '<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">\n'
        '  <w:docDefaults>\n'
        '    <w:rPrDefault>\n'
        '      <w:rPr>\n'
        '        <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:eastAsia="Times New Roman" w:cs="Times New Roman"/>\n'
        '        <w:sz w:val="24"/>\n'
        '        <w:szCs w:val="24"/>\n'
        '        <w:lang w:val="en-US"/>\n'
        '      </w:rPr>\n'
        '    </w:rPrDefault>\n'
        '    <w:pPrDefault>\n'
        '      <w:pPr>\n'
        '        <w:spacing w:line="360" w:lineRule="auto" w:after="120"/>\n'
        '        <w:jc w:val="both"/>\n'
        '      </w:pPr>\n'
        '    </w:pPrDefault>\n'
        '  </w:docDefaults>\n'
        '</w:styles>'
    )

    # Package into docx zip
    with zipfile.ZipFile(docx_path, 'w', zipfile.ZIP_DEFLATED) as z:
        z.writestr('[Content_Types].xml', content_types_xml)
        z.writestr('_rels/.rels', rels_xml)
        z.writestr('word/_rels/document.xml.rels', doc_rels_xml)
        z.writestr('word/styles.xml', styles_xml)
        z.writestr('word/document.xml', document_xml)

    print(f"Successfully created docx file: {docx_path}")

if __name__ == '__main__':
    md = r'c:\Users\HP\kulima-agri-sacco\docs\MUBS_Research_Project_Report.md'
    out = r'c:\Users\HP\kulima-agri-sacco\docs\MUBS_Research_Project_Report.docx'
    create_docx(md, out)
