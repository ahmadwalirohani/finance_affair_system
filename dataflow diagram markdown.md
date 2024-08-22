title University Affairs System

// User Authentication
User Login [shape: oval, icon: log-in] > Validate Credentials [shape: diamond, icon: key]
Validate Credentials > Access Granted [shape: oval, icon: check-circle]: Yes
Validate Credentials > Access Denied [shape: oval, icon: x-circle]: No

// Treasury Management
Treasury [color: blue, icon: dollar-sign] {
  Record Income [icon: arrow-down-circle]
  Record Expenses [icon: arrow-up-circle]
  Generate Financial Reports [icon: file-text]
}

Access Granted > Treasury: Treasury Management
Treasury > Record Income
Treasury > Record Expenses
Treasury > Generate Financial Reports

// Teacher Payroll Management
Payroll [color: green, icon: briefcase] {
  Calculate Salaries [icon: calculator]
  Process Payments [icon: credit-card]
  Generate Payslips [icon: file-text]
}

Access Granted > Payroll: Payroll Management
Payroll > Calculate Salaries
Payroll > Process Payments
Payroll > Generate Payslips

// Item Stock Management
Stock Management [color: orange, icon: box] {
  Check Stock Levels [icon: list]
  Order Items [icon: shopping-cart]
  Request Items [icon: clipboard]
}

Access Granted > Stock Management: Item Stock Management
Stock Management > Check Stock Levels
Stock Management > Order Items
Stock Management > Request Items

// Department-wise Item Request
Departments [color: purple, icon: building] {
  Department A [icon: folder]
  Department B [icon: folder]
  Department C [icon: folder]
}

Request Items > Departments: Department-wise Item Request
Departments > Department A
Departments > Department B
Departments > Department C

Department A > Request Items
Department B > Request Items
Department C > Request Items

// End Points
Generate Financial Reports > End [shape: oval, icon: check-circle]
Generate Payslips > End
Request Items > End
