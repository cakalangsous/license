<p align="center">
  <img src="public/assets/images/logo/logo.png" alt="Laraku Logo" width="200">
</p>

<h1 align="center">Laraku</h1>

<p align="center">
  <strong>A Modern Laravel Admin Panel for Building Web Applications Quickly</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#requirements">Requirements</a> •
  <a href="#installation">Installation</a> •
  <a href="#demo">Demo</a> •
  <a href="#documentation">Documentation</a> •
  <a href="#support">Support</a>
</p>

---

## About Laraku

Laraku is a beautifully designed, feature-rich Laravel admin panel that accelerates your development workflow. Built with Laravel 12, Vue 3, Inertia.js, and Tailwind CSS, it provides everything you need to build and manage modern web applications.

## Features

### 🔐 Authentication & Security

- User Authentication with Remember Me
- Two-Factor Authentication (2FA)
- Password Reset
- Login Throttling
- Session Management

### 👥 User Management

- User CRUD Operations
- Avatar Upload
- User Roles & Permissions (Spatie)
- Role-based Access Control

### 📝 Content Management

- Posts/Blog Management
- Categories & Tags
- Rich Text Editor
- SEO-friendly URLs

### 🛠️ Developer Tools

- **CRUD Generator** - Generate complete CRUD modules automatically
- API with Laravel Sanctum
- API Documentation (Scramble)
- Activity Logging

### 📊 Admin Features

- Modern Dashboard
- Dynamic Sidebar Menu Builder
- Media Library Management
- Application Settings
- System Health Monitoring
- Database Backup & Restore
- Notifications System

### 🎨 UI/UX

- Modern, Clean Interface
- Dark Mode Support
- Fully Responsive Design
- Beautiful Landing Page
- Blog Frontend

## Requirements

- PHP >= 8.3
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js >= 18
- Composer >= 2.0
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- GD PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- ZIP PHP Extension

## Installation

### Option 1: Web Installer (Recommended)

1. Upload the files to your server
2. Navigate to your domain in a browser
3. Follow the installation wizard
4. Configure your database credentials
5. Complete the installation

### Option 2: Manual Installation

```bash
# Clone the repository
git clone https://github.com/cakalangsous/laraku.git

# Navigate to the project directory
cd laraku

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env file
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations and seeders
php artisan migrate --seed

# Create storage link
php artisan storage:link

# Build assets for production
npm run build

# Or for development
npm run dev
```

## Default Credentials

After installation, you can login with:

| Role        | Email           | Password |
| ----------- | --------------- | -------- |
| Super Admin | admin@admin.com | password |

> ⚠️ **Important:** Change the default password immediately after first login!

## Demo

Visit our demo site to explore Laraku features:

- **URL:** [Demo Link]
- **Email:** demo@demo.com
- **Password:** demo123

## Documentation

For detailed documentation, visit: [Documentation Link]

The documentation includes:

- Installation Guide
- Configuration
- Feature Guides
- Customization
- API Reference
- Troubleshooting

## Tech Stack

| Technology   | Version |
| ------------ | ------- |
| Laravel      | 12.x    |
| Vue.js       | 3.x     |
| Inertia.js   | 2.x     |
| Tailwind CSS | 4.x     |
| PHP          | 8.3+    |

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for a list of changes.

## Support

- 📧 **Email:** [Your Support Email]
- 📖 **Documentation:** [Documentation Link]
- 🐛 **Issues:** [GitHub Issues Link]

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

<p align="center">
  Made with ❤️ by <a href="https://github.com/cakalangsous">Cakalang Sous</a>
</p>
