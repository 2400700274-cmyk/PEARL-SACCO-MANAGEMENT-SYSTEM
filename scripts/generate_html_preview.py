import os
import re
import html

def md_to_html(md_path, html_path):
    with open(md_path, 'r', encoding='utf-8') as f:
        content = f.read()

    lines = content.splitlines()
    body_parts = []
    in_table = False
    table_rows = []
    in_code = False
    code_lines = []

    def format_inline(text):
        # bold
        text = re.sub(r'\*\*(.*?)\*\*', r'<strong>\1</strong>', text)
        # italic
        text = re.sub(r'\*(.*?)\*', r'<em>\1</em>', text)
        return text

    def flush_table(rows):
        if not rows:
            return ""
        out = ['<div class="table-wrap"><table>']
        for idx, row in enumerate(rows):
            tag = 'th' if idx == 0 else 'td'
            row_html = ''.join(f'<{tag}>{format_inline(cell)}</{tag}>' for cell in row)
            out.append(f'<tr>{row_html}</tr>')
        out.append('</table></div>')
        return '\n'.join(out)

    for line in lines:
        s = line.strip()

        # Code block
        if s.startswith('```'):
            if in_code:
                in_code = False
                code_content = html.escape('\n'.join(code_lines))
                body_parts.append(f'<pre><code>{code_content}</code></pre>')
                code_lines = []
            else:
                in_code = True
                code_lines = []
            continue

        if in_code:
            code_lines.append(line)
            continue

        # Tables
        if s.startswith('|') and '|' in s[1:]:
            if re.match(r'^\|[\s\-:]+(\|[\s\-:]+)+\|$', s):
                continue
            cells = [c.strip() for c in s.split('|')[1:-1]]
            table_rows.append(cells)
            in_table = True
            continue
        elif in_table:
            in_table = False
            body_parts.append(flush_table(table_rows))
            table_rows = []

        # Page breaks
        if s.startswith('---') or s == '\\newpage':
            body_parts.append('<div class="page-break"></div>')
            continue

        if s.startswith('<div') or s.startswith('</div>') or s == '<br>':
            continue

        if not s:
            continue

        # Headings
        if s.startswith('# '):
            body_parts.append(f'<h1 class="chapter-title">{format_inline(s[2:])}</h1>')
        elif s.startswith('## '):
            body_parts.append(f'<h2 class="section-title">{format_inline(s[3:])}</h2>')
        elif s.startswith('### '):
            body_parts.append(f'<h3 class="subsection-title">{format_inline(s[4:])}</h3>')
        elif s.startswith('- ') or s.startswith('* '):
            body_parts.append(f'<li class="bullet-item">{format_inline(s[2:])}</li>')
        else:
            cls = 'cover-center' if any(k in s for k in ['MAKERERE UNIVERSITY', 'FACULTY OF COMPUTING', 'DESIGN AND DEVELOPMENT', 'A Project Report Submitted', 'November, 2026']) else 'body-p'
            body_parts.append(f'<p class="{cls}">{format_inline(s)}</p>')

    if in_table and table_rows:
        body_parts.append(flush_table(table_rows))

    html_template = f"""<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>MUBS Research Project Report - Kulima Agri SACCO</title>
<style>
    @page {{
        size: A4;
        margin: 1.0in 1.0in 1.0in 1.25in;
    }}
    body {{
        font-family: "Times New Roman", Times, serif;
        font-size: 12pt;
        line-height: 1.5;
        color: #111;
        background-color: #f8f9fa;
        margin: 0;
        padding: 30px 10px;
    }}
    .document-container {{
        max-width: 820px;
        margin: 0 auto;
        background: #fff;
        padding: 60px 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-radius: 4px;
    }}
    .no-print-bar {{
        max-width: 820px;
        margin: 0 auto 20px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #0078d4;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        font-family: sans-serif;
    }}
    .no-print-bar button {{
        background: white;
        color: #0078d4;
        font-weight: bold;
        border: none;
        padding: 8px 18px;
        border-radius: 4px;
        cursor: pointer;
    }}
    h1.chapter-title {{
        font-size: 14pt;
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
        margin-top: 36px;
        margin-bottom: 18px;
    }}
    h2.section-title {{
        font-size: 12pt;
        font-weight: bold;
        text-align: left;
        margin-top: 24px;
        margin-bottom: 12px;
    }}
    h3.subsection-title {{
        font-size: 12pt;
        font-weight: bold;
        font-style: italic;
        text-align: left;
        margin-top: 18px;
        margin-bottom: 8px;
    }}
    p.body-p {{
        text-align: justify;
        margin: 0 0 12px 0;
        text-indent: 0;
    }}
    p.cover-center {{
        text-align: center;
        margin: 0 0 10px 0;
    }}
    li.bullet-item {{
        margin-left: 24px;
        margin-bottom: 6px;
        text-align: justify;
    }}
    .page-break {{
        border-top: 1px dashed #bbb;
        margin: 40px 0;
        position: relative;
    }}
    .page-break::after {{
        content: "[ Page Break ]";
        position: absolute;
        top: -10px;
        right: 0;
        background: #fff;
        font-size: 9pt;
        color: #888;
        font-family: sans-serif;
        padding-left: 8px;
    }}
    table {{
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 11pt;
    }}
    th, td {{
        border: 1px solid #ddd;
        padding: 8px 12px;
        text-align: left;
    }}
    th {{
        background-color: #f2f4f7;
        font-weight: bold;
    }}
    pre {{
        background-color: #f6f8fa;
        border: 1px solid #e1e4e8;
        border-radius: 4px;
        padding: 14px;
        overflow-x: auto;
        font-family: "Consolas", "Courier New", monospace;
        font-size: 10pt;
        line-height: 1.4;
    }}
    @media print {{
        body {{
            background: none;
            padding: 0;
        }}
        .no-print-bar {{
            display: none !important;
        }}
        .document-container {{
            box-shadow: none;
            padding: 0;
            max-width: 100%;
        }}
        .page-break {{
            page-break-after: always;
            border-top: none;
            margin: 0;
        }}
        .page-break::after {{
            display: none;
        }}
    }}
</style>
</head>
<body>
<div class="no-print-bar">
    <span><strong>MUBS Project Report Preview</strong> (Times New Roman 12pt, 1.5 line spacing)</span>
    <button onclick="window.print()">Print / Save as PDF</button>
</div>
<div class="document-container">
{''.join(body_parts)}
</div>
</body>
</html>
"""
    with open(html_path, 'w', encoding='utf-8') as f:
        f.write(html_template)
    print(f"HTML generated at {html_path}")

if __name__ == '__main__':
    md = r'c:\Users\HP\kulima-agri-sacco\docs\MUBS_Research_Project_Report.md'
    out = r'c:\Users\HP\kulima-agri-sacco\docs\MUBS_Research_Project_Report.html'
    md_to_html(md, out)
