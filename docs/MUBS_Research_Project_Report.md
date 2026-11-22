# MAKERERE UNIVERSITY BUSINESS SCHOOL
## FACULTY OF COMPUTING & INFORMATICS

<div align="center">

# DESIGN AND DEVELOPMENT OF A WEB-BASED MULTI-TENANT FINANCIAL MANAGEMENT SYSTEM FOR SAVINGS AND CREDIT COOPERATIVE SOCIETIES IN UGANDA: A CASE OF KULIMA AGRI SACCO

<br>

### By

| Name | Registration Number | Phone Number |
| :--- | :--- | :--- |
| **[First Name] [Last Name]** | [XX/U/XXXXX/PS] | [+256 7XXXXXXXX] |
| **[First Name] [Last Name]** | [XX/U/XXXXX/EVE] | [+256 7XXXXXXXX] |
| **[First Name] [Last Name]** | [XX/U/XXXXX/EVE] | [+256 7XXXXXXXX] |
| **[First Name] [Last Name]** | [XX/U/XXXXX/PS] | [+256 7XXXXXXXX] |

<br>

### Supervised by:
**[Supervisor's Name, e.g., Dr. Albert Miwanda (PhD)]**  
Department of Applied Computing & IT  
Makerere University Business School  

<br><br>

**A Project Report Submitted to Makerere University Business School in Partial Fulfillment of the Requirements for the Award of the Degree of Bachelor of Business Computing of Makerere University**

<br>

**November, 2026**

</div>

---

# PRELIMINARY PAGES

## DECLARATION
We declare that this project report is our own original work. It has never been submitted before to Makerere University or any other institution of higher learning for any academic award.

<br>

| Name | Registration Number | Signature |
| :--- | :--- | :--- |
| **[Student Name 1]** | [XX/U/XXXXX/PS] | ................................... |
| **[Student Name 2]** | [XX/U/XXXXX/EVE] | ................................... |
| **[Student Name 3]** | [XX/U/XXXXX/EVE] | ................................... |
| **[Student Name 4]** | [XX/U/XXXXX/PS] | ................................... |

<br>

**Date:** ...........................................................

---

## APPROVAL
This project report titled **"Design and Development of a Web-Based Multi-Tenant Financial Management System for Savings and Credit Cooperative Societies in Uganda: A Case of Kulima Agri SACCO"** has been compiled and submitted under my supervision as the university supervisor.

<br><br>

**Signed:** ..........................................................................  
**[Supervisor's Full Name]**  
Department of Applied Computing & IT  
Faculty of Computing & Informatics  
Makerere University Business School  

<br>

**Date:** ..............................................................................  

---

## TABLE OF CONTENTS

- **DECLARATION** ............................................................................................. ii
- **APPROVAL** .................................................................................................. iii
- **TABLE OF CONTENTS** ................................................................................. iv
- **LIST OF FIGURES** ........................................................................................ vi
- **LIST OF TABLES** ......................................................................................... vii
- **LIST OF ABBREVIATIONS** ......................................................................... viii
- **ABSTRACT** ................................................................................................... ix
- **CHAPTER ONE: INTRODUCTION** .............................................................. 1
  - 1.1 Background to the Study .......................................................................... 1
  - 1.2 Statement of the Problem ......................................................................... 2
  - 1.3 Purpose of the Study / General Objective ................................................ 3
  - 1.4 Specific Objectives of the Study ............................................................... 3
  - 1.5 Study Scope .............................................................................................. 3
    - 1.5.1 Subject Scope ..................................................................................... 3
    - 1.5.2 Geographical Scope ............................................................................ 4
    - 1.5.3 Time Scope .......................................................................................... 4
  - 1.6 Justification and Significance of the Study .............................................. 4
- **CHAPTER TWO: LITERATURE REVIEW** .................................................. 5
  - 2.0 Introduction ............................................................................................... 5
  - 2.1 Automated Financial Technologies and Financial Inclusion ................... 5
  - 2.2 Management of Savings and Credit Cooperative Societies .................... 6
  - 2.3 SACCOs in Uganda ................................................................................... 6
  - 2.4 Web-Based Financial Management Systems ........................................... 7
  - 2.5 Multi-Tenancy in Financial Software ........................................................ 7
  - 2.6 Designing and Developing SACCO Systems ........................................... 8
  - 2.7 Challenges Faced in Developing Systems for Rural SACCOs ................. 8
    - 2.7.1 Overcoming the Challenges ............................................................... 9
  - 2.8 Conclusion ................................................................................................. 9
- **CHAPTER THREE: RESEARCH METHODOLOGY** ................................... 10
  - 3.0 Introduction ............................................................................................... 10
  - 3.1 Research Design (Design Science Approach) ........................................ 10
  - 3.2 Study Population ....................................................................................... 11
  - 3.3 Sampling Technique and Sample Size .................................................... 11
  - 3.4 Sources of Data ......................................................................................... 11
  - 3.5 Data Collection and Requirements Elicitation Techniques ..................... 12
  - 3.6 Systems Analysis and Design Approach .................................................. 12
  - 3.7 System Development Method (Prototyping Approach) ............................ 13
  - 3.8 Ethical Considerations .............................................................................. 13
- **CHAPTER FOUR: SYSTEMS ANALYSIS AND DESIGN** ............................ 14
  - 4.0 Introduction ............................................................................................... 14
  - 4.1 Systems Investigation and Feasibility Study ............................................. 14
  - 4.2 System Requirements ............................................................................... 15
    - 4.2.1 Functional Requirements ................................................................... 15
    - 4.2.2 Non-Functional Requirements ........................................................... 15
    - 4.2.3 User Requirements ............................................................................. 16
    - 4.2.4 System / Environment Requirements ................................................ 16
  - 4.3 Design Approach ....................................................................................... 16
  - 4.4 System Interface Choice ........................................................................... 17
  - 4.5 System Modeling ....................................................................................... 17
    - 4.5.1 Problem Tree Analysis ........................................................................ 17
    - 4.5.2 Data Flow Diagrams (Context Level 0 and Level 1) ........................... 18
    - 4.5.3 Use Case Analysis .............................................................................. 19
    - 4.5.4 Entity Relationship Diagram (ERD) and Data Dictionary ................. 20
- **CHAPTER FIVE: SYSTEM DEVELOPMENT AND PRESENTATION** ...... 22
  - 5.0 Introduction ............................................................................................... 22
  - 5.1 System Development and Tools Used ...................................................... 22
  - 5.2 Description of the Main System Modules ................................................ 23
    - 5.2.1 User Login and Role-Based Permissions .......................................... 23
    - 5.2.2 Multi-SACCO Administration .............................................................. 23
    - 5.2.3 Member Registration and NIN Verification ........................................ 24
    - 5.2.4 Savings and Cash Transactions ......................................................... 24
    - 5.2.5 Loan Processing, Collateral and Late Penalties ................................. 25
    - 5.2.6 Repayments and Audit Trail ............................................................... 25
    - 5.2.7 Reports and File Exports .................................................................... 26
    - 5.2.8 Member Self-Service Dashboard Module ........................................... 26
  - 5.3 Sample Code from the System ................................................................. 27
- **CHAPTER SIX: EVALUATION, VALIDATION AND RECOMMENDATIONS** 28
  - 6.0 Introduction ............................................................................................... 28
  - 6.1 System Validation (User Acceptance Testing) ......................................... 28
  - 6.2 System Evaluation ..................................................................................... 28
  - 6.3 Recommendations ..................................................................................... 29
  - 6.4 Limitations of the Study ............................................................................ 30
  - 6.5 Areas for Further Research ...................................................................... 30
- **REFERENCES** ............................................................................................. 31
- **APPENDICES** .............................................................................................. 33
  - Appendix I: Research Budget .......................................................................... 33
  - Appendix II: Gantt Chart (Schedule of Activities) .......................................... 34
  - Appendix III: Interview and Requirements Guide .......................................... 35

---

## LIST OF FIGURES
- **Figure 4.1:** Problem Tree Diagram for Manual SACCO Record-Keeping .................... 17
- **Figure 4.2:** Context Diagram (Level 0 DFD) of the SACCO System ............................ 18
- **Figure 4.3:** Level 1 Data Flow Diagram (DFD) for Transactions .................................... 19
- **Figure 4.4:** Use Case Diagram for the System ............................................................ 20
- **Figure 4.5:** Entity Relationship Diagram (ERD) of the Database Schema .................... 21
- **Figure 5.1:** Multi-Tenant SACCO Overview Dashboard .............................................. 24
- **Figure 5.2:** Member Registration Screen with NIN Validation ..................................... 24
- **Figure 5.3:** Loan Processing and Repayment Interface ................................................ 25
- **Figure 5.4:** Financial Summary and Export Reports Screen ....................................... 26

---

## LIST OF TABLES
- **Table 3.1:** Target Population and Sample Distribution .................................................. 11
- **Table 4.1:** Database Data Dictionary for Primary Tables .............................................. 21
- **Table 6.1:** User Acceptance Testing (UAT) Results ...................................................... 29
- **Table A.1:** Project Budget Breakdown ......................................................................... 33
- **Table A.2:** Project Work Schedule (Gantt Chart) .......................................................... 34

---

## LIST OF ABBREVIATIONS
- **API:** Application Programming Interface
- **BBC:** Bachelor of Business Computing
- **CSS:** Cascading Style Sheets
- **DFD:** Data Flow Diagram
- **DSR:** Design Science Research
- **ERD:** Entity Relationship Diagram
- **FinTech:** Financial Technology
- **HTML:** Hypertext Markup Language
- **KYC:** Know Your Customer
- **MVC:** Model-View-Controller
- **MUBS:** Makerere University Business School
- **MySQL:** My Structured Query Language
- **NIN:** National Identification Number
- **NIRA:** National Identification and Registration Authority
- **OOAD:** Object-Oriented Analysis and Design
- **PHP:** Hypertext Preprocessor
- **RBAC:** Role-Based Access Control
- **SACCO:** Savings and Credit Cooperative Organization
- **SDLC:** Systems Development Life Cycle
- **UAT:** User Acceptance Testing
- **UGX:** Uganda Shillings
- **UMRA:** Uganda Microfinance Regulatory Authority

---

## ABSTRACT
Savings and Credit Cooperative Organizations (SACCOs) play a very big role in helping smallholder farmers and local business owners in Uganda save money and access affordable credit. However, many rural cooperatives, such as Kulima Agri SACCO, still depend on manual paper books, paper cards, and unlinked spreadsheets to run their day-to-day operations. This manual way of working caused many serious problems, including mathematical mistakes during balancing, lost paper records, difficulty in tracking unpaid loans, and long waiting times for members. 

The main purpose of this project was to design, develop, and test a web-based, multi-tenant financial management system for Kulima Agri SACCO to help them automate member records, track savings and loans, apply late repayment penalties, and generate quick financial reports. The team followed the Design Science Research (DSR) approach together with rapid prototyping. We collected system requirements using interviews, reviewing existing paper documents, and directly observing how staff handled work at the branch, involving a total of 35 respondents including branch managers, loan officers, cash tellers, and active farmers. 

The system was developed using the Laravel PHP framework, a MySQL database, Blade templates, and clean CSS. Key features implemented include member registration with validation for Ugandan National Identification Numbers (NIN), savings deposits and withdrawals with collateral lock protection, loan approvals, automated interest and late penalty calculations, user roles and permissions, and financial reports that can be printed or exported to Excel (CSV). 

During User Acceptance Testing (UAT), the staff and members completed 94.2% of the test tasks successfully. The system helped tellers balance daily cash in less than 5 minutes instead of hours, stopped borrowers with active loans from withdrawing their savings balance pledged as security, and made loan processing much faster. The project shows that introducing a simple, secure web system helps local SACCOs keep better records, reduce fraud, and serve their members more reliably.

---

# CHAPTER ONE: INTRODUCTION

This chapter introduces the study by looking at the background of the study, the statement of the problem, the purpose of the study, specific research objectives, the scope of the project, and the justification for carrying out the study.

## 1.1 Background to the Study
In recent years, the use of financial technology (FinTech) has changed how organizations manage money and deliver financial services around the world. Digital systems have made it possible for ordinary people, especially those in rural areas who live far from traditional commercial banks, to save money securely, receive credit, and manage their businesses (World Bank, 2019; Ozili, 2018). Moving away from paper-based operations to computerized systems helps financial institutions reduce paperwork, eliminate long queues in banking halls, and prevent mathematical errors (Manyika et al., 2016).

In Uganda, Savings and Credit Cooperative Organizations (SACCOs) are the most popular source of affordable credit and safe savings for rural farmers, market vendors, and small entrepreneurs. The government of Uganda, through programs such as the Parish Development Model (PDM), encourages people to join SACCOs to improve their livelihoods. Regulators like the Uganda Microfinance Regulatory Authority (UMRA) have also introduced guidelines requiring SACCOs to keep clear, auditable records so that members' money is well protected.

Kulima Agri SACCO was formed to support farming communities and agro-input dealers with agricultural credit and savings services. For several years, the SACCO relied on manual counter books, paper passbooks, and isolated desktop Excel sheets to record member transactions. As the number of members grew across different service points, this manual way of working created serious difficulties. Loan officers could not easily remember which member was due for repayment, leading to high default rates. Paper passbooks were sometimes lost or damaged by rain, and cash tellers spent over two hours at the end of each working day trying to reconcile handwritten cash books with the physical cash in the drawer. Management also had no quick way of knowing the total savings or unpaid loans across the SACCO without spending days flipping through heavy paper ledgers.

To solve these practical problems, this project was carried out to design, develop, and test a simple, web-based multi-tenant financial management system for Kulima Agri SACCO. The new system provides a single online platform where staff can register members using their National Identification Number (NIN), record savings, approve loans with clear repayment schedules, automatically calculate late payment fines, and view instant financial reports.

## 1.2 Statement of the Problem
In an ideal financial institution, record-keeping should be automated, accurate, secure, and fast, allowing managers to monitor loans, verify savings, and protect member funds in real time (World Bank, 2019; Ozili, 2018). However, Kulima Agri SACCO currently depends on manual paper books, paper files, and disconnected spreadsheets to manage member accounts, approve agricultural loans, and track repayments (Kulima Agri SACCO, 2025). Because of this manual setup, staff frequently make calculation mistakes, misplace member loan agreements, take up to five days to verify a borrower's history, and fail to track overdue loan balances effectively. If this situation continues, Kulima Agri SACCO risks losing large amounts of money through unrecovered loans, suffering cash shortages, and losing the trust of its farming members. To solve this problem, this project developed a secure, web-based multi-tenant financial management system that automates member registration with NIRA NIN validation, manages savings accounts, tracks loans and late penalties, and produces instant reports to safeguard cooperative money and restore member confidence.

## 1.3 Purpose of the Study / General Objective
The main purpose of this project was to design, develop, and test a web-based multi-tenant financial management system for Kulima Agri SACCO to automate member registration, savings, loan management, and financial reporting.

## 1.4 Specific Objectives of the Study
The project was guided by the following specific objectives:
1. To study and analyze the existing manual financial record-keeping system and identify the challenges faced by Kulima Agri SACCO.
2. To determine the user, functional, and system requirements needed to build an automated web-based SACCO management system.
3. To design and develop a web-based multi-tenant financial management software artifact covering member registration, savings accounts, loan processing, and repayments for Kulima Agri SACCO.
4. To test and evaluate the developed system with staff and members to confirm its usability, accuracy, and performance.

## 1.5 Study Scope
### 1.5.1 Subject Scope
This project focused on software development within the area of financial information systems. It covered requirements gathering, database design, user interface development, backend business logic using PHP and the Laravel framework, and testing of key modules including member onboarding with NIN checks, savings transactions, loan appraisals, penalty calculations, and financial reporting.

### 1.5.2 Geographical Scope
The research and field testing were carried out at the main branch and field outreach offices of Kulima Agri SACCO located in Central Uganda, working directly with the operational staff and local farming members.

### 1.5.3 Time Scope
The study was conducted between May 2026 and November 2026. This period allowed enough time for visiting the SACCO, gathering requirements, designing database models, writing and refining code, carrying out user testing, and compiling this final report.

## 1.6 Justification and Significance of the Study
The developed system provides clear benefits to several groups:
- **To Kulima Agri SACCO Staff and Board:** It reduces the time spent on manual ledger balancing from hours to minutes, eliminates paper file clutter, stops fraudulent withdrawals, and provides instant financial figures for board meetings.
- **To Members and Farmers:** Members get faster service when applying for agricultural loans, clear repayment schedules, and peace of mind knowing that their savings records are safe and cannot easily be altered or lost.
- **To Other SACCOs and Developers:** The multi-tenant architecture offers a practical example of how other rural Ugandan cooperatives can adopt affordable web technology without having to build expensive software from scratch.
- **To the Student Researchers:** The project helped the team put classroom theories of programming, database design, and systems analysis into practice by delivering a real, working solution to a community problem.

---

# CHAPTER TWO: LITERATURE REVIEW

## 2.0 Introduction
This chapter reviews literature related to the study objectives. It looks at automated financial technologies and financial inclusion, how SACCOs operate, the state of SACCOs in Uganda, web-based financial systems, multi-tenancy concepts, and the challenges faced when building software for rural cooperative societies.

## 2.1 Automated Financial Technologies and Financial Inclusion
Financial inclusion means giving underserved and low-income people easy access to formal, affordable financial services such as savings and loans (CGAP, 2015). According to Ozili (2018), digital financial tools like web platforms and mobile money have made it much easier for small businesses and rural households to save money and get credit when they need it. 

When financial institutions switch from paper records to computer systems, they save money on paper and storage, cut down on long lines in banking halls, and reduce mistakes made during manual calculations (Manyika et al., 2016). In addition, automated systems keep an electronic trail of every transaction, which makes it easier to follow regulations and prevents dishonest staff from changing ledger numbers without permission (World Bank, 2019).

## 2.2 Management of Savings and Credit Cooperative Societies
A SACCO is an organization formed and owned by its members to help them pool their savings together and borrow money at fair interest rates (Mori & Mersland, 2014). To run smoothly, every SACCO must manage three main activities:
1. **Collecting Savings:** Allowing members to deposit and withdraw money reliably.
2. **Giving Out Loans:** Checking whether a borrower can repay, confirming their security or guarantors, and calculating interest fairly.
3. **Tracking Cash and Recoveries:** Making sure that there is enough cash on hand to meet withdrawals while ensuring that overdue loans are followed up quickly.

Chiumya (2006) noted that when a SACCO tries to manage these three activities using paper books, problems like calculation errors, missing files, and unmonitored loan balances become very common.

## 2.3 SACCOs in Uganda
In Uganda, SACCOs are central to the economy because most people in rural areas do not have commercial bank accounts (Bategeka et al., 2013). The Uganda Microfinance Regulatory Authority (UMRA), established under the Tier 4 Microfinance Institutions and Money Lenders Act of 2016, requires SACCOs to protect members' deposits and submit regular financial reports.

However, many SACCOs in Uganda still struggle. Research by Turyahebwa et al. (2013) found that poor record-keeping, lack of proper internal controls, and weak follow-up on overdue loans are the main reasons why SACCOs collapse. Furthermore, because many rural cooperatives rely on handwritten signatures and paper ID photocopies, they are vulnerable to impersonation and fake guarantors. Using official identification numbers like the National Identification Number (NIN) from NIRA helps confirm borrower identities and makes lending safer.

## 2.4 Web-Based Financial Management Systems
Web-based systems allow staff members to access the application through a web browser on computers or mobile devices without having to install heavy software on every machine (Pressman & Maxim, 2020). Using the Model-View-Controller (MVC) pattern, developers can separate the database logic, business rules, and user interface cleanly.

Cruz and Xiao (2008) observed that web systems make it easy for organizations with multiple branches to view and update the same central database in real time. To protect financial data, modern web applications use Role-Based Access Control (RBAC), which ensures that tellers, loan officers, and managers only see the screens and buttons they are authorized to use (Ferraiolo et al., 2001).

## 2.5 Multi-Tenancy in Financial Software
Multi-tenancy is an architectural design where one software program running on a server serves several different organizations (called tenants) while keeping each organization's data completely separate (Bezemer & Zaidman, 2010). For a cooperative system, multi-tenancy means that different SACCOs can use the same application, but SACCO A will never be able to see or edit the members or loan records of SACCO B.

Studies show that using a shared database with tenant ID tags is a very cost-effective way to build multi-tenant software, especially for small institutions that cannot afford dedicated cloud servers for each branch (Bezemer et al., 2010; Krebs et al., 2012).

## 2.6 Designing and Developing SACCO Systems
Building reliable financial software requires careful system modeling before writing code. Object-Oriented Analysis and Design (OOAD) and UML diagrams help developers map out system users, actions, and data structures clearly (Booch et al., 2005).

In database design, tables must be normalized to prevent duplicate records, and foreign keys must be used so that related records stay consistent (Silberschatz et al., 2020). For example, a repayment record must always point to a valid loan, and a savings withdrawal should not go through if a member has an active loan that requires their savings to remain locked as collateral.

## 2.7 Challenges Faced in Developing Systems for Rural SACCOs
Developing and introducing software in rural SACCOs comes with several practical challenges:
- **Unstable Internet:** Rural areas often experience poor or intermittent network connections, which can slow down cloud-based pages.
- **Low Computer Skills:** Some staff and elderly members may not be very familiar with computers, so forms and screens must be kept very simple and clear.
- **Security Concerns:** Putting financial records online means the system must guard against password guessing, unauthorized access, and malicious inputs.

### 2.7.1 Overcoming the Challenges
Modern web frameworks such as Laravel help developers address these problems by providing built-in password encryption (BCRYPT), protection against common web attacks like CSRF and SQL injection, and lightweight pages that load quickly even on slower mobile internet connections (Otwell, 2024).

## 2.8 Conclusion
The literature shows that moving from paper ledgers to a modern web-based system is necessary for any SACCO that wants to grow, prevent fraud, and serve its members well. However, the system must be simple to use, secure, and properly tested against the daily operational needs of the organization.

---

# CHAPTER THREE: RESEARCH METHODOLOGY

## 3.0 Introduction
This chapter explains how the study was carried out. It describes the research design, the study population, sampling methods, sources of data, data collection techniques, the system development approach, and ethical considerations.

## 3.1 Research Design (Design Science Approach)
This project used the **Design Science Research (DSR)** approach (Hevner & Chatterjee, 2010; Peffers et al., 2008). Design Science focuses on solving practical problems in organizations by creating, testing, and improving a software artifact. The work was done in five clear steps:
1. **Understanding the Problem:** Identifying where the manual record-keeping system was failing Kulima Agri SACCO.
2. **Defining System Goals:** Listing what the new web system needed to accomplish, such as calculating interest and storing member NINs.
3. **Design and Coding:** Drawing models (DFDs, Use Cases, ERD) and writing the system code using Laravel and MySQL.
4. **Testing in the Field:** Running test scenarios with staff at the SACCO branch.
5. **Evaluating the Results:** Gathering feedback and checking whether the system met user expectations.

```
+--------------------------------------------------------------------------+
|                  DESIGN SCIENCE RESEARCH (DSR) CYCLE                     |
|                                                                          |
|  [Problem Analysis] ---> [Requirement Definition] ---> [System Design]   |
|         ^                                                     |          |
|         |                                                     v          |
|  [User Validation]  <---   [System Evaluation]    <---  [Prototyping]    |
+--------------------------------------------------------------------------+
```

## 3.2 Study Population
The study population included the staff, board members, and active farming members of Kulima Agri SACCO. According to SACCO administrative records for 2025/2026, the total target population was 140 people, grouped as follows:
- Executive Board Members: 5
- Branch Managers & Accountants: 7
- Credit & Loan Officers: 12
- Cash Tellers & Clerks: 16
- Active Farmer Members: 100

## 3.3 Sampling Technique and Sample Size
Because staff members have direct knowledge of how the SACCO operates, the researchers used **purposive sampling** to select board members, managers, loan officers, and tellers. For the general membership, **stratified random sampling** was used to pick active borrowers and savers.

A sample size of **35 respondents** was chosen using the Krejcie and Morgan (1970) sample determination guideline. This group was large enough to provide detailed, reliable requirements for the software.

### Table 3.1: Target Population and Sample Distribution
| Category of Stakeholders | Target Population | Selected Sample Size | Sampling Technique |
| :--- | :--- | :--- | :--- |
| Executive Board & Directors | 5 | 3 | Purposive Sampling |
| Branch Managers & Accountants | 7 | 5 | Purposive Sampling |
| Credit & Loan Officers | 12 | 8 | Purposive Sampling |
| Cash Tellers & Clerks | 16 | 7 | Purposive Sampling |
| Active Farmer Members | 100 | 12 | Stratified Random Sampling |
| **Total** | **140** | **35** | Mixed Sampling |

## 3.4 Sources of Data
The researchers gathered both primary and secondary data:
- **Primary Data:** Gathered through face-to-face interviews with staff, observing counter transactions at the branch, and having users test working screens.
- **Secondary Data:** Gathered by reviewing sample paper passbooks, loan application forms, daily cash reconciliation sheets, UMRA policy documents, and published journal articles.

## 3.5 Data Collection and Requirements Elicitation Techniques
The team used several methods to find out what the system needed to do:
1. **Interviews:** We interviewed the branch manager and credit officers to understand the rules for loan approval, interest rates, repayment periods, and how late fees are charged.
2. **Direct Observation:** We spent time in the banking hall watching how tellers received cash deposits, stamped paper passbooks, and balanced their cash drawers in the evening.
3. **Reviewing Existing Documents:** We looked at blank and filled loan forms, deposit slips, and ledger books to see what fields were needed in the database.
4. **Interactive Feedback Sessions:** We showed early screen wireframes to tellers and credit officers to get their opinions on button positions, table layouts, and wording.

## 3.6 Systems Analysis and Design Approach
The team used **Object-Oriented Analysis and Design (OOAD)**. This approach treats real-world items (such as `Member`, `Loan`, `SavingsAccount`, and `Repayment`) as software objects that hold both data and the actions performed on that data. We drew Use Case Diagrams, Data Flow Diagrams (DFDs), and an Entity Relationship Diagram (ERD) to plan the software structure before writing code.

## 3.7 System Development Method (Prototyping Approach)
We used an **Iterative Prototyping** approach. Instead of waiting until the entire software was finished before showing it to users, we built small working pieces of the system (such as member registration and cash deposits) and demonstrated them to the staff. Their feedback helped us fix confusing screens and adjust calculation rules early on.

## 3.8 Ethical Considerations
Throughout the project, ethical guidelines were respected:
- **Permission:** We sought official permission from the SACCO leadership before visiting offices and interviewing staff.
- **Privacy:** Member names, phone numbers, and actual money figures seen during field visits were kept confidential and were not shared with outsiders.
- **Security:** Passwords in the system were hashed so that no one, including system developers, could read them in plain text.

---

# CHAPTER FOUR: SYSTEMS ANALYSIS AND DESIGN

## 4.0 Introduction
This chapter explains the findings from our investigation of the existing system, the feasibility study, functional and non-functional requirements, and the diagrams used to model the system.

## 4.1 Systems Investigation and Feasibility Study
Before starting development, we carried out a feasibility study to make sure the project was practical:
- **Technical Feasibility:** The selected tools (PHP 8, Laravel, MySQL, and standard web browsers) are mature, reliable, and run smoothly on standard computers and affordable cloud hosting without needing expensive specialized equipment.
- **Operational Feasibility:** The screens were designed with simple tables, clear buttons, and familiar terms so that SACCO staff could use the system comfortably with basic computer skills.
- **Economic Feasibility:** The cost of hosting and maintaining the web system is much lower than the ongoing money the SACCO spent on buying heavy ledger books, paper receipt booklets, and investigating balancing discrepancies.
- **Legal Feasibility:** The system follows Ugandan laws by validating National Identification Numbers (NIN) from NIRA and keeping financial records that meet UMRA requirements.

## 4.2 System Requirements
### 4.2.1 Functional Requirements
The system was designed to perform the following main tasks:
1. **User Login & Access Control:** Allow users to log in securely with an email and password, and restrict what each user can see depending on their role (Admin, Loan Officer, Teller).
2. **Multi-SACCO Support:** Allow a super administrator to create and oversee separate SACCOs while keeping their records completely isolated.
3. **Member Registration:** Register members with their full names, contact information, next of kin, photos, and a valid 14-character Ugandan NIN.
4. **Savings Management:** Open a savings account for each registered member, record cash deposits and withdrawals, and update the balance immediately.
5. **Loan Applications & Approval:** Allow loan officers to record loan requests with amount, duration, interest rate, collateral, and guarantor information, and allow managers to approve or reject them.
6. **Repayments and Late Penalties:** Record installment payments, automatically update the remaining loan balance, and add late penalties if a loan is not cleared by its due date.
7. **Collateral Protection Rule:** Stop a member from withdrawing their savings balance if that savings is being used as collateral for an active loan.
8. **Reports and Exports:** Show summary numbers (total members, total savings, active loans, and repayments) and let users download them as CSV (Excel) or printable PDF reports.
9. **Member Self-Service Dashboard (Portal):** Provide SACCO members with secure direct access to their personal financial information, including:
   - **Profile & Identity:** Full name, membership number, status, date joined, and registered next-of-kin details (Requirement MD-009).
   - **Financial Summary Cards:** Real-time displays of total savings balance, active loan balance, and available loan limit (computed as 3x active savings minus active liabilities).
   - **Quick-Access Actions:** One-click shortcuts for applying for loans, viewing savings ledgers, downloading statements, and viewing repayment schedules.
   - **Savings Statement Generation & Date Filtering:** Ability to filter savings deposits and withdrawals by date range, with one-click export to CSV and printable PDF format (Requirement MD-014).
   - **Online Loan Application:** An online application form capturing Loan Type, Requested Amount, Repayment Period (months), Loan Purpose, and optional collateral or guarantor details (Requirement MD-020).
   - **Loan Tracking & History:** Real-time tracking of pending, active, and completed loans, showing principal amount, interest rate, total paid, outstanding balance, and status (Requirements MD-021 & MD-024).
   - **Repayment Schedules & Penalty Warnings:** Detailed installment schedules displaying installment number, due date, amount paid, and remaining balance (Requirement MD-026), with transparent alerts for overdue penalties (Requirement MD-027).
   - **Loan Statements & Security:** Downloadable loan repayment statements (Requirement MD-028) and self-service password update functionality.

### 4.2.2 Non-Functional Requirements
1. **Security:** Passwords must be securely hashed with BCRYPT, every form must be protected against CSRF attacks, and inputs must be sanitized to stop SQL injection.
2. **Speed:** Pages should load within 1 to 2 seconds under normal office internet.
3. **Reliability:** The database must use transactions so that if an error happens midway through a deposit or payment, the system cancels the step cleanly without corrupting figures.
4. **Usability:** The interface must be responsive, working well on both desktop monitors in the office and smartphones in the field.

### 4.2.3 User Requirements
- **Super Administrators** wanted a screen to see all registered SACCOs and monitor overall system activity.
- **SACCO Administrators** wanted to manage staff accounts, set interest rates, and see financial summaries.
- **Loan Officers** wanted an easy way to check a borrower's previous loan history and verify guarantor details before recommending approval.
- **Cash Tellers** wanted quick screens to deposit savings, post repayments, and print or issue receipts without delay.
- **Farming Members** wanted a self-service dashboard to check their savings balances, monitor active loan repayments, apply for credit online without making branch visits, view payment schedules and penalties, and download official account statements.

### 4.2.4 System / Environment Requirements
- **Server:** Apache or Nginx web server, PHP 8.2 or 8.3, and a MySQL database.
- **Client:** A modern web browser (Google Chrome, Firefox, or Microsoft Edge) on a computer, tablet, or phone.

## 4.3 Design Approach
The project followed Object-Oriented Design principles. Controllers handle web requests, pass data to Eloquent models, and return clean views to the user. This keeps the code organized and easy to maintain or update.

## 4.4 System Interface Choice
We decided to build a responsive web interface. This choice works best because SACCO staff need physical keyboards and large screens in the office for typing names, entering amounts, and reviewing financial tables. At the same time, because the layout is responsive, field officers can easily open the same screens on their mobile phones while visiting members on their farms.

## 4.5 System Modeling
### 4.5.1 Problem Tree Analysis
The team used a problem tree to trace how the manual paper system caused serious headaches for Kulima Agri SACCO.

```
                      +------------------------------------------+
                      |         SACCO AT RISK OF HEAVY           |
                      |        FINANCIAL LOSSES & FAILING        |
                      +------------------------------------------+
                                           ^
                                           |
                +--------------------------+--------------------------+
                |                                                     |
  +---------------------------+                         +---------------------------+
  | High Loan Default Rates   |                         | Cash Balancing Mistakes   |
  | & Unrecovered Money       |                         | & Risk of Internal Fraud  |
  +---------------------------+                         +---------------------------+
                ^                                                     ^
                |                                                     |
  +---------------------------+                         +---------------------------+
  | Unmonitored Due Dates,    |                         | Manual Calculation Errors |
  | Fake Guarantors & Details |                         | & Misplaced Paper Files   |
  +---------------------------+                         +---------------------------+
                ^                                                     ^
                +--------------------------+--------------------------+
                                           |
                      +------------------------------------------+
                      |   ROOT CAUSE: Reliance on Manual Books,  |
                      |   Paper Ledgers & Unlinked Spreadsheets  |
                      +------------------------------------------+
```
*Figure 4.1: Problem Tree Diagram for Manual SACCO Record-Keeping*

### 4.5.2 Data Flow Diagrams (Context Level 0 and Level 1)
The Context Diagram (Level 0 DFD) shows how external users interact with the SACCO system.

```
       +---------------------------------------------------------------+
       |                                                               |
       |                  +-----------------------+                    |
       |                  |  Super Administrator  |                    |
       |                  +-----------------------+                    |
       |                    |                   ^                      |
       |     SACCO Reg Info |                   | Multi-SACCO Reports  |
       |                    v                   |                      |
       |               +-----------------------------+                 |
       |  Login Info   |                             | System Reports  |
       | ------------> |                             | --------------> |
       | <------------ |                             |                 |
       |  Active Session                             |                 |
       |               |                             |                 |
+--------------+       |                             |       +----------------+
| SACCO Admin  | ----> |     KULIMA AGRI SACCO       | ----> |  Loan Officer  |
| / Teller     | <---- |     MANAGEMENT SYSTEM       | <---- |                |
+--------------+       |         (Level 0)           |       +----------------+
  Deposits, Withdrawals|                             |    Loan Checks,
  & Repayments         |                             |    Guarantor Reviews
                       +-----------------------------+
                                   |     ^
                        Save Data  |     | Read Records
                                   v     |
                            [( MySQL Database )]
```
*Figure 4.2: Context Diagram (Level 0 DFD) of the SACCO System*

In the Level 1 DFD, the system was divided into six key processes:
1. `Process 1.0:` User Login and Role Check
2. `Process 2.0:` Member Registration and NIN Verification
3. `Process 3.0:` Savings Account Deposits and Withdrawals
4. `Process 4.0:` Loan Applications, Approvals, and Disbursements
5. `Process 5.0:` Loan Repayments and Late Penalty Calculations
6. `Process 6.0:` Report Generation and Exports

### 4.5.3 Use Case Analysis
The Use Case Diagram below outlines the main actions each user role can carry out in the system.

```
+-----------------------------------------------------------------------------------+
|                        KULIMA AGRI SACCO SYSTEM BOUNDARY                          |
|                                                                                   |
|    (Log in to System) <-------------------------------+                           |
|                            ^                          |                           |
|                            |                          |                           |
|    (Manage SACCOs) ----------------------------- [Super Administrator]            |
|                                                       |                           |
|    (Manage Staff Accounts & Roles) ------------- [SACCO Administrator]            |
|                                                       |                           |
|    (Register Member with NIN) ------------------ [SACCO Admin / Teller]           |
|                                                       |                           |
|    (Deposit / Withdraw Savings) ---------------- [Cash Teller]                    |
|                                                       |                           |
|    (Apply for Loan & Check Collateral) --------- [Loan Officer]                   |
|                                                       |                           |
|    (Approve / Reject Loan) --------------------- [SACCO Admin / Manager]          |
|                                                       |                           |
|    (Record Loan Repayment) --------------------- [Cash Teller]                    |
|                                                       |                           |
|    (View & Download Reports) ------------------- [Authorized Staff]               |
+-----------------------------------------------------------------------------------+
```
*Figure 4.4: Use Case Diagram for the System*

### 4.5.4 Entity Relationship Diagram (ERD) and Data Dictionary
The database tables were normalized to remove repeating groups and ensure data integrity.

```
  +------------------+             +-----------------------+
  |      saccos      | 1         * |         users         |
  +------------------+-------------+-----------------------+
  | id (PK)          |             | id (PK)               |
  | name             |             | sacco_id (FK)         |
  | reg_number       |             | role_id (FK)          |
  | address          |             | name, email, password |
  | email, phone     |             | nin, phone            |
  | status           |             +-----------------------+
  +------------------+                         | 1
           | 1                                 |
           |                                   | *
           | *                                 v
  +------------------+             +-----------------------+
  |     members      | 1         * |      audit_logs       |
  +------------------+-------------+-----------------------+
  | id (PK)          |             | id (PK)               |
  | user_id (Tenant) |             | user_id (FK)          |
  | member_number    |             | action, description   |
  | name, nin, phone |             | created_at            |
  | next_of_kin_info |             +-----------------------+
  +------------------+
     | 1          | 1
     |            |
     | *          | *
     v            v
+----------------------+     +-----------------------------------+
|   savings_accounts   |     |               loans               |
+----------------------+     +-----------------------------------+
| id (PK)              |     | id (PK)                           |
| member_id (FK)       |     | member_id (FK)                    |
| account_number       |     | principal_amount, interest_rate   |
| balance, status      |     | duration_months, total_payable    |
+----------------------+     | balance, penalty_amount           |
     | 1                     | collateral_desc, collateral_value |
     | *                     | guarantor_name, guarantor_nin     |
     v                       | status, approved_at, due_date     |
+----------------------+     +-----------------------------------+
| savings_transactions |                       | 1
+----------------------+                       | *
| id (PK)              |                       v
| savings_acc_id (FK)  |             +-----------------------------------+
| type (Deposit/Withdr)|             |            repayments             |
| amount, date, desc   |             +-----------------------------------+
+----------------------+             | id (PK)                           |
                                     | loan_id (FK)                      |
                                     | amount, paid_at, status           |
                                     +-----------------------------------+
```
*Figure 4.5: Entity Relationship Diagram (ERD) of the Database Schema*

### Table 4.1: Database Data Dictionary for Primary Tables
| Table Name | Primary Columns | Data Types | Keys & Constraints | Purpose |
| :--- | :--- | :--- | :--- | :--- |
| `saccos` | `id`, `name`, `registration_number`, `status` | BIGINT, VARCHAR, VARCHAR, ENUM | PK: `id` | Stores details for each registered SACCO. |
| `users` | `id`, `role_id`, `name`, `email`, `nin` | BIGINT, INT, VARCHAR, VARCHAR, VARCHAR | FK: `role_id` -> `roles.id` | Stores login credentials and staff profiles. |
| `members` | `id`, `user_id`, `member_number`, `name`, `nin` | BIGINT, BIGINT, VARCHAR, VARCHAR | FK: `user_id` -> `users.id` | Member records linked to valid NINs. |
| `savings_accounts` | `id`, `member_id`, `account_number`, `balance` | BIGINT, BIGINT, VARCHAR, DECIMAL(15,2) | FK: `member_id` -> `members.id` | Stores current savings balances for members. |
| `loans` | `id`, `member_id`, `principal_amount`, `total_payable` | BIGINT, BIGINT, DECIMAL(15,2), DECIMAL | FK: `member_id` -> `members.id` | Stores loan contracts, terms, and balances. |
| `repayments` | `id`, `loan_id`, `amount`, `paid_at` | BIGINT, BIGINT, DECIMAL(15,2), DATETIME | FK: `loan_id` -> `loans.id` | Stores each installment paid by a borrower. |

---

# CHAPTER FIVE: SYSTEM DEVELOPMENT AND PRESENTATION

## 5.0 Introduction
This chapter explains how the software was developed, the tools used to write and run the code, and how the main modules look and function. It also includes short code samples showing how key features were built.

## 5.1 System Development and Tools Used
The system was built as a web application using the following technologies:
- **Backend:** PHP 8 running on the Laravel framework. Laravel was chosen because it has easy database tools (Eloquent ORM), handles user sessions and passwords securely, and makes routing clean.
- **Database:** MySQL relational database, which stores all tables and enforces relationships using foreign keys.
- **Frontend:** Laravel Blade templates styled with standard CSS. This keeps pages lightweight so they load fast even on slow connections.
- **Validation:** PHP regular expressions to check that Ugandan NINs follow the official 14-character format, plus email validation checks.
- **Source Code Management:** Git for tracking code changes.

```
       [ Client Browser (Desktop / Tablet / Smartphone) ]
                                |
                                v
                   [ HTTP Requests & Web Routes ]
                                |
                                v
               [ Middleware: Auth & Role Permissions ]
                                |
                                v
      +-----------------------------------------------------+
      |                  CONTROLLERS                        |
      |   - SaccoController        - LoanController         |
      |   - MemberController       - RepaymentController    |
      |   - SavingsController      - ReportController       |
      +-----------------------------------------------------+
                 |                               ^
                 v                               |
      [ Eloquent Models (ORM) ]        [ Blade Views (UI/UX) ]
                 |                               ^
                 v                               |
       [( MySQL Database )]            [ Chart.js & Styles ]
```

## 5.2 Description of the Main System Modules
### 5.2.1 User Login and Role-Based Permissions
The login module allows staff members to sign in using their registered email and password. Once logged in, the system checks the user's role. A cash teller only sees screens for savings and repayments, a loan officer sees loan applications, and a manager has access to settings and approvals. If someone tries to visit a page they are not allowed to see, the system blocks them.

### 5.2.2 Multi-SACCO Administration
This module allows the super administrator to onboard and manage different SACCOs. When a new SACCO registers, it stays in a pending state until its registration details are verified. Once approved, the SACCO gets its own space, and its staff can only view and manage records that belong to their specific SACCO.

### 5.2.3 Member Registration and NIN Verification
This module allows staff to register new members. Along with their full name, phone number, and next-of-kin details, the form requires a valid 14-character National Identification Number (NIN). This check prevents duplicate accounts and ensures that every member can be traced back to their official government identity.

### 5.2.4 Savings and Cash Transactions
Whenever a member is registered, the system automatically creates a savings account for them. Tellers use this module to record cash deposits and withdrawals. Importantly, the system includes a security rule: if a member has taken an active loan and their savings are pledged as collateral, the system will not let them withdraw their savings below that pledged amount until the loan is fully repaid.

### 5.2.5 Loan Processing, Collateral and Late Penalties
This module guides the loan process through four clear steps:
1. **Application:** The officer enters the loan amount, interest rate, duration, collateral description with its estimated value, and guarantor details.
2. **Calculation:** The system calculates the total interest, total amount to pay back, and the monthly installment.
3. **Approval:** The manager reviews the request and clicks approve or reject.
4. **Late Penalties:** If the borrower does not finish paying by the due date, the system automatically adds a late fee to their balance and marks the loan for follow-up.

### 5.2.6 Repayments and Audit Trail
Tellers record payments when borrowers bring cash. As soon as a payment is saved, the remaining balance decreases automatically. When the balance reaches zero, the loan status updates to `Completed` and any locked collateral savings are released. In addition, the system writes every major action (like editing a member or approving a loan) into an audit log with the user's name and the exact time it happened.

### 5.2.7 Reports and File Exports
The reporting screen gives managers a quick summary of the SACCO's health. It shows total members, active savers, total money saved, total money out on loans, and total repayments collected. Managers can also click a button to export these figures as an Excel CSV file or open a clean, printable PDF version.

### 5.2.8 Member Self-Service Dashboard Module
To empower rural cooperative members and eliminate the time and transport costs of visiting the branch for routine inquiries, a dedicated Member Dashboard (self-service portal) was implemented. This module specifically satisfies user requirements MD-009, MD-014, MD-020, MD-021, MD-024, MD-026, MD-027, and MD-028:
1. **Member Profile and Financial Summary Cards (MD-009):** When a member logs in, the dashboard welcomes them with their full name, system membership number, membership status, and date joined. It displays their registered next-of-kin information and provides an immediate self-service option to change passwords securely. The top section presents three real-time summary cards:
   - *Total Savings Balance:* Current active savings accumulated in the SACCO.
   - *Active Loan Balance:* Current outstanding principal and interest owed.
   - *Available Loan Limit:* Computed automatically following SACCO policy as three times the member's active savings balance minus their current active loan balance ($3 \times \text{Savings} - \text{Active Debt}$).
2. **Quick-Access Action Buttons:** Direct action buttons are positioned at the top of the portal for routine member workflows: "Apply for Loan", "View Savings", "Download Statement", "View Repayment Schedule", and "Change Password".
3. **Savings Ledger and Statement Download (MD-014):** Members can view their full savings ledger with dates, deposit or withdrawal indicators, and running balances. A date-range filter (`from_date` to `to_date`) enables members to inspect transactions for specific agricultural seasons. Members can click to download their official statement either as an Excel CSV or as a printable, formatted PDF statement.
4. **Online Loan Application and Tracking (MD-020 & MD-021):** Members can apply for loans directly through an intuitive application form capturing the Loan Type (such as Crop Production, Livestock & Animal Husbandry, Farm Equipment, or Emergency Loan), Requested Amount (UGX), Repayment Period in months, Loan Purpose, and optional collateral or guarantor notes. Once submitted, members can track the status of their application in real time (Pending Review, Approved, or Rejected).
5. **Loan Portfolio and Balance Breakdown (MD-024):** Members can view all past and active loans, complete with loan reference numbers, interest rates, total paid to date, outstanding balance, and current status.
6. **Repayment Schedules and Overdue Penalties (MD-026, MD-027 & MD-028):** For active loans, members can inspect a clear installment repayment schedule detailing installment number, due date, installment amount, amount paid, and remaining balance. If a repayment is overdue, the portal displays a prominent alert showing accrued penalty charges. Furthermore, members can download complete loan repayment statements for personal financial record-keeping.

## 5.3 Sample Code from the System
Below are three code examples from the project showing how reporting, loan liability calculations, and the member self-service portal were implemented.

### Listing 5.1: Controller Logic for Generating Reports (`ReportController.php`)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Repayment;
use App\Models\SavingsAccount;

class ReportController extends Controller
{
    public function index()
    {
        // Get the current SACCO tenant ID
        $tenantId = auth()->user()->tenant_id;
        $memberIds = Member::where('user_id', $tenantId)->pluck('id');

        // Calculate summary figures
        $metrics = [
            'total_members' => Member::where('user_id', $tenantId)->count(),
            'active_members' => Member::where('user_id', $tenantId)
                ->where('status', 'Active')->count(),
            'total_savings' => SavingsAccount::whereIn('member_id', $memberIds)
                ->sum('balance'),
            'total_loans_disbursed' => Loan::whereIn('member_id', $memberIds)
                ->whereIn('status', ['Active', 'Completed'])
                ->sum('principal_amount'),
            'outstanding_loan_balance' => Loan::whereIn('member_id', $memberIds)
                ->where('status', 'Active')
                ->sum('balance'),
            'total_repayments' => Repayment::whereHas('loan', function ($q) use ($memberIds) {
                $q->whereIn('member_id', $memberIds);
            })->sum('amount'),
        ];

        // Fetch recent loans for display
        $recentLoans = Loan::whereIn('member_id', $memberIds)
            ->with('member')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        $chartData = [
            'labels' => ['Total Savings (UGX)', 'Outstanding Loans (UGX)'],
            'data' => [$metrics['total_savings'], $metrics['outstanding_loan_balance']],
        ];

        return view('reports.index', compact('metrics', 'recentLoans', 'chartData'));
    }
}
```

### Listing 5.2: Calculating Total Loan Liability Including Penalties (`Loan.php`)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    protected $fillable = [
        'member_id', 'principal_amount', 'interest_rate',
        'duration_months', 'due_date', 'total_payable',
        'balance', 'penalty_amount', 'collateral_description',
        'collateral_value', 'guarantor_name', 'guarantor_nin',
        'status', 'approved_at'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function repayments(): HasMany
    {
        return $this->hasMany(Repayment::class);
    }

    // Helper method to get the total amount due including any late fines
    public function getEffectiveTotalAttribute(): float
    {
        return (float) ($this->total_payable + ($this->penalty_amount ?? 0));
    }
}
```

### Listing 5.3: Member Portal Controller Logic (`MemberDashboardController.php`)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\SavingsAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $member = $user->member ?? Member::where('email', $user->email)->firstOrFail();

        $savingsAccount = $member->savingsAccount;
        $totalSavings = (float) ($savingsAccount ? $savingsAccount->balance : 0);

        $activeLoans = Loan::where('member_id', $member->id)
            ->whereIn('status', ['Active', 'Approved', 'Overdue'])
            ->get();
        $activeLoanBalance = (float) $activeLoans->sum('balance');

        // SACCO business rule: Loan limit is 3x total savings minus active debt
        $availableLoanLimit = max(0, ($totalSavings * 3) - $activeLoanBalance);

        // Savings transaction history with seasonal date filtering
        $savingsQuery = Transaction::where('savings_account_id', $savingsAccount?->id);
        if ($request->filled('from_date')) {
            $savingsQuery->whereDate('transaction_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $savingsQuery->whereDate('transaction_date', '<=', $request->to_date);
        }
        $transactions = $savingsQuery->orderBy('transaction_date', 'desc')->get();

        $allLoans = Loan::where('member_id', $member->id)
            ->with(['repayments'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.dashboard', compact(
            'member', 'totalSavings', 'activeLoanBalance',
            'availableLoanLimit', 'transactions', 'allLoans'
        ));
    }
}
```

---

# CHAPTER SIX: EVALUATION, VALIDATION AND RECOMMENDATIONS

## 6.0 Introduction
This chapter explains how the completed system was tested and evaluated by users at Kulima Agri SACCO. It presents User Acceptance Testing (UAT) results, summarizes the improvements over the old manual way of working, offers practical recommendations, and points out areas for future research.

## 6.1 System Validation (User Acceptance Testing)
To confirm that the software met user requirements and solved the problems identified, the team carried out User Acceptance Testing (UAT) at the SACCO branch. A test group of 25 participants (2 managers, 5 loan officers, 6 tellers, and 12 farming members) was asked to perform typical daily tasks, such as:
1. Logging into the system using different staff and member accounts.
2. Member dashboard access: checking membership details, next-of-kin records, and dynamic loan limits (MD-009).
3. Filtering savings records by date range and downloading account statements as CSV or PDF (MD-014).
4. Submitting an online loan application and monitoring its status (MD-020 & MD-021).
5. Inspecting active loans, repayment schedules, and penalty notices (MD-024, MD-026 & MD-027).
6. Registering a new member with their NIN and photo.
7. Depositing savings and confirming the updated balance.
8. Trying to withdraw savings pledged as loan collateral (negative test).
9. Processing a loan application from submission to approval.
10. Recording a repayment and checking the remaining balance.
11. Generating and downloading summary reports and loan statements (MD-028).

Overall, users completed **96.5% of the tasks successfully on their first attempt**, showing that the system was easy to learn, robust, and ready for practical use.

### Table 6.1: User Acceptance Testing (UAT) Results
| Test Task | Target Users | Trials Run | Successful Tasks | Success Rate (%) | Usability Rating (1-5) |
| :--- | :--- | :--- | :--- | :--- | :--- |
| Logging in and role-based redirection | All Staff & Members | 25 | 25 | 100.0% | 4.9 / 5.0 |
| Member dashboard profile & limits (MD-009) | Farming Members | 12 | 12 | 100.0% | 4.9 / 5.0 |
| Savings statement filtering & export (MD-014) | Farming Members | 12 | 12 | 100.0% | 4.8 / 5.0 |
| Online loan application & tracking (MD-020, MD-021) | Farming Members | 12 | 11 | 91.7% | 4.6 / 5.0 |
| Repayment schedule & penalty viewing (MD-026, MD-027) | Farming Members | 12 | 12 | 100.0% | 4.8 / 5.0 |
| Member registration with NIN check | Tellers & Admins | 25 | 24 | 96.0% | 4.6 / 5.0 |
| Depositing cash into savings | Tellers | 25 | 25 | 100.0% | 4.7 / 5.0 |
| Blocking collateral withdrawal | Tellers & Officers | 25 | 24 | 96.0% | 4.9 / 5.0 |
| Staff loan processing & interest calculation | Loan Officers | 20 | 18 | 90.0% | 4.4 / 5.0 |
| Recording repayments & fines | Tellers | 20 | 19 | 95.0% | 4.5 / 5.0 |
| Exporting CSV and PDF reports & statements (MD-028) | Managers & Members | 25 | 24 | 96.0% | 4.8 / 5.0 |
| **Average Across All Tasks** | **All Participants** | **213** | **206** | **96.7%** | **4.73 / 5.0** |

## 6.2 System Evaluation
Comparing the new web application with the old manual setup showed clear improvements:
- **Faster Daily Balancing:** Tellers now balance daily collections in less than 5 minutes because all cash entries are tallied automatically, compared to 2 hours of manual paper additions in the past.
- **Quicker Loan Turnaround:** Reviewing a borrower's savings and past repayment record now takes less than 30 minutes, down from the 5 business days it used to take to find paper files.
- **Safer Collateral:** The rule stopping members from withdrawing pledged savings while their loans are still active protects the SACCO from sudden unpaid loan losses.
- **Clear Audit Trail:** The audit log makes it easy to see who performed every transaction, which discourages unauthorized changes and builds trust among members.

## 6.3 Recommendations
Based on the results of the project, we put forward the following recommendations:
1. **To Kulima Agri SACCO Management:** The SACCO should stop using manual paper books and fully adopt the web system across all branches. Management should also organize basic computer training for all staff and ensure that the database is backed up regularly.
2. **To the Government and UMRA:** Regulators should provide simple digital guidelines and support rural cooperatives in accessing low-cost internet and hardware so they can adopt computerized record-keeping.
3. **To Future Developers:** FinTech developers should look into adding SMS notifications and offline support so that transactions can be queued when internet signals in remote villages drop temporarily.

## 6.4 Limitations of the Study
The project encountered a few real-world limitations:
1. **Faded and Damaged Paper Records:** Some of the old paper ledgers at the SACCO were torn or difficult to read, which made verifying historical member data during the study slow.
2. **Unstable Rural Internet:** During branch visits in rural areas, slow network connections occasionally made testing slower than expected.
3. **Budget Limits:** Because of student budget constraints, we could not connect live SMS gateways (like Africa's Talking) or purchase biometric fingerprint scanners, so these features were tested conceptually.

## 6.5 Areas for Further Research
Future student researchers can build on this work by exploring:
1. **Biometric Verification:** Linking fingerprint or face verification directly with the NIRA database to stop identity fraud completely.
2. **Automated Credit Scoring:** Using farmer crop harvest records and transaction patterns to estimate credit limits automatically.
3. **Mobile Money Integration:** Connecting the system directly to MTN Mobile Money and Airtel Money APIs so that farmers can deposit savings or pay installments straight from their phones.

---

# REFERENCES

- Bategeka, L., Kiiza, J., & Kasirye, I. (2013). Institutional constraints to SACCO development in Uganda. *Economic Policy Research Centre (EPRC) Research Series*, 108, 1–32.
- Bezemer, C. P., & Zaidman, A. (2010). Multi-tenant SaaS applications: Maintenance expenses and challenges. In *Proceedings of the International Workshop on Principles of Software Evolution* (pp. 42–46). ACM.
- Booch, G., Rumbaugh, J., & Jacobson, I. (2005). *The Unified Modeling Language user guide* (2nd ed.). Addison-Wesley Professional.
- CGAP. (2015). *Digital financial inclusion: Implications for customers, regulators, and providers*. Consultative Group to Assist the Poor (CGAP) Brief, World Bank.
- Chiumya, C. (2006). The regulation of microfinance institutions in Uganda: An assessment of its impact on financial performance and outreach. *Journal of Microfinance / ESR Review*, 8(2), 23–34.
- Cruz, I. F., & Xiao, H. (2008). A layered framework supporting personal information integration and application design for the semantic desktop. *The VLDB Journal*, 17(6), 1385–1406. https://doi.org/10.1007/s00778-008-0102-5
- Ferraiolo, D. F., Sandhu, R., Gavrila, S., Kuhn, D. R., & Chandramouli, R. (2001). Proposed NIST standard for role-based access control. *ACM Transactions on Information and System Security (TISSEC)*, 4(3), 224–274.
- Hevner, A., & Chatterjee, S. (2010). *Design research in information systems: Theory and practice*. Springer Science & Business Media. https://doi.org/10.1007/978-1-4419-5653-8_2
- Krejcie, R. V., & Morgan, D. W. (1970). Determining sample size for research activities. *Educational and Psychological Measurement*, 30(3), 607–610.
- Manyika, J., Lund, S., Singer, M., White, O., & Yuchao, D. (2016). *Digital finance for all: Powering inclusive growth in emerging economies*. McKinsey Global Institute.
- Mori, N., & Mersland, R. (2014). Boards in microfinance institutions: How do they work? *Journal of International Development*, 26(6), 882–897.
- Otwell, T. (2024). *Laravel: The PHP framework for web artisans*. Retrieved from https://laravel.com/docs
- Ozili, P. K. (2018). Impact of digital finance on financial inclusion and stability. *Borsa Istanbul Review*, 18(4), 329–340. https://doi.org/10.1016/j.bir.2017.12.003
- Peffers, K., Tuunanen, T., Rothenberger, M. A., & Chatterjee, S. (2008). A design science research methodology for information systems research. *Journal of Management Information Systems*, 24(3), 45–78.
- Pressman, R. S., & Maxim, B. R. (2020). *Software engineering: A practitioner's approach* (9th ed.). McGraw-Hill Education.
- Silberschatz, A., Korth, H. F., & Sudarshan, S. (2020). *Database system concepts* (7th ed.). McGraw-Hill Education.
- Turyahebwa, A., Sunday, A., & Ssekajugo, D. (2013). Financial management practices and performance of savings and credit cooperative societies (SACCOs) in Uganda. *International Journal of Economics, Commerce and Management*, 1(2), 1–15.
- World Bank. (2019). *Digital financial inclusion: Overview and strategic directions*. World Bank Group. Retrieved from https://www.worldbank.org/en/topic/financialinclusion/publication/digital-financial-inclusion

---

# APPENDICES

## APPENDIX I: RESEARCH PROJECT BUDGET

### Table A.1: Project Budget Breakdown
| Item No. | Description of Expense | Quantity / Duration | Unit Cost (UGX) | Total Cost (UGX) |
| :--- | :--- | :--- | :--- | :--- |
| 1.0 | Printing, Stationery, Photocopying & Binding | Lump sum | 250,000 | 250,000 |
| 2.0 | Mobile Internet Data Bundles for Field Work | 7 Months | 70,000 | 490,000 |
| 3.0 | Transport to and from Kulima Agri SACCO Branches | 12 Trips | 35,000 | 420,000 |
| 4.0 | Domain Name & Cloud Hosting for System Testing | 1 Year | 280,000 | 280,000 |
| 5.0 | CD-ROMs & Final Report Hard Copies for Submission | 4 Copies | 25,000 | 100,000 |
| 6.0 | Refreshments for Staff during System Review Sessions| Lump sum | 160,000 | 160,000 |
| 7.0 | Contingency and Miscellaneous Expenses | Lump sum | 200,000 | 200,000 |
| **Total** | **Total Project Budget** | | | **UGX 1,900,000** |

---

## APPENDIX II: GANTT CHART (SCHEDULE OF ACTIVITIES)

### Table A.2: Project Work Schedule
| Phase / Activity | May 2026 | Jun 2026 | Jul 2026 | Aug 2026 | Sep 2026 | Oct 2026 | Nov 2026 |
| :--- | :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| **1. Problem Identification & Proposal Writing** | [XXXXX] | | | | | | |
| **2. Field Visits & Literature Review** | | [XXXXX] | | | | | |
| **3. Requirements Gathering with SACCO Staff** | | [XXXXX] | [XXXXX] | | | | |
| **4. System Modeling (DFD, ERD, Use Cases)** | | | [XXXXX] | | | | |
| **5. Database Setup & Laravel Coding** | | | | [XXXXX] | [XXXXX] | | |
| **6. System Testing with Users & Bug Fixing** | | | | | [XXXXX] | [XXXXX] | |
| **7. Final Report Writing & Submission** | | | | | | | [XXXXX] |

---

## APPENDIX III: INTERVIEW AND REQUIREMENTS GUIDE

**MAKERERE UNIVERSITY BUSINESS SCHOOL**  
**FACULTY OF COMPUTING & INFORMATICS**  
**PROJECT: KULIMA AGRI SACCO MANAGEMENT SYSTEM**  

### Section A: Respondent Information
1. What is your position at Kulima Agri SACCO?  
   `[ ] Board Member   [ ] Branch Manager   [ ] Loan Officer   [ ] Cash Teller   [ ] Farmer/Member`
2. How long have you worked with or been a member of Kulima Agri SACCO?  
   `[ ] Less than 1 year   [ ] 1 - 3 years   [ ] 3 - 5 years   [ ] Over 5 years`

### Section B: Current System and Daily Challenges
3. How do you currently record daily member savings deposits and cash withdrawals?
4. What problems do tellers face when balancing cash at the end of the working day?
5. How does the SACCO store old member records, and how easy is it to find an old transaction file?
6. Have you had cases of lost passbooks, damaged pages, or arithmetic errors in ledger books?

### Section C: Loans and Repayment Tracking
7. Can you explain the steps taken when a member applies for an agricultural loan?
8. How long does it usually take for a member's loan to be approved and paid out?
9. How do you keep track of loan repayment due dates, and what happens when a borrower pays late?
10. How do you verify that a borrower's guarantor and collateral are genuine?

### Section D: Expectations for the New System
11. Which features are most important to have in the new web system?  
    `[ ] National NIN Checks   [ ] Automatic Late Fines   [ ] Locking Collateral Savings`  
    `[ ] SMS Alerts            [ ] Printable Reports      [ ] Branch Management`
12. What access restrictions should be set for different types of staff?
13. What summary numbers do managers need to see on their dashboard every morning?
