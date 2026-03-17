# HRMGO – Human Resource Management System

**HRMGO** is an open-source **Human Resource Management (HRM)** system built with **Laravel** and **FilamentPHP**.  
The project focuses on clean architecture, rapid development, and easy customization for real-world HR workflows.

<p align="center">
  <img src="img.png" alt="Open source HRM"
       style="max-width: 100%; border-radius: 8px;
       box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
       0 10px 10px -5px rgba(0, 0, 0, 0.04);" />
</p>

This repository serves as a solid foundation for building a full HRM or ERP-style system.

---

## 🔧 Tech Stack

- Laravel 12+
- FilamentPHP 3.x (Admin Panel)
- PHP 8.2+
- MySQL / MariaDB
- Tailwind CSS (via Filament)
- Alpine.js (via Filament)

---

## ✨ Features

### Core Modules
- Employee Management
- Departments
- Attendance Tracking
- Leave Management
- Payroll (basic structure)
- Task & Kanban Board
- Internal Messaging
- Calendar
- Employee Portal

> Planned modules: Recruitment, Training, Performance Review, Assets, etc.

---

## 🚀 Installation

```bash
git clone https://github.com/scoppy9201/HRMGO.git
cd hrmgo

composer install
cp .env.example .env
php artisan key:generate

## Configure database credentials in .env
php artisan migrate --seed
composer run dev

🔐 Authentication & Authorization
- Authentication is handled by Filament Auth
- Login & Register pages are powered by Filament
- Custom auth pages:
=> app/Filament/Pages/Auth
- Supports role & permission extension (Spatie Permission)

🧱 Architecture Overview
- No traditional Blade-based admin UI
- UI built with Filament Pages & Resources
- Routes auto-registered by Filament
- Clean separation of:
- Models
- Services
- Filament Resources
- Filament Pages

🛠 Development Notes
- Designed for HRM / ERP expansion
- Suitable for:
- Graduation projects
- Internal company systems
- Startup MVPs
- Easy to customize & scale

📄 License
MIT License

HRMGO – Build your HR system faster with Laravel & Filament 🚀
