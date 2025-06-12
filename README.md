# CareerCompass: Laravel Job Application Tracker

🚀 **Transform Your Job Search Journey** - A powerful, elegant application for managing job applications, interviews, and your entire career search process. Built with Laravel 12 and Filament 3.

![CareerCompass](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)

## 📋 Overview

CareerCompass is a sophisticated web application designed to empower job seekers with powerful organization tools for their career search. In today's competitive job market, staying organized is key to success - and CareerCompass delivers the perfect solution with its intuitive interface and comprehensive tracking capabilities.

Never miss an opportunity, deadline, or follow-up again. CareerCompass provides a centralized command center to manage every aspect of your job search journey - from tracking applications and monitoring statuses to storing important documents and managing professional contacts.

## ✨ Features

- **Comprehensive Job Application Dashboard**
  - Track job titles, company information, and application status at a glance
  - Store detailed job descriptions, salary expectations, and location information
  - Monitor application deadlines and posting dates with visual indicators
  - Categorize positions by work arrangement (remote, onsite, hybrid, or freelance)

- **Visual Application Pipeline**
  - Intuitive status indicators with color coding (Pending, Interview, Offer, Rejected)
  - Track your application journey from submission to decision
  - Filter and sort applications by status, date, or company

- **Smart Document Management**
  - Upload and manage tailored resumes and cover letters (PDF and Word formats, up to 10MB each)
  - Intelligent file organization with automatic, standardized naming conventions (e.g., `COMPANY-NAME_USER-NAME_Resume.pdf`)
  - One-click access to your documents directly within the application
  - Secure storage with proper file organization by company and document type

- **Professional Network Management**
  - Build a database of company contacts and recruiters
  - Track names, email addresses, phone numbers, and LinkedIn profiles
  - Associate contacts with specific job applications
  - Quick access to your professional connections for efficient follow-ups

- **Intelligent Note Taking**
  - Capture important details about each opportunity
  - Categorize notes (Personal, Professional, Other) for better organization
  - Rich text editor with formatting capabilities for professional-looking notes
  - Track interview questions, company research, and personal reflections

- **Action-Oriented Task Management**
  - Create and prioritize to-do items for each application
  - Track completion status with visual indicators
  - Never miss important follow-ups or preparation tasks
  - Stay on top of your job search activities

- **Beautiful, Intuitive Interface**
  - Modern, responsive design that works on all devices
  - Tabbed navigation within each application for efficient management
  - Dynamic badges display counts for associated items (notes, contacts, tasks)
  - Clean, distraction-free layout focused on productivity

- **Seamless Data Portability**
  - Export your job application data to CSV for external analysis or backup
  - Import existing job applications from spreadsheets or other tracking systems
  - Never lose your valuable job search history

- **Secure Multi-User Support**
  - Private, secure user accounts with data isolation
  - Personal job application tracking for individuals
  - Data protection with modern security practices

## 🚀 Tech Stack

- **Modern Framework**: Built on Laravel 12, the latest version of PHP's most elegant framework
- **Beautiful Admin Panel**: Powered by Filament 3 for a responsive, feature-rich interface
- **Robust Database**: Compatible with MySQL and PostgreSQL for reliable data storage
- **Reactive Frontend**: Leveraging Livewire and Tailwind CSS for a smooth, modern UI experience
- **Developer-Friendly**: Includes Laravel Debugbar, Laravel IDE Helper, and Laravel Telescope for easy maintenance and extension

## 📦 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL or PostgreSQL
- Node.js and NPM

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/Bender-0/career-compass.git
   cd career-compass
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Set up environment variables**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure your database in the .env file**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=career_compass
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations, seed the database and link storage**
   ```bash
   # Run migrations and seed the database with sample data
   php artisan migrate --seed
   
   # Create a symbolic link for file storage
   php artisan storage:link
   
   # Clear configuration cache
   php artisan config:clear
   php artisan cache:clear
   
   # If you want to reset and reseed the database:
   php artisan migrate:fresh --seed
   ```

## 🎯 Sample Data

The application comes with sample data to help you get started. After running the migrations with the `--seed` flag, you'll have:

- 1 sample user (user@example.com / password)
- 18 sample job applications
- Associated contacts, notes, and tasks

To reset and reseed the database at any time, run:

```bash
php artisan migrate:fresh --seed
```

6. **Install frontend dependencies**
   ```bash
   npm install
   ```

7. **Start the development server**
   ```bash
   composer run dev
   ```
   OR
   ```bash
   npm run dev
   ```
   ```bash
   php artisan serve
   ```

8. **Access the application**
   Visit `http://localhost:8000/` in your browser
   ```
    user: user@example.com
    password: password
   ```

## 🧭 Getting Started with CareerCompass

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

## 🔄 Data Import/Export

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

## 🛠️ Customization

The application can be extended with additional features:

- Custom status workflows
- Email notifications for application updates
- Interview scheduling
- Salary negotiation tracking

## 🛠️ Customization & Extension

CareerCompass is designed to be highly customizable and extensible. Some popular customizations include:

- **Custom Application Stages**: Tailor the workflow to match your specific job search process
- **Email Notifications**: Set up alerts for application deadlines, interview reminders, and follow-ups
- **Interview Scheduling**: Integrate with calendar systems for seamless interview management
- **Salary Negotiation Tracking**: Add specialized tools for tracking offers and negotiations
- **Analytics Dashboard**: Gain insights into your job search patterns and success rates

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

<p align="center">Built with ❤️ using Laravel and Filament</p>
<p align="center">Take control of your career journey with CareerCompass</p>
