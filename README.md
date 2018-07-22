## Laravel Application Starter

A reasonable laravel application architecture.

### System Requirements

1. MySQL 5.6+
2. PHP7+
3. Composer
4. PHPUnit
5. PHPCS

### Installlation

```
$ git clone git@github.com:johndavedecano/backend-api-starter.git project && cd project
$ cp .env.example .env # Edit .env accordingly then save.
$ composer install
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
```

### Layers

The default place to “put things” in a Laravel project a lot of the time is the controller or models. However
in the long run, our controller gets bloated or what they call FAT CONTROLLERS or FAT MODELS. To avoid this, we 
have to decouple our applications into different reasonable layers such as follows.

* Model or Entity - A class that represents a certain table schema and its relationship to other tables. 
* Repository - A repository holds data related logics. Such as creating, update, listing, deleting and other complicated queries for our models.
* Controllers -  A controller should only accept a request and return a response. It shouldn’t contain any business logic or data layer knowledge.
* Requests - Form requests are custom request classes that contain validation logic.
* Services - A class that holds business logic. This is also a good way to clean up your controllers, and make them more readable.
* Utils - A collection of useful PHP functions, mini classes and snippets that you need and can use every day.
* Value Objects - In computer science, a value object is a small object that represents a simple entity whose equality is not based on identity: i.e. two value objects are equal when they have the same value, not necessarily being the same object. Examples of value objects are objects representing an amount of money or a date range.

### Authentication Service Endpoints

| Method   | URI                        | Action                                                       |
|----------|----------------------------|--------------------------------------------------------------|
| GET|HEAD | /                          | Closure                                                      |
| POST     | api/v1/auth/activate       | App\Http\Controllers\V1\Auth\RegistrationController@activate |
| POST     | api/v1/auth/email          | App\Http\Controllers\V1\Auth\EmailController@update          |
| POST     | api/v1/auth/email/activate | App\Http\Controllers\V1\Auth\EmailController@activate        |
| POST     | api/v1/auth/forgot         | App\Http\Controllers\V1\Auth\ForgotPasswordController@forgot |
| POST     | api/v1/auth/login          | App\Http\Controllers\V1\Auth\LoginController@login           |
| POST     | api/v1/auth/logout         | App\Http\Controllers\V1\Auth\LoginController@logout          |
| POST     | api/v1/auth/me             | App\Http\Controllers\V1\Auth\UserController@me               |
| POST     | api/v1/auth/refresh        | App\Http\Controllers\V1\Auth\LoginController@refresh         |
| POST     | api/v1/auth/register       | App\Http\Controllers\V1\Auth\RegistrationController@register |
| POST     | api/v1/auth/resend         | App\Http\Controllers\V1\Auth\RegistrationController@resend   |
| POST     | api/v1/auth/reset          | App\Http\Controllers\V1\Auth\ResetPasswordController@reset   |


### Unit Testing

```
$ ./vendor/bin/phpunit --testdox
```

### Code Standards

```
$ ./vendor/bin/phpcs
```

