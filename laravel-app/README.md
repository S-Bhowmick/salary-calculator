# UK Salary Calculator - Laravel Project

A full-stack **UK Salary Calculator** web application built with **HTML, CSS, JavaScript, PHP, and Laravel**.  
The system allows users to calculate salaries dynamically based on **job role, experience, and location**, while admins can manage salary rules, location bonuses, users, and analytics.

---

## Project Overview

This project was initially started as a basic PHP application and later integrated into **Laravel** to make it more structured, secure, and scalable.

The main goal of the project is to help users estimate salary and monthly take-home income in a more practical way, while also giving the admin full control over salary rules.

---

## Main Features

### User Features
- User registration and login
- Protected user dashboard
- Dynamic salary calculation
- Salary breakdown:
  - Base Salary
  - Experience Bonus
  - Location Bonus
  - Final Salary
- Monthly take-home salary estimate:
  - Annual Gross Salary
  - Monthly Gross Salary
  - Estimated Tax
  - Estimated National Insurance
  - Estimated Pension
  - Estimated Net Monthly Salary
- Salary history dashboard
- Favorite saved calculations
- Compare multiple salary calculations
- Download PDF salary report

### Admin Features
- Admin panel access
- View all users
- View all salary calculations
- View total users
- View total calculations
- View total job roles
- View total locations
- View most selected job role
- View most selected location
- View average calculated salary
- View highest calculated salary
- View total active roles
- View total active locations
- Add new job roles
- Add new location bonuses
- Activate / deactivate job roles
- Activate / deactivate locations
- Promote another user to admin
- Activate / deactivate users
- Delete salary calculations

---

## Salary Calculation Logic

The salary is calculated dynamically using admin-controlled database rules.

### Formula
`Final Salary = Base Salary + (Experience × Experience Increment) + Location Bonus`

### Monthly Take-Home Estimate
The project also provides an estimated take-home salary for monthly planning purposes.

---

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP, Laravel
- **Templating:** Blade
- **Authentication:** Laravel Breeze
- **Database:** SQLite
- **PDF Generation:** DomPDF
- **Version Control:** Git & GitHub

---

## Database Tables

Main tables used in the project:

- `users`
- `salary_calculations`
- `job_roles`
- `location_bonuses`
- `migrations`
- `sessions`
- `cache`

---

## Project Modules

### 1. Authentication Module
Handles:
- registration
- login
- logout
- route protection

### 2. Salary Calculator Module
Handles:
- job role selection
- experience input
- location selection
- salary calculation
- take-home estimate

### 3. Dashboard Module
Handles:
- salary history
- favorites
- comparison
- PDF report download

### 4. Admin Panel Module
Handles:
- user management
- admin promotion
- active/inactive user control
- salary rule management
- analytics and monitoring

---

## Screenshots

Add your screenshots here after uploading them to the repository.

### Home Page
![Home Page](screenshots/home.png)

### User Dashboard
![Dashboard](screenshots/dashboard.png)

### Admin Panel
![Admin Panel](screenshots/admin.png)

### Database View
![Database](screenshots/database.png)

---

## Installation Guide

### 1. Clone the repository
```bash
git clone https://github.com/S-Bhowmick/salary-calculator.git
cd salary-calculator