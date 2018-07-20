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