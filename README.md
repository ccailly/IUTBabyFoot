<p align="center"><a href="https://babyiut.fr" target="_blank"><img src="https://i.ibb.co/kqf5tL6/Mockup.png" width="400" alt="IUTBabyFoot Mockup"></a></p>

<p align="center">
    <a href="https://GitHub.com/FragDev/IUTBabyFoot/commit/">
        <img src="https://badgen.net/github/commits/FragDev/IUTBabyFoot" alt="GitHub commits">
    </a>
    <a href="https://GitHub.com/FragDev/IUTBabyFoot/issues/">
        <img src="https://badgen.net/github/issues/FragDev/IUTBabyFoot/" alt="GitHub issues">
    </a>
    <a href="https://GitHub.com/FragDev/IUTBabyFoot/graphs/contributors/">
        <img src="https://badgen.net/github/contributors/FragDev/IUTBabyFoot" alt="GitHub contributors">
    </a>
</p>

## About IUTBabyFoot

IUTBabyFoot is a web application, under Laravel framework, whose goal is to collect statistics of table soccer matches.

## Features

-   Live matches
-   Adding matches
-   Betting system
-   Player ranking
-   Advanced statistics
-   Connection with Discord

IUTBabyFoot is designed to be used on a smartphone but works completely on any other device.

## Installation

### Requirements

-   PHP >= 8.0
-   MySQL
-   Composer
-   NodeJS
-   NPM
-   Laravel 9.X requirements

### Installation

1. Clone the repository
2. Install dependencies with `composer install`
3. Install dependencies with `npm install`
4. Create a `.env` file with `cp .env.example .env`
5. Generate an application key with `php artisan key:generate`
6. Create a database and configure the `.env` file
7. Run the migrations with `php artisan migrate`
8. Run the server with `php artisan serve`
9. Run the vite server with `npm run dev`

### Build

To build the application, run `npm run build`.

## License

IUTBabyFoot is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).