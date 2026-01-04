# Bayan Pro

## Project Overview

Bayan Pro is a comprehensive **Client & Project Management System** built with **Laravel 12**. It is designed to streamline business operations by managing clients, projects, tasks, financial documents (invoices & quotations), and system settings.

**Key Features:**
- **Client Management:** Manage client details and relationships.
- **Project & Task Tracking:** Organize work into projects and track progress via tasks.
- **Financial Management:** Create and manage Invoices and Quotations.
- **Admin Dashboard:** Centralized control for all business operations.
- **Tech Stack:** Laravel 12, Tailwind CSS, Alpine.js, SQLite/MySQL.

## Deployment Guide

Follow these steps to set up the project on your local machine or production server.

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx) or Laravel Sail
- Database (SQLite, MySQL, or MariaDB)

### Installation Steps

1.  **Clone the Repository**
    ```bash
    git clone <repository_url>
    cd bayan_pro
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    npm run build
    ```

3.  **Environment Configuration**
    Copy the example environment file and configure it.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    **Required `.env` Values:**
    Ensure the following variables are set correctly in your `.env` file:
    ```ini
    APP_NAME="BayanPro"
    APP_ENV=production  # Use 'local' for development
    APP_URL=https://your-domain.com

    # Database Configuration
    DB_CONNECTION=mysql # or sqlite
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bayan_pro
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password

    # Mail Configuration (Required for notifications)
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="info@bayanpro.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

4.  **Database Setup**
    Run the migrations to create the necessary tables.
    ```bash
    php artisan migrate
    ```

5.  **Seed the Database**
    Populate the database with demo data and the default admin user.
    ```bash
    php artisan db:seed
    ```

### Default Admin Credentials
- **Email:** `admin@example.com`
- **Password:** `password`


### Post-Deployment & Permissions (Critical)

After deploying the code, you **must** run the following commands to ensure the application allows file uploads and logging correctly:

```bash
# Create the symbolic link for public storage
php artisan storage:link

# Create the log file if it implies missing
touch storage/logs/laravel.log

# specific permission command
sudo chmod -R ugo+rw storage
```

### Local Development
To start the local development server:
```bash
npm run dev
php artisan serve
```

## Contributing
1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a Pull Request.

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
