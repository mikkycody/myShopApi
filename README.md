# MyShop

Online shopping business implementation

## Table of Contents

-   [Technologies](#technologies)
-   [Getting Started](#getting-started)
    -   [Installation](#installation)
    -   [Database Structure](#database-structure)
    -   [Test Credentials](#test-credentials)
    -   [Usage](#usage)
    -   [Limitations](#limitations)

## Technologies

-   [Laravel](https://laravel.com/) - PHP web framework

This project runs on Laravel 9 and requires PHP 8.0+ .

## Getting Started

### Installation

-   git clone
    [MyShop](https://github.com/mikkycody/myShopApi.git)
-   Run `composer install` to install packages .
-   Copy .env.example file, create a .env file if not created and edit database credentials there .
-   Copy .env.example file, create a .env.testing file if not created and edit database credentials there for testing, you can use in-memory db sqlite (If using in memory do not forget to create a database.sqlite file).
-   Run `php artisan key:generate` to set application key to secure user sessions and other encrypted data .
-   Run `php artisan migrate:fresh --seed` to run database migrations and seed data.
-   Run `php artisan passport:client --personal` to generate passport client ID.
-   Run `php artisan serve` to start the server (Ignore if using valet) .
-   Run `php artisan test` to run tests .

### Database Structure

![structure](https://res.cloudinary.com/dshz14tzy/image/upload/v1645836478/mikkycody/myshopdbdesign_kbjhak.png)

### Test Credentials

- Admin 
Email : admin@myshop.com , Password : password. 

- User 
Email : user@myshop.com , Password : password. 

- Sales Rep 
Email : salesrep@myshop.com , Password : password. 

### Usage
-   Please click [here](https://documenter.getpostman.com/view/13274153/UVkjwJ77) to access the Postman Collection

This is the basic flow of the application.

- Register
- Login
- To create a new product, be logged in as an admin (Only an admin can access this endpoint)
- A user can create an order.
- A user can remove a product from cart.
- A user can checkout order.
- A sales rep can login and hit the "removed items" endpoint to get the list of products that were removed before checkout 

### Limitations
- Caching is not implemented
