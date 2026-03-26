# Bawidełka - Laravel & React Project

This is a web application for Bawidełka, built with Laravel on the backend and React with Inertia.js on the frontend. The admin panel is powered by Filament.

## Prerequisites

Before you begin, ensure you have the following installed on your local machine:

- PHP (version specified in `composer.json`, e.g., ^8.4)
- Composer
- Node.js & npm
- A database server (e.g., MySQL, PostgreSQL, SQLite)

## Project Setup Instructions

Follow these steps to get your development environment set up.

### 1. Clone the Repository

First, clone this repository to your local machine.

```sh
git clone <your-repository-url>
cd laraval_b2
```

### 2. Install Dependencies

Install both PHP and JavaScript dependencies.

```sh
# Install Composer (PHP) dependencies
composer install

# Install NPM (JavaScript) dependencies
npm install
```

### 3. Environment Configuration

Create your environment file by copying the example file.

```sh
cp .env.example .env
```

Now, open the `.env` file and configure your database connection details (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) and set the application URL.

For local development with `php artisan serve`, your `APP_URL` should typically be:

```
APP_URL=http://localhost:8000
```

### 4. Generate Application Key

Generate a unique application key for your project.

```sh
php artisan key:generate
```

### 5. Run Database Migrations

Set up the database schema by running the migrations.

```sh
php artisan migrate
```

### 6. Seed the Database

Populate the database with default data, such as the admin user and application variables.

```sh
php artisan db:seed
```

This will run the `DatabaseSeeder`, which in turn calls other seeders like `VariableSeeder`.

### 7. Link Storage

Create a symbolic link from `public/storage` to `storage/app/public`. This is crucial for making uploaded files (like images for "Reasons") publicly accessible.

```sh
php artisan storage:link
```

**Note:** If the link already exists, you'll see an error message. This is normal and safe to ignore. The link ensures that files in `storage/app/public` are accessible via the web through the `public/storage` directory.

### 8. Build Frontend Assets

Compile the frontend assets (React components, CSS, etc.).

```sh
npm run build
```

## Running the Development Server

### Option 1: Local Development

To run the application locally, you'll need to start both the PHP server and the Vite development server for the frontend.

1.  **Start the Laravel Server:**

    ```sh
    php artisan serve
    ```

    By default, this will run on `http://localhost:8000`.

2.  **Start the Vite Server:**
    In a separate terminal window, run the Vite development server. This will watch for changes in your JavaScript and CSS files and provide hot module replacement (HMR).
    ```sh
    npm run dev
    ```

### Option 2: Laravel Sail (Docker)

This project includes Laravel Sail for Docker-based development.

1.  **Start Sail containers:**

    ```sh
    ./vendor/bin/sail up -d
    ```

2.  **Run commands through Sail:**

    ```sh
    # Install dependencies
    ./vendor/bin/sail composer install
    ./vendor/bin/sail npm install

    # Generate key and migrate
    ./vendor/bin/sail php artisan key:generate
    ./vendor/bin/sail php artisan migrate
    ./vendor/bin/sail php artisan storage:link

    # Start development server
    ./vendor/bin/sail npm run dev
    ```

3.  **Access the application:**
    The application will be available at `http://localhost` (configured in your `.env` file).

Now you can access your application at the URL provided by the server.

## Admin Panel

The admin panel is built with Filament. You can access it at `/admin`.

- **Default User:** A default user is created by the `DatabaseSeeder`.
- **Email:** `test@example.com`
- **Password:** `password` (or as defined in the `UserFactory`)

## Custom Artisan Commands

### Clear All Caches

A custom command is available to clear all relevant application caches at once.

```sh
php artisan app:clear-all-cache
```

This command clears the application, route, configuration, and view caches.

---

## Deployment to Production

Follow these steps to deploy the application to a production server.

### 1. Server Configuration

Ensure your server is configured to serve a Laravel application. The web server (e.g., Nginx, Apache) should have its document root set to the `public` directory of your project.

### 2. Environment File

On your production server, create a `.env` file with your production-specific settings:

- Set `APP_ENV` to `production`.
- Set `APP_DEBUG` to `false`.
- Configure your production database credentials.
- Set `APP_URL` to your public domain (e.g., `https://bawidelka.pl`).

### 3. Install Dependencies

Install Composer dependencies without the dev packages for a lean production environment.

```sh
composer install --optimize-autoloader --no-dev
```

Install and build your frontend assets.

```sh
npm install
npm run build
```

### 4. Run Production Commands

Run the following commands to prepare your application for production:

```sh
# Generate a new application key (if not already set in .env)
php artisan key:generate --force

# Run database migrations
php artisan migrate --force

# Link storage
php artisan storage:link

# Filament prepare assets
php artisan filament:assets

# Cache configuration and routes for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. File Permissions

Ensure that the `storage` and `bootstrap/cache` directories are writable by your web server.

### 6. Queue Worker (Optional)

If your application uses queues, set up a service like Supervisor to keep the queue worker running in the background.

```sh
# Example Supervisor configuration
[program:laravel-bawidelka-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=your-server-user
numprocs=8
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
```
