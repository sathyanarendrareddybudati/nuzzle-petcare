# Nuzzle PetCare 🐾

A comprehensive pet care service platform built with PHP and MySQL, connecting pet owners with professional caretakers.

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Development](#development)
- [Docker Deployment](#docker-deployment)
- [Contributing](#contributing)
- [License](#license)

## 🐕 About

Nuzzle PetCare is a full-featured web application that facilitates connections between pet owners and professional pet caretakers. The platform enables pet owners to find trusted caretakers, manage their pets' profiles, book services, and communicate securely with service providers.

## ✨ Features

### For Pet Owners
- 🔐 User authentication and profile management
- 🐶 Pet profile creation and management
- 📅 Service booking system
- 💬 Messaging system with caretakers
- 📢 Pet adoption/sale advertisements
- ❓ FAQ section for common queries
- 📧 Email notifications

### For Caretakers
- 👤 Caretaker profile creation
- 📊 Dashboard for managing bookings
- 💬 Communication with pet owners
- 📈 Service management

### Admin Features
- 🛠️ Admin dashboard
- 👥 User management
- 📝 Content management (FAQs, policies)
- 📊 Platform oversight

## 🛠️ Tech Stack

- **Backend**: PHP 8.0+
- **Database**: MySQL
- **Authentication**: Custom session-based auth
- **Email**: PHPMailer
- **Firebase**: Integration for additional services
- **Environment Management**: vlucas/phpdotenv
- **Dependency Management**: Composer
- **Containerization**: Docker

## 📦 Requirements

- PHP >= 8.0
- MySQL 5.7+ or MariaDB
- Composer
- Web server (Apache/Nginx) or PHP built-in server
- Docker (optional, for containerized deployment)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd nuzzle-petcare
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Set Up Environment Variables

```bash
cp .env.example .env
```

Edit the `.env` file with your configuration:
- Database credentials
- Firebase configuration
- Email settings (SMTP)
- Application URL

### 4. Set Up Database

Create a MySQL database and import the schema from the `database` directory.

```bash
mysql -u your_username -p your_database < database/schema.sql
```

### 5. Configure Permissions

Ensure the `uploads` directory is writable:

```bash
chmod -R 755 uploads
```

## ⚙️ Configuration

The application uses environment variables for configuration. Key settings include:

- **Database**: Connection details for MySQL
- **Firebase**: API credentials for Firebase services
- **Email**: SMTP settings for sending emails
- **App Settings**: Base URL, environment mode (dev/production)

Refer to `.env.example` for all available configuration options.

## 🎯 Usage

### Development Server

Start the PHP built-in development server:

```bash
php -S localhost:8000
```

Visit `http://localhost:8000` in your browser.

### Production

For production deployment, configure your web server (Apache/Nginx) to point to the project root directory. Ensure `.htaccess` is properly configured for URL rewriting.

## 📁 Project Structure

```
nuzzle-petcare/
├── assets/              # Static assets (CSS, JS, images)
├── config/              # Configuration files
├── database/            # Database schemas and migrations
├── routes/              # Application routes
│   └── web.php         # Web routes definition
├── src/                 # Application source code
│   ├── Controllers/    # Request handlers
│   ├── Core/           # Core framework components
│   ├── Middleware/     # HTTP middleware
│   ├── Models/         # Data models
│   ├── Services/       # Business logic services
│   └── helpers.php     # Helper functions
├── uploads/            # User uploaded files
├── vendor/             # Composer dependencies
├── views/              # View templates
│   ├── admin/         # Admin views
│   ├── auth/          # Authentication views
│   ├── bookings/      # Booking management views
│   ├── caretaker/     # Caretaker views
│   ├── dashboard/     # User dashboard
│   ├── faq/           # FAQ views
│   ├── home/          # Homepage
│   ├── layouts/       # Layout templates
│   ├── messages/      # Messaging views
│   ├── my-pets/       # Pet management views
│   ├── partials/      # Reusable view components
│   └── ...
├── .env               # Environment configuration
├── .htaccess          # Apache rewrite rules
├── composer.json      # PHP dependencies
├── Dockerfile         # Docker configuration
├── index.php          # Application entry point
└── README.md          # This file
```

## 🔧 Development

### Code Style

The project follows PSR-12 coding standards. Check and fix code style:

```bash
# Check code style
composer check-style

# Auto-fix code style
composer fix-style
```

### Testing

Run PHPUnit tests:

```bash
composer test
```

### Adding New Routes

Routes are defined in `routes/web.php`. Use the Router class to register new routes:

```php
$router->get('/path', [Controller::class, 'method']);
$router->post('/path', [Controller::class, 'method']);
```

### Creating Controllers

Controllers are located in `src/Controllers/`. Extend the base controller if needed:

```php
namespace App\Controllers;

class YourController
{
    public function index()
    {
        // Your logic here
    }
}
```

## 🐳 Docker Deployment

### Build the Docker Image

```bash
docker build -t nuzzle-petcare .
```

### Run the Container

```bash
docker run -p 10000:10000 nuzzle-petcare
```

The application will be available at `http://localhost:10000`.

### Docker Compose (Optional)

For a complete setup with MySQL, create a `docker-compose.yml` file with both the application and database services.

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

Please ensure your code follows PSR-12 standards and includes appropriate tests.

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 📞 Support

For support, please contact the development team or open an issue in the repository.

---

**Made with ❤️ for pet lovers everywhere**
