# PROMEX - Promotional Exam Management System

PROMEX is a web-based examination management system built with Laravel 12, designed to manage the full lifecycle of promotional examinations — from result entry by instructors to final publication on student portals.

---

## Features

### 👨‍🏫 Instructor
- View assigned subjects on a personal dashboard
- View students who sat for their subject
- Enter, edit, and manage exam results
- Submit final results for approval
- Results are locked after submission

### 🧑‍💼 Chief Examiner (Exam Board)
- View all submitted subject results
- Approve results with optional remarks
- Disapprove and return results to instructor with mandatory reason
- Dashboard with graphs showing student breakdown by level, category, and pass rates
- Forward approved results to the Director General

### 🎖️ Director General
- View results forwarded by the Exam Board
- Review full result breakdown per subject
- Add remarks before publishing
- Publish results to the student portal
- Dashboard with overall pass/fail statistics and charts

### 🎓 Student
- View published exam results
- See pass/fail status per subject
- Automatic resit determination:
  - Fail **1 subject** → resit that paper only
  - Fail **2 or more** → resit entire examination
- Resit logic is category-aware (Level A/B, Category A/B/C)
- View remaining attempts (max 3)
- Download result slip as PDF

---

## Roles

| Role | Description |
|------|-------------|
| `instructor` | Enters and submits exam results |
| `examboard` | Reviews and approves/disapproves results |
| `director` | Publishes results to student portal |
| `student` | Views and downloads their results |

> User accounts are created by administrators. Public registration is disabled.

---

## Tech Stack

- **Backend:** Laravel 12, PHP 8.3
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Chart.js
- **Database:** SQLite (development)
- **Roles & Permissions:** Spatie Laravel Permission
- **PDF Generation:** barryvdh/laravel-dompdf

---

## Installation
```bash
git clone https://github.com/yourusername/promex.git
cd promex

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan db:seed --class=RolesSeeder

php artisan serve
```

### Default Accounts (after seeding)

| Role | Email | Password |
|------|-------|----------|
| Student | student@example.com | password |
| Instructor | instructor@example.com | password |
| Chief Examiner | examboard@example.com | password |
| Director General | director@example.com | password |

---

## Exam Rules

- Pass mark: **400 and above** (out of 500)
- Below 400: **Fail**
- Null/empty mark: **Absent**
- Each student has **3 attempts**
- Students are assigned a unique **index number**
- Students belong to **Level A** (Lt–Capt) or **Level B** (Capt–Maj)
- Each level has **3 categories**: A, B, or C

---

## Result Workflow
```
Instructor → submits results
    ↓
Chief Examiner → approves or disapproves
    ↓ (if disapproved, returns to instructor)
Director General → publishes to student portal
    ↓
Student → views and downloads results
```

---

## License

This project is proprietary. All rights reserved.
