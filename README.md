# Technical assignment back-end engineer

As part of an engineering team, you are working on an online shopping platform. The sales team wants to know which items were added to a basket, but removed before checkout. They will use this data later for targeted discounts.

Using the agreed upon programming language, build a solution that solves the above problem.

**Scope**

-   Focus on the JSON API, not on the look and feel of the application.

**Timing**

You have one week to accomplish the assignment. You decide yourself how much time and effort you invest in it, but one of our colleagues tends to say: "Make sure it is good" ;-). Please send us an email (jobs@madewithlove.com) when you think the assignment is ready for review. Please mention your name, Github username, and a link to what we need to review.

# MyShop

Online shopping business implementation

## Table of Contents

-   [Technologies](#technologies)
-   [Getting Started](#getting-started)
    -   [Installation](#installation)
    -   [Database Structure](#database-structure)
    -   [Test Credentials](#test-credentials)
    -   [Usage](#usage)

## Technologies

-   [Laravel](https://laravel.com/) - PHP web framework

This project runs on Laravel 9 and requires PHP 8.0+ .

## Getting Started

### Installation

-   git clone
    [MyShop](https://github.com/madewithlove/technical-assignment-back-end-engineer-mikkycody.git)
-   Run `composer install` to install packages .
-   Copy .env.example file, create a .env file if not created and edit database credentials there .
-   Copy .env.example file, create a .env.testing file if not created and edit database credentials there for testing, you can use in-memory db sqlite (If using in memory do not forget to create a database.sqlite file).
-   Run `php artisan key:generate` to set application key to secure user sessions and other encrypted data .
-   Run `php artisan migrate:fresh --seed` to run database migrations and seed data.
-   Run `php artisan passport:client --personal` to generate passport client ID.
-   Run `php artisan serve` to start the server (Ignore if using valet) .
-   Run `php artisan test` to run tests .

### Database Structure

![structure](https://res.cloudinary.com/dshz14tzy/image/upload/v1645311950/mikkycody/Untitled_vrp27d.png)

### Test Credentials

- Admin 
Email : admin@myshop.com , Password : password. 

- User 
Email : user@myshop.com , Password : password. 

- Sales Rep 
Email : salesrep@myshop.com , Password : password. 

### Usage
-   Please click [here](https://documenter.getpostman.com/view/13274153/UVkjwJ77) to access the Postman Collection

This is the basic flow of the appkication.

- Register
- Login
- To create a new product, be logged in as an admin (Only an admin can access this endpoint)
- As a normal user, to initiate an order, hit the create cart endpoint and add product(s) to the cart.
- A user can remove a product from cart (only before checkout)
- A sales rep can login and hit the "removed items" endpoint to get the list of products that were removed before checkout 

### Limitations
-  I would have used redis caching to ensure calling the endpoints more efficiently
- I would have handled more edge cases


## Conclusion

Hire me 🙂
