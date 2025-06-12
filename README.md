# CareerCompass: Laravel Job Application Tracker

🚀 **Transform Your Job Search Journey** - A powerful, elegant application for managing job applications, interviews, and your entire career search process. Built with Laravel 12 and Filament 3.

![CareerCompass](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)

---

## 📋 Overview

CareerCompass is a sophisticated web application designed to empower job seekers with powerful organization tools for their career search. In today's competitive job market, staying organized is key to success - and CareerCompass delivers the perfect solution with its intuitive interface and comprehensive tracking capabilities.

Never miss an opportunity, deadline, or follow-up again. CareerCompass provides a centralized command center to manage every aspect of your job search journey - from tracking applications and monitoring statuses to storing important documents and managing professional contacts.

---

## ✨ Features

-   **Comprehensive Job Application Dashboard**
    -   Track job titles, company information, and application status at a glance
    -   Store detailed job descriptions, salary expectations, and location information
    -   Monitor application deadlines and posting dates with visual indicators
    -   Categorize positions by work arrangement (remote, onsite, hybrid, or freelance)

-   **Visual Application Pipeline**
    -   Intuitive status indicators with color coding (Pending, Interview, Offer, Rejected)
    -   Track your application journey from submission to decision
    -   Filter and sort applications by status, date, or company

-   **Smart Document Management**
    -   Upload and manage tailored resumes and cover letters (PDF and Word formats, up to 10MB each)
    -   Intelligent file organization with automatic, standardized naming conventions (e.g., `COMPANY-NAME_USER-NAME_Resume.pdf`)
    -   One-click access to your documents directly within the application
    -   Secure storage with proper file organization by company and document type

-   **Professional Network Management**
    -   Build a database of company contacts and recruiters
    -   Track names, email addresses, phone numbers, and LinkedIn profiles
    -   Associate contacts with specific job applications
    -   Quick access to your professional connections for efficient follow-ups

-   **Intelligent Note Taking**
    -   Capture important details about each opportunity
    -   Categorize notes (Personal, Professional, Other) for better organization
    -   Rich text editor with formatting capabilities for professional-looking notes
    -   Track interview questions, company research, and personal reflections

-   **Action-Oriented Task Management**
    -   Create and prioritize to-do items for each application
    -   Track completion status with visual indicators
    -   Never miss important follow-ups or preparation tasks
    -   Stay on top of your job search activities

-   **Beautiful, Intuitive Interface**
    -   Modern, responsive design that works on all devices
    -   Tabbed navigation within each application for efficient management
    -   Dynamic badges display counts for associated items (notes, contacts, tasks)
    -   Clean, distraction-free layout focused on productivity

-   **Seamless Data Portability**
    -   Export your job application data to CSV for external analysis or backup
    -   Import existing job applications from spreadsheets or other tracking systems
    -   Never lose your valuable job search history

-   **Secure Multi-User Support**
    -   Private, secure user accounts with data isolation
    -   Personal job application tracking for individuals
    -   Data protection with modern security practices

---

## 🚀 Tech Stack

-   **Modern Framework**: Built on Laravel 12, the latest version of PHP's most elegant framework
-   **Beautiful Admin Panel**: Powered by Filament 3 for a responsive, feature-rich interface
-   **Robust Database**: Compatible with MySQL, PostgreSQL, and **SQLite** for reliable data storage
-   **Reactive Frontend**: Leveraging Livewire and Tailwind CSS for a smooth, modern UI experience
-   **Developer-Friendly**: Includes Laravel Debugbar, Laravel IDE Helper, and Laravel Telescope for easy maintenance and extension

---

## 📦 Installation

### Prerequisites

To get CareerCompass up and running, ensure you have the following installed:

* **PHP 8.2 or higher**
* **Composer** (for PHP dependency management)
* **Node.js and NPM** (for frontend asset compilation)
* **Database:** Either **SQLite** (default and recommended for easy local setup) or **MySQL / PostgreSQL** (if you prefer a dedicated database server).

---

