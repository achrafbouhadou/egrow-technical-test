# 🚀 Fullstack Project Issue Tracker

This is a fullstack application for tracking project issues, built with **Laravel 12** and **Nuxt 4** as part of a technical assessment. The application provides a RESTful API for managing issues and a responsive frontend for visualizing data and statistics.

---

## ✨ Features

* **Project Summary Dashboard**: A dedicated page (`/projects/[id]/issues-summary`) to view key statistics for a single project.
* **Dynamic Summary Filtering**: The project summary can be dynamically filtered by assignee in real-time.
* **Comprehensive Issues List**: A central page (`/issues`) to view all issues across all projects, with pagination.
* **Advanced Filtering**:

  * Status (multi-select checkboxes)
  * Priority (dropdown)
  * Assigned User (debounced text input)
  * Project (dropdown)
* **Modern UI/UX**:

  * Clean, responsive UI built with Tailwind CSS
  * Visually distinct, color-coded badges for issue status and priority
  * High-priority issues are visually highlighted
  * Graceful handling of loading and error states

---

## 🛠️ Tech Stack

* **Backend**: Laravel 12, PHP 8.2+
* **Frontend**: Nuxt 4, Vue 3, TypeScript
* **Styling**: Tailwind CSS
* **Database**: MySQL

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed on your local machine:

* PHP >= 8.2
* Composer
* Node.js >= 18.0
* NPM or Yarn
* A local database server

---

## 🚀 Getting Started

### 1. Backend Setup (Laravel)

```bash
# Clone the repository
git clone <your-repo-url>
cd <your-repo-folder>

# Navigate to the backend directory
cd api

# Install PHP dependencies
composer install

# Create your environment file
cp .env.example .env

# Configure your database connection in .env
# Example for local MySQL setup:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=issue_tracker
# DB_USERNAME=root
# DB_PASSWORD=

# Generate an application key
php artisan key:generate

# Run the database migrations and seed with sample data
php artisan migrate --seed
```

### 2. Frontend Setup (Nuxt 4)

```bash
# Navigate to the frontend directory
cd ../client

# Install Node.js dependencies
npm install

# Create your environment file
cp .env.example .env

# Set API endpoint in .env
NUXT_PUBLIC_API_BASE=http://localhost:8000/api
```

---

## ▶️ Running the Application

Run both backend and frontend servers in two terminal windows.

### Terminal 1: Laravel API Server

```bash
cd api
php artisan serve
```

### Terminal 2: Nuxt 4 Dev Server

```bash
cd client
npm run dev
```

Visit: [http://localhost:3000](http://localhost:3000)

---

## 📄 API Documentation

### Get All Issues (with Filters & Pagination)

* **Endpoint**: `GET /api/issues`
* **Description**: Returns a paginated list of all issues across all projects.

**Query Parameters:**

* `page` (integer)
* `status` (string): Comma-separated (e.g., `open,in_progress`)
* `priority` (string): e.g., `high`
* `assigned_to` (string)
* `project_id` (integer)

**Example:** `/api/issues?status=open&priority=high`

---

### Get Project Issues Summary

* **Endpoint**: `GET /api/projects/{project}/issues-summary`
* **Description**: Returns an aggregate summary of issues for a specific project.

**URL Parameter:**

* `{project}` (integer)

**Optional Query Parameter:**

* `assigned_to` (string)

**Example:** `/api/projects/1/issues-summary?assigned_to=johndoe`

**Sample Response:**

```json
{
  "status": "success",
  "data": {
    "project": "Website Redesign",
    "total_issues": 12,
    "open_issues": 5,
    "assigned_to_issues": 3,
    "high_priority_unresolved": 2
  }
}
```

---

## 🌟 Bonus Features Implemented

* **Eloquent Scopes**: Reusable query logic in `Issue` model (`ofStatus()`, `ofPriority()`)
* **API Resources**: Consistent and structured JSON response format
* **Debounced Input**: Efficient filtering by assignee
* **Visual Highlighting**: Colored borders and pulsing indicators for high-priority issues
