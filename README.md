# LaraBill - Laravel Invoicing System

![Laravel Version](https://img.shields.io/badge/Laravel-11.x-red.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![GitHub Stars](https://img.shields.io/github/stars/adilshahzad/larabill.svg)

> **Simple, powerful, and open-source invoicing system built with Laravel**

LaraBill is a feature-rich, open-source invoicing system that helps freelancers, small businesses, and entrepreneurs manage their billing process efficiently.

## ✨ Features

- ✅ **Customer Management** - Add, edit, delete, and search customers
- ✅ **Invoice Management** - Create, edit, view, and delete invoices
- ✅ **Invoice Items** - Add multiple items per invoice with automatic total calculation
- ✅ **Payment Tracking** - Record payments and track paid/partial/unpaid status
- ✅ **Receipt Generation** - Generate and download PDF receipts
- ✅ **Advance Payments** - Handle overpayments and advance payments seamlessly
- ✅ **Status Tracking** - Automatic status updates (paid, partially paid, unpaid)
- ✅ **Pagination & Search** - Advanced search and pagination for invoices and customers
- ✅ **PDF Generation** - Download professional PDF invoices and receipts
- ✅ **Customizable Templates** - Brand your invoices with custom logos, colors, and fonts
- ✅ **Dashboard Analytics** - Visual charts and metrics (revenue trends, status distribution)
- ✅ **Responsive Design** - Works perfectly on desktop, tablet, and mobile
- ✅ **Support** - Ways to support and contribute to LaraBill

## 🚀 Quick Start

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL / PostgreSQL / SQLite
- Node.js & NPM (optional, for frontend assets)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/adilshahzad/larabill.git
   cd larabill
   
2. **Install dependencies**
   ```
   composer install
   npm install && npm run dev

3. **Environment setup**
   ```
   cp .env.example .env
   php artisan key:generate

4. **Configure database** 
   ```
   in .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=larabill
   DB_USERNAME=root
   DB_PASSWORD=

5. **Run migrations and seeders**
   ```
   php artisan migrate --seed

6. **Start the development server**
   ```
   php artisan serve

7. **Visit** http://localhost:8000

### 🛠️ Technology Stack
  - Backend: Laravel 11.x
  - Frontend: Bootstrap 5, Blade Templates
  - PDF Generation: Laravel DomPDF
  - Charts: Chart.js
  - Database: MySQL (or any Laravel-supported DB)
  - Icons: Font Awesome (optional)

### 🔧 Usage Guide
  **Creating a Customer**
    1. Navigate to Customers → Add New Customer
    2. Fill in customer details (name, email, phone, address)
    3. Click Create

  **Creating an Invoice**

    1. Navigate to **Invoices → Create New Invoice**
    2. Select a customer
    3. Add invoice items (description, quantity, unit price)
    4. Set invoice date and due date
    5. Click **Create Invoice**

  **Recording a Payment**

    1. Open an invoice detail page
    2. Click Create Receipt
    3. Enter payment date, method, and amount
    4. Click **Create Receipt**
    5. Invoice status auto-updates (partial/paid)

  **Downloading PDF**

  . Click Download PDF on any invoice or receipt detail page    
  
  **Customizing Invoice Template**

    1. Navigate to Template Settings
    2. Upload your logo
    3. Choose primary/secondary colors
    4. Select font family
    5. Save changes
  
  **🤝 Contributing**

  Contributions are welcome! Here's how you can help:

    1. Fork the repository
    2. Create a feature branch (git checkout -b feature/AmazingFeature)
    3. Commit your changes (git commit -m 'Add some AmazingFeature')
    4. Push to the branch (git push origin feature/AmazingFeature)
    5. Open a Pull Request
  
  **Development Guidelines**

    . Follow PSR-12 coding standards
    . Write tests for new features
    . Update documentation as needed
    . Keep pull requests focused on single features
  
  **🐛 Reporting Issues**

  Found a bug? Please create an issue with:

    . Clear description of the problem
    . Steps to reproduce
    . Expected vs actual behavior
    . Screenshots (if applicable)
    . Environment details (PHP version, database, OS)
  
  **📝 Roadmap**

    . Multi-currency support
    . Email invoice to customers
    . Recurring invoices
    . Payment gateway integration (Stripe, PayPal)
    . REST API for mobile apps
    . Multi-language support (i18n)
    . Expense tracking
    . Tax/VAT handling
    . Export data to Excel/CSV
    . Client portal for customers
  
  **📄 License**

    This project is licensed under the MIT License - see the LICENSE file for details.
  
  **🙏 Acknowledgments**

    . Laravel - The PHP framework
    . Bootstrap - CSS framework
    . DomPDF - PDF generation
    . Chart.js - Charts and graphs
    . All contributors and open-source community
  
  **📧 Contact**

    . Author: Adil Shahzad
    . GitHub: @adilshahzad 
  
  **⭐ Support**

  You can support LaraBill by:
  
    . Giving it a ⭐ on GitHub
    . Sharing it with others
    . Contributing to the project
    . Sponsoring the development