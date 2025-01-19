# glennbites

## Project Overview
A Web Application built with the [Laravel PHP Framework](https://laravel.com/) facilitating online ordering for the Glenn High School student store. It aims to solve the bottleneck of the usual in-person checkout process.

## Features
- **Employee POS System**: Designed to run on a Windows 11 device via Microsoft Edge in Kiosk Mode, this POS system provides an interface for Employees to view and fulfill orders, search user accounts, analyze daily sales/order metrics, and view a stream of all activity.
- **Inventory Management**: A centralized inventory management system provides up-to-date information about available stock, as well as reserved stock that has been ordered but not yet picked up.
- **Many more to come!**

## Installation

The best way to get started with Laravel development is with [Laravel Herd](https://laravel.com/docs/11.x/installation#local-installation-using-herd). Once installed on your system, please follow the steps below.

### Steps
1. Clone the repository and enter the directory:
    ```bash
    git clone https://github.com/liambrewer/glennbites.git
    cd glennbites
    ```
2. Install composer and npm dependencies:
    ```bash
    npm install
    composer install
    ```
3. Copy .env.example to .env:
    ```bash
    cp .env.example .env
    ```
4. Generate the Laravel application key and run database migrations:
    ```bash
    php artisan key:generate
    php artisan migrate
    ```
    Optional: seed database with `php artisan db:seed`.
5. Link project to Laravel Herd:
    ```bash
    herd link
    ```
6. Start Vite development server:
    ```bash
    npm run dev
    ```
7. Visit development site at http://glennbites.test


