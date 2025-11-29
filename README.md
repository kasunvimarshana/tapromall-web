# TaproMall Web

[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](LICENSE-2.0.txt)
[![PHP Version](https://img.shields.io/badge/PHP-7.2%2B-purple.svg)](https://www.php.net/)

TaproMall is a multi-classified, multi-tenant, multi-vendor marketplace application built for global users. Developed with SOLID, DRY, and clean-code principles, it delivers intelligent search, personalized recommendations, real-time updates, secure transactions, and seamless management of products, services, vehicles, real estate, and jobs.

## Features

- **Multi-classified ads support** - Products, services, vehicles, real estate, jobs
- **Multi-tenant architecture** - Support for multiple independent marketplaces
- **Multi-vendor marketplace** - Enable multiple sellers to list and manage their offerings
- **Intelligent search** - Advanced search functionality with filters and sorting
- **Personalized recommendations** - User-specific content suggestions
- **Real-time updates** - Live notifications and content updates
- **Secure transactions** - Built-in security for safe marketplace operations
- **Extensible plugin system** - Easily extend functionality with plugins
- **Customizable themes** - Child theme support for personalized designs

## Directory Structure

```
tapromall-web/
├── docs/                   # Documentation files
├── oc-admin/               # Admin panel files
├── oc-content/             # Content directory (themes, plugins, uploads)
│   ├── themes/             # Frontend themes
│   ├── plugins/            # Installed plugins
│   ├── uploads/            # User uploaded files
│   └── languages/          # Translation files
├── oc-includes/            # Core framework files
│   ├── osclass/            # Osclass core
│   │   ├── classes/        # Core classes
│   │   ├── controller/     # Controllers
│   │   ├── helpers/        # Helper functions
│   │   └── model/          # Database models
│   └── vendor/             # Third-party libraries
├── config-sample.php       # Sample configuration file
├── index.php               # Application entry point
└── oc-load.php             # Bootstrap loader
```

## Requirements

- **PHP**: 7.2 or higher (PHP 8.x recommended)
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **Web Server**: Apache or Nginx
- **PHP Extensions**: mysqli, gd or imagick, curl, zip, mbstring

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/kasunvimarshana/tapromall-web.git
   cd tapromall-web
   ```

2. **Configure the application**
   ```bash
   cp config-sample.php config.php
   ```
   Edit `config.php` and set your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASSWORD', 'your_password');
   define('DB_NAME', 'tapromall_db');
   ```

3. **Set up your web server**
   - Point your web server document root to the project directory
   - Ensure the `oc-content` directory is writable

4. **Complete the installation**
   - Navigate to your domain in a web browser
   - Follow the installation wizard to complete setup

## Configuration

For advanced configuration options, see the [Developer Guide](docs/DEVELOPER_GUIDE.md#advanced-configuration). Key configuration options include:

- Database settings
- URL and path configuration
- Debug options
- Cache configuration (Memcached, Redis, APC)
- Email/SMTP settings

## Documentation

- **[Developer Guide](docs/DEVELOPER_GUIDE.md)** - Comprehensive guide for developers including:
  - Helper functions reference
  - Programming standards
  - Theme customization
  - Hooks and filters
  - Plugin development
  - Child themes

## Changelog

See [CHANGELOG.txt](CHANGELOG.txt) for a detailed list of changes and version history.

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

Please ensure your code follows the existing coding standards and includes appropriate documentation.

## License

This project is licensed under the Apache License 2.0 - see the [LICENSE-2.0.txt](LICENSE-2.0.txt) file for details.

## Credits

Built on the [Osclass](https://osclass-classifieds.com/) framework.

## Support

For questions and support, please open an issue in the [GitHub repository](https://github.com/kasunvimarshana/tapromall-web/issues).
