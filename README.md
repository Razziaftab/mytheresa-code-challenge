# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/Razziaftab/mytheresa-code-challenge.git

Switch to the repo folder

    cd mytheresa-code-challenge

Install all the dependencies using composer

    composer install

Setup your local database with these credentials

    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=mytheresa
    DB_USERNAME=root
    DB_PASSWORD=123

Run the database migrations and seeder (Set the database connection in .env before migrating)

    php artisan migrate --seed

Run the command to clear cache

    php artisan cache:clear

Run test cases command

    composer test

Start the local development server

    php -S localhost:8000 -t public

Now you can access the end point for the list of products

    http://127.0.0.1:8000/api/products
