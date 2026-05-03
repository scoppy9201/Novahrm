# NovaHRM

<p align="center">
  <strong>Modern Human Resource Management Platform</strong>
</p>

<p align="center">
  <a href="https://novahrm.io.vn">🌐 Website</a>
  ·
  <a href="#english">🇺🇸 English</a>
</p>

<p align="center">
  <img src="public/images/preview-dashboard.png" alt="NovaHRM Preview" width="100%" />
</p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel" alt="Laravel"></a>
<a href="#"><img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php" alt="PHP"></a>
<a href="#"><img src="https://img.shields.io/badge/Blade-Template-0EA5E9?style=flat" alt="Blade"></a>
<a href="#"><img src="https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?style=flat&logo=tailwindcss" alt="Tailwind"></a>
<a href="#"><img src="https://img.shields.io/badge/License-MIT-green" alt="License"></a>
</p>

---

# NovaHRM Human Resource Management System

NovaHRM is a modern open-source Human Resource Management (HRM) system built with Laravel 11.

The project focuses on modular architecture, clean UI design, scalability, and developer experience.

NovaHRM helps businesses manage employees, attendance, payroll, tasks, and internal workflows in a centralized platform.

Official Website:

[https://novahrm.io.vn](https://novahrm.io.vn)

---

# Project Structure

```bash
Novahrm
├── app
│   ├── packages          # Modular packages
│   ├── Services          # Business logic services
│   ├── Models            # Application models
│   └── Http              # Controllers & middleware
├── public                # Static assets & previews
├── resources             # Blade views & frontend assets
├── routes                # Web routes
├── database              # Migrations & seeders
└── docs                  # Documentation files
```

---

# Core Modules

## Employee Management

* Employee profiles
* Department management
* Position & role management
* Employee status tracking
* Employee information management

## Attendance Management

* Daily attendance tracking
* Check-in / check-out
* Attendance logs
* Attendance statistics

## Leave Management

* Leave requests
* Approval workflows
* Leave history
* Leave balance tracking

## Payroll Management

* Salary management
* Payroll overview
* Payment history
* Salary structure

## Task Management

* Kanban task board
* Task assignment
* Progress tracking
* Team collaboration

## Calendar & Events

* Company schedules
* Internal events
* Calendar overview

## Internal Communication

* Notifications
* Internal messaging
* Activity updates

## Employee Portal

* Personal dashboard
* Self-service features
* Profile management

---

# Demo Preview

## Dashboard

<p align="center">
  <img src="public/images/preview-dashboard.png" width="100%" alt="Dashboard Preview" />
</p>

## Employee Management

<p align="center">
  <img src="public/images/preview-employees.png" width="100%" alt="Employee Preview" />
</p>

## Attendance System

<p align="center">
  <img src="public/images/preview-attendance.png" width="100%" alt="Attendance Preview" />
</p>

## Task Board

<p align="center">
  <img src="public/images/preview-tasks.png" width="100%" alt="Task Board Preview" />
</p>

---

# Technology Stack

## Backend

| Technology | Version | Description         |
| ---------- | ------- | ------------------- |
| Laravel    | 11.x    | PHP Framework       |
| PHP        | 8.2+    | Backend Language    |
| MySQL      | 8+      | Database            |
| Vite       | Latest  | Frontend Build Tool |

## Frontend

| Technology   | Description          | Version |
| ------------ | -------------------- | ------- |
| Blade        | Template Engine      | Latest  |
| Tailwind CSS | UI Framework         | 3.x     |
| Alpine.js    | Frontend Interaction | Latest  |
| JavaScript   | Frontend Logic       | ES6+    |

---

# Installation Guide

## Requirements

Recommended environment:

* PHP >= 8.2
* Composer >= 2.x
* MySQL >= 8.x
* Node.js >= 18
* NPM >= 9

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/scoppy9201/Novahrm.git
cd Novahrm
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update database configuration:

```env
DB_DATABASE=novahrm
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migration & Seeder

```bash
php artisan migrate --seed
```

### 5. Start Development Server

```bash
php artisan serve
npm run dev
```

Visit:

```text
http://127.0.0.1:8000
```

---

# Authentication & Authorization

* Custom authentication pages
* Session-based authentication
* Role & permission ready
* Extendable RBAC architecture

---

# Architecture

NovaHRM follows a modern modular architecture:

* Modular package structure
* Service-based architecture
* Reusable Blade components
* Clean separation of concerns
* Scalable business logic

Main architecture layers:

* Controllers
* Services
* Models
* Blade Components
* Views
* Packages

---

# Use Cases

NovaHRM is suitable for:

* HRM systems
* Internal company platforms
* ERP systems
* Startup MVP products
* Academic & graduation projects

---

# Roadmap

Upcoming planned modules:

* Recruitment Management
* Performance Reviews
* Asset Management
* Advanced Payroll
* AI Assistant
* Real-time Chat
* Organization Analytics

---

# Contributing

Contributions are welcome.

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to your branch
5. Open a Pull Request

---

# License

MIT License

---

# Links

* Website: [https://novahrm.io.vn](https://novahrm.io.vn)
* GitHub: [https://github.com/scoppy9201/Novahrm](https://github.com/scoppy9201/Novahrm)

---

<div align="center">
  Built with ❤️ using Laravel 11 & Blade
</div>