### Setup Instructions

Follow these steps to set up CareerCompass locally:

1.  **Clone the repository and navigate into the project directory:**
    ```bash
    git clone [https://github.com/Bender-0/career-compass.git](https://github.com/Bender-0/career-compass.git)
    cd career-compass
    ```

2.  **Install PHP dependencies and initialize the application:**
    This single command will handle several crucial steps for you:
    * Creates your `.env` file from `.env.example`.
    * Generates your application key.
    * Creates the storage symbolic link.
    * **Automatically sets up the SQLite database** with all necessary tables and sample data.
    ```bash
    composer install
    ```
    * **Note on MySQL / PostgreSQL:** If you prefer to use MySQL or PostgreSQL instead of SQLite, you will need to:
        1.  Manually create your database (e.g., `career_compass` in MySQL).
        2.  After `composer install` has run, open the newly created `.env` file.
        3.  Fill in your database credentials:
            ```
            DB_CONNECTION=mysql # Or postgres
            DB_HOST=127.0.0.1
            DB_PORT=3306 # Or 5432 for PostgreSQL
            DB_DATABASE=career_compass
            DB_USERNAME=your_database_username
            DB_PASSWORD=your_database_password
            ```
        4.  Then, run the migrations and seeders manually to populate your chosen database:
            ```bash
            php artisan migrate:fresh --seed
            ```

3.  **Install Frontend Dependencies:**
    ```bash
    npm install
    ```

4.  **Start Development Server:**
    You have a couple of options to run the development server:

    * **Option 1: Using Composer's `dev` script (recommended for simplicity):**
        This command will simultaneously start the Laravel development server, queue listener, logs, and Vite for asset compilation.
        ```bash
        composer run dev
        ```
    * **Option 2: Manual Startup (if you prefer separate processes):**
        First, compile the frontend assets:
        ```bash
        npm run dev
        ```
        Then, start the Laravel development server:
        ```bash
        php artisan serve
        ```

5.  **Access the Application:**
    Once the development server is running, open your web browser and visit:
    `http://localhost:8000`

    You can log in with the default sample user:
    * **Username:** `user@example.com`
    * **Password:** `password`

---

## Sample Data

The application comes with sample data to help you get started. After running the migrations with the `--seed` flag, you'll have:

* 1 sample user (`user@example.com` / `password`)
* 18 sample job applications
* Associated contacts, notes, and tasks

To reset and reseed the database at any time, run:

```bash
php artisan migrate:fresh --seed
```

## Getting Started with CareerCompass

### Creating a New Job Application

1. Log in to your account
2. Click on "Create Application" button
3. Fill in the job details:
   - Job title
   - Company name
   - Company website
   - Application date
   - Job status
   - Job description
   - Salary range
   - Location
   - Application link
   - Posted date and deadline (if applicable)
4. Upload your custom resume and cover letter (optional)
5. Click "Create" to save the application

### Managing Applications

- View all applications in the dashboard grid
- Filter applications by status
- Search for specific applications by job title or company
- Click on an application to view or edit details

### Adding Contacts, Notes, and Tasks

1. Open an application
2. Navigate to the respective tab (Contacts, Notes, Tasks)
3. Add new entries as needed
4. All entries are automatically associated with the current application

### Document Management

- Upload resumes and cover letters (supports PDF and Word documents, max 10MB per file).
- Documents are automatically renamed using a consistent pattern (e.g., `COMPANY-NAME_USER-NAME_Resume.pdf`) and organized into structured directories (e.g., `storage/applications/company_name/resume/`).
- Access, download, or open uploaded documents directly from the application details page.

## Data Import/Export

### Exporting Data

1. Go to the Applications list
2. Click the Export button
3. Select CSV format
4. Download the exported file

### Importing Data

1. Go to the Applications list
2. Click the Import button
3. Upload your CSV file with application data
4. Map the columns and confirm import

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

<p align="center">Built with ❤️ using Laravel and Filament</p>
<p align="center">Take control of your career journey with CareerCompass</p>
