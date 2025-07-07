# 💼 Interview Task – Dashboard Web Application

Welcome! This is a responsive and interactive dashboard web application developed as part of a technical interview task.

---

## 🚀 Features

- ✅ User Authentication (Login)
- 📊 Sales, Revenue, and Demographics Charts (Chart.js, ECharts)
- 🌍 Customer Distribution on World Map
- 📦 Recent Orders Table with Status Badges
- 🌙 Dark/Light Mode Toggle
- 📱 Fully Responsive (Mobile-first)

---

## 🛠️ Tech Stack

| Layer      | Technology        |
|------------|-------------------|
| Backend    | Laravel 12+       |
| Php        | 8.2+              |
| Frontend   | Vue 3             |
| SPA Engine | Inertia.js        |
| Styling    | Tailwind CSS      |
| Charts     | Chart.js, ECharts |
| Database   | MySQL             |

---


## ⚙️ Installation Guide

### Step 1: Clone the Project

```bash
git clone https://github.com/smsarowar/interview_task.git

cd interview_task

```
### Step 2: Copy .env File
```bash
  cp .env.example .env
```


### Step 3: Install Dependencies
```bash
  composer install
  npm install
```
### Step 4: Generate Application Key
```bash
  php artisan key:generate
```
### check the env file
DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=< your database name >

DB_USERNAME=root

DB_PASSWORD=

< optional>

if use Database folder -> laravel.db then use 

email: admin@admin.com   
password :1234578

### Step 5: Generate Application Key
```bash
  php artisan migrate
```

### Step 6: Run the Application
```bash
  composer run dev
```

### Run http://localhost:8000
