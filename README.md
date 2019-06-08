##Installation
- Create a database locally named `homestead` utf8_general_ci 
- Download composer https://getcomposer.org/download/
- Clone Laravel/php project from git with ```git clone https://github.com/kirui04/practical.git```
- Rename `.env.example` file to `.env` inside your project root and fill the database information.
  (windows wont let you do it, so you have to open your console cd your project root directory and run `mv .env.example .env` )
- Open the console and cd your project root directory

- Run `./permissions` to fix file permissions
- Run `composer install` or ```php composer.phar install```
- Run `php artisan key:generate` 
- Run `php artisan migrate`
- Run `php artisan serve`

#####You can now access your project at localhost:8000 :)
 