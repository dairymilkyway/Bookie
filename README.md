# Bookie

A Laravel-based application for managing books in an educational environment with role-based access for teachers and students.

## Description

This Book Management System allows teachers to create and manage digital books, assign them to students, and handle book requests. Students can browse available books, request specific books, and access assigned materials. The system implements a clean role-based authentication system with separate interfaces for teachers and students.

### Main Features
- User authentication and role-based access control
- Teacher dashboard for book management
- Student interface for browsing and requesting books
- Book assignment system
- Book request approval workflow
- Responsive web interface

## Installation Instructions

### Prerequisites
- PHP ^8.2
- Composer
- Node.js and npm
- Database (MySQL, PostgreSQL, or SQLite)

### Setup Steps

1. Clone the repository:
```bash
git clone https://github.com/dairymilkyway/Bookie.git
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Copy the environment file and generate application key:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database settings in the `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Seed the database with initial roles (optional):
```bash
php artisan db:seed
```

8. Build the frontend assets:
```bash
npm run build
```

## Usage Instructions

### Development Server
To run the application in development mode:
```bash
npm run dev
```
or use the Laravel Artisan command:
```bash
php artisan serve
```

### Production Build
To create a production-ready build:
```bash
npm run build
```

### Running Tests
Execute the test suite with:
```bash
php artisan test
```

## Features

### Authentication
- User registration and login
- Role-based access control (Teacher/Student)
- Remember me functionality
- Secure password hashing

### Teacher Features
- Dashboard overview
- Create, read, update, and delete books
- Assign books to students
- Manage book requests (approve/decline)
- Search for students to assign books

### Student Features
- Browse available books
- View assigned books
- Request specific books
- Track book request status

### Admin Features
- User management
- Role assignment
- System monitoring

## Folder Structure Overview

```
book-management-system/
├── app/                    # Application source code
│   ├── Http/              # Controllers, middleware
│   │   ├── Controllers/   # Request handlers
│   │   └── Middleware/    # Request filters
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── bootstrap/             # Framework bootstrapping
├── config/                # Configuration files
├── database/              # Migrations, seeds, factories
│   ├── factories/         # Model factories
│   ├── migrations/        # Database schema
│   └── seeders/           # Data seeders
├── public/                # Public assets and index.php
├── resources/             # Views, raw assets
├── routes/                # Application routes
├── storage/               # Compiled templates, logs
├── tests/                 # Test files
├── vendor/                # Composer dependencies
├── composer.json          # PHP dependencies
├── package.json           # Node.js dependencies
├── vite.config.js         # Vite build configuration
└── .env                   # Environment variables
```

## Technologies and Libraries Used

### Backend
- **Laravel 12.x** - PHP web framework
- **PHP 8.2+** - Programming language
- **Composer** - Dependency manager

### Frontend
- **Tailwind CSS 4.x** - Utility-first CSS framework
- **DaisyUI** - Component library for Tailwind
- **jQuery 4.x** - JavaScript library
- **Vite** - Build tool
- **Axios** - HTTP client

### Development Tools
- **Laravel Pint** - Code formatter
- **PHPUnit** - Testing framework
- **Faker** - Fake data generator
- **Laravel Sail** - Docker development environment

### Database
- **Eloquent ORM** - Object-relational mapping
- Support for MySQL, PostgreSQL, SQLite, and SQL Server

## Database Schema

The application uses the following main tables:
- `users` - Stores user accounts
- `roles` - Defines user roles (Teacher, Student)
- `user_roles` - Junction table for user-role relationships
- `books` - Stores book information
- `book_assignments` - Links students to assigned books
- `book_requests` - Tracks student book requests

## Contribution Guidelines

### Getting Started
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Add tests if applicable
5. Run the test suite (`php artisan test`)
6. Commit your changes (`git commit -m 'Add amazing feature'`)
7. Push to the branch (`git push origin feature/amazing-feature`)
8. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Use Laravel best practices
- Write meaningful commit messages
- Include tests for new features
- Update documentation as needed

### Development Workflow
- Use feature branches for new functionality
- Submit pull requests for code review
- Ensure all tests pass before submitting
- Follow the existing code style

## License Information

This project is licensed under the MIT License - see the LICENSE file for details.

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## Additional Notes

- The application includes a custom setup script that handles installation, environment configuration, and initial migration
- Queue workers and log monitoring can be started using the development script
- The application supports concurrent development with live reloading