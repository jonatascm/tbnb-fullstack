<p align="center">
  <h1 align="center"> TurnoverBnB - Fullstack Challenge </h1>
  <p align="center"> ![Laravel 6]("https://img.shields.io/badge/laravel%20-%23FF2D20.svg?&style=for-the-badge&logo=laravel&logoColor=white"),![MySQL]("https://img.shields.io/badge/mysql-%2300f.svg?&style=for-the-badge&logo=mysql&logoColor=white"), ![Vue 2]("https://img.shields.io/badge/vuejs%20-%2335495e.svg?&style=for-the-badge&logo=vue.js&logoColor=%234FC08D") </p>
</p>
<br>
<br>

## 1st - Run Laravel Api

Initial configurations:
-Have a composer installed: https://getcomposer.org/download/
-Copy .env.example to .env
-Set mysql database configuration, change this lines in .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=XXXX
DB_USERNAME=XXXXX
DB_PASSWORD=XXXXXX
```

- Run the followings commands in api folder:

```
composer install
php artisan migrate
php artisan serve
```

## 2nd - Run Vue Frontend

Initial configurations:
-Have npm installed: https://www.npmjs.com/get-npm
-Copy .env.example to .env
-Configure the api url to point to laravel api

- Run the followings commands in frontend folder:

```
npm install
npm run serve
```
