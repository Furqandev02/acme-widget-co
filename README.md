# Acme Widget Co Test Task

## Prerequisites

Before running the project, ensure you have the following installed on your local machine:

- **PHP 8.3 or higher** (can be installed via [Homebrew for macOS](https://brew.sh/), or [PHP official site](https://www.php.net/downloads.php) for other OS).
- **Composer** (dependency manager for PHP) installed. You can install Composer from [here](https://getcomposer.org/).
- **Docker** and **Docker Compose** for containerized environments (optional, for using Docker).

## Running the Application Locally

### Step 1: Clone the Repository

Clone this repository to your local machine:

```bash
git clone https://github.com/Furqandev02/acme-widget-co.git
cd acme-widget-co
```

### Step 2: Install Dependencies

Run the following command to install the necessary PHP dependencies via Composer:

```bash
composer install
```

### Step 3: Start PHP Built-in Server

Start the PHP built-in server to serve the application locally:

```bash
php -S localhost:8080 -t public
```

### Step 4: Access the Application

Open your browser and visit http://localhost:8080/index.php to view the example baskets and their calculated totals.

## Running the Application with Docker

To run the application in a Docker container, follow these steps:

### Step 1: Build the Docker Image

Build the Docker image using the following command:

```bash
docker-compose build
```

### Step 2: Run the Docker Container

After the image is built, start the container:

```bash
docker-compose up
```

This will start the PHP built-in server inside the container, and you can access the application at http://localhost:8080/index.php.

## Testing

This project includes PHPUnit tests that verify the behavior of the basket, delivery charges, and offers.

### Step 1: Run Tests Locally

To run the tests locally using PHPUnit, execute the following command:

```bash
./vendor/bin/phpunit tests
```

Or

#### Run a Specific Test Case

If you want to run a specific test case (for example, a test case from BasketTest.php), use the following command:

```bash
./vendor/bin/phpunit tests/BasketTest.php --filter testBasketTotalWithoutOffers
```

#### **Explanation**:

- The **`tests/BasketTest.php`** part indicates the specific test case file where the test method is located.
- The **`--filter`** option is followed by the **test method name** (`testBasketTotalWithoutOffers` in this example), which allows you to run a specific test from the test case.
- You can replace the test method name with any other method name from the file to run a different test.

### Step 2: Run Tests in Docker

To run tests inside the Docker container, use:

```bash
docker-compose run app ./vendor/bin/phpunit tests
```

Or

Run a Specific Test Case in Docker

To run a specific test case inside the Docker container, use:

```bash
docker-compose run app ./vendor/bin/phpunit tests/BasketTest.php --filter testBasketTotalWithoutOffers
```

## Code Analysis

This project uses PHPStan for static analysis. To analyze the code for potential issues, run the following command locally:

```bash
./vendor/bin/phpstan analyse src
```

Or, inside Docker:

```bash
docker-compose run app ./vendor/bin/phpstan analyse src
```
