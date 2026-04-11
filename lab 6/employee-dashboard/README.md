
# 🧑‍💼 Employee Management System 

A secure, role-based Employee Management System built with Laravel.
This project demonstrates backend development skills including authentication, authorization, and full CRUD operations using clean MVC architecture.

---

## 📺 Demo Video

Check out the project in action here:  
👉 https://drive.google.com/file/d/1WG9M59vngg0K-6RjRJM-mYmukpkckKIh/view?usp=sharing


---

## ✨ Features

### 🔐 Authentication

* User registration and login (Laravel Breeze)
* Secure session handling

### 👨‍💼 Role-Based Access Control

* **Admin**

  * Full access (create, edit, delete)
  * Manage user roles
* **HR**

  * Create and update employees
* **User**

  * View employees only

### 🧾 Employee Management

* ➕ Add new employees
* 📄 View employee list
* ✏️ Edit employee details
* ❌ Delete employees (Admin only)

### 🔍 Additional Functionality

* Search employees
* Pagination for large data
* Dashboard with employee stats
* Clean responsive UI using Tailwind CSS

---

## 🛠️ Tech Stack

* **Backend:** PHP & Laravel
* **Frontend:** Blade Templates & Tailwind CSS
* **Database:** MySQL
* **Authentication:** Laravel Breeze
* **Authorization:** Custom Role Middleware
* **Version Control:** Git & GitHub

---

## 🚀 Installation

```bash
git clone https://github.com/YOUR_USERNAME/Employee-Management-System.git
cd Employee-Management-System

composer install
npm install
npm run dev

cp .env.example .env
php artisan key:generate

php artisan migrate

php artisan serve
```




