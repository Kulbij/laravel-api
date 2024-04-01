# About API

This project is an API application developed using the Laravel framework. It allows interaction with the backend through API requests and is intended for use with frontend applications. The application is designed to be able to work and add additional integration with other services.

## Technologies

- Laravel 8+
- PHP 7.4+
- PostgreSQL
- Redis
- Docker
- Swagger

## Integrations
- DataForSeo - integration with the DataForSeo service to retrieve data about competitor domains. The response about domains are stored in the database.

## Console Command

A console command is available to perform the creation of statuses obtained from the DataForSeo service:

php artisan appendix:errors


## Data Validation

Request data validation is implemented to handle API requests.

## Swagger

The API of project is documented using Swagger.

## Installation

Follow these steps to install the project:
1. Clone the repository to your local machine:
```bash
git clone https://github.com/Kulbij/laravel-api.git
```

2. Navigate to the project directory:
```bash
cd laravel-api
```

3. Install Composer dependencies:
```bash
composer install
```

4. Copy the `.env.example` file to `.env` and configure your environment variables, including database settings and DataForSeo API credentials.
```bash
cp .env .env.example
```

5. Generate an application key:
```bash
php artisan key:generate
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Run the console command to create statuses:
```bash
php artisan appendix:errors
```

8. Start the Laravel development server:
```bash
php artisan serve
```

8. Your project should now be accessible at `http://localhost:8000`.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/license/MIT).