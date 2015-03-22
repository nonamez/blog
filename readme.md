# Yet Another Laravel Blog (http://nonamez.name)

This is the source code of my [personal blog](http://nonamez.name). I published it just in case it would help You. It's developed using the [Laravel 4 Framework](http://http://laravel.com/docs/4.2).

## Installation

The dependencies are resolved using [composer](http://getcomposer.org/).

To install just follow this steps:

```
git clone git://github.com/nonamez/blog.git
cd blog
composer install
php artisan key:generate
```
Now you need to add connection to database in `app/config/database.php`

```
php artisan migrate
php artisan db:seed
cd public
php -S 127.0.0.1:8081
```
Thats it. Open a browser at http://127.0.0.1:8081/ and you should see the blog.

### What about a ...
Currently there is no UI so just look at `app/database/seeds/FirstPostAndTagSeeder.php` for current functionality


## Author

Kiril Chalkin - <hello@nonamez.name>