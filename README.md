
# Coop-Safadeco

Coop-Safadeco is a cooperative management web application built on the foundation of eKoop-Banker. It leverages Laravel 12, Jetstream, Vue 3, and Inertia.js to provide a robust, modern, and user-friendly platform for managing cooperative operations, including member management, financial transactions, and administrative tasks. This README provides all the necessary information to set up, configure, and contribute to the project.

---

## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

---

## Prerequisites

Before setting up Coop-Safadeco, ensure you have the following installed:

- PHP >= 8.2  
- Composer  
- Node.js >= 18  
- MySQL (or XAMPP with MySQL enabled)  
- Git  

---

## Installation

Follow these steps to set up the Coop-Safadeco project on your local machine:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/coop-safadeco.git
   cd coop-safadeco
   ```

2. **Install dependencies:**  
   Install PHP dependencies using Composer and JavaScript dependencies using npm:
   ```bash
   composer install
   npm install
   ```

3. **Set up environment file:**  
   Copy the example environment file and configure it:
   ```bash
   cp .env.example .env
   ```

   Open the `.env` file in a text editor and update the database connection settings:

   ```
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

5. **Run database migrations and seeders:**  
   Create the database schema and populate it with initial data:
   ```bash
   php artisan migrate --seed
   ```

6. **Link storage:**  
   Create a symbolic link for file storage:
   ```bash
   php artisan storage:link
   ```

7. **Start development servers:**

   Run the Laravel development server:
   ```bash
   php artisan serve
   ```

   In a separate terminal, run the frontend development server:
   ```bash
   npm run dev
   ```

---

## Configuration

After installation, you can log in using the default credentials:

- **Email:** admin@coop-safadeco.com  
- **Password:** password  

> ⚠️ It’s recommended to change these credentials after your first login for security purposes.

---

## Usage

Once the development servers are running, access the application by navigating to:

```
http://localhost:8000
```

From there, you can log in with the default credentials and explore features such as member management, financial tracking, and administrative tools.

---

## Contributing

We welcome contributions to Coop-Safadeco! To contribute:

1. Fork the repository  
2. Create a new branch  
   ```bash
   git checkout -b feature/your-feature
   ```
3. Make your changes and commit them  
   ```bash
   git commit -m 'Add your feature'
   ```
4. Push to the branch  
   ```bash
   git push origin feature/your-feature
   ```
5. Open a pull request with a detailed description of your changes  

Please ensure your code follows the project’s coding standards and includes relevant tests.

---

## License

Coop-Safadeco is open-source software licensed under the MIT License.  
See the [LICENSE](LICENSE) file for more details.
