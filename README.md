## Laravel Application Starter

A reasonable laravel application architecture.

### Layers

The default place to “put things” in a Laravel project a lot of the time is the controller or models. However
in the long run, our controller gets bloated or what they call FAT CONTROLLERS or FAT MODELS. To avoid this, we 
have to decouple our applications into different reasonable layers such as follows.

* Model or Entity - A class that represents a certain table schema and its relationship to other tables. 
* Repository - A repository holds data related logics. Such as creating, update, listing, deleting and other complicated queries for our models.
* Controllers -  A controller should only accept a request and return a response. It shouldn’t contain any business logic or data layer knowledge.
* Requests - Form requests are custom request classes that contain validation logic.
* Services - A class that holds business logic. This is also a good way to clean up your controllers, and make them more readable.

### Initial Endpoints

| Method   | URI                        | Action                                                       | Middleware   |
|----------|----------------------------|--------------------------------------------------------------|--------------|
| GET|HEAD | /                          | Closure                                                      | web          |
| POST     | api/v1/auth/activate       | App\Http\Controllers\V1\Auth\RegistrationController@activate | api          |
| POST     | api/v1/auth/email          | App\Http\Controllers\V1\Auth\EmailController@update          | api,auth:api |
| POST     | api/v1/auth/email/activate | App\Http\Controllers\V1\Auth\EmailController@activate        | api          |
| POST     | api/v1/auth/forgot         | App\Http\Controllers\V1\Auth\ForgotPasswordController@forgot | api          |
| POST     | api/v1/auth/login          | App\Http\Controllers\V1\Auth\LoginController@login           | api          |
| POST     | api/v1/auth/logout         | App\Http\Controllers\V1\Auth\LoginController@logout          | api,auth:api |
| POST     | api/v1/auth/me             | App\Http\Controllers\V1\Auth\UserController@me               | api,auth:api |
| POST     | api/v1/auth/refresh        | App\Http\Controllers\V1\Auth\LoginController@refresh         | api,auth:api |
| POST     | api/v1/auth/register       | App\Http\Controllers\V1\Auth\RegistrationController@register | api          |
| POST     | api/v1/auth/resend         | App\Http\Controllers\V1\Auth\RegistrationController@resend   | api          |
| POST     | api/v1/auth/reset          | App\Http\Controllers\V1\Auth\ResetPasswordController@reset   | api          |
