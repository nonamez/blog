# Yet Another Laravel Blog (http://nonamez.name)

This is the source code of my [personal blog](http://nonamez.name). I published it just in case it would help You. It's developed using the [Laravel 4 Framework](http://http://laravel.com/docs/4.2).

## Installation

The dependencies are resolved using [Composer](http://getcomposer.org/). You also will need [Bower](http://bower.io) and [Gulp](http://gulpjs.com)



Just follow this steps:

```
git clone git://github.com/nonamez/blog.git
cd blog
composer install
bower install
gulp
```
* Open `app/database/seeds/UserSeeder.php` and set your email and password.
* Add connection to database in `app/config/database.php`

```
php artisan key:generate
php artisan migrate
php artisan db:seed
cd public
php -S 127.0.0.1:8081
```
Thats it. Open a browser at http://127.0.0.1:8081/ and you should see the blog.

### How about a...
Just read the code and figure it out.

## Author

Kiril Chalkin - <hello@nonamez.name>