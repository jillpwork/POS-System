# Database Setup (mysql: 5.7)
---
1. Install mysql from below link https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-16-04
2. set mysql "username: root and password: "yourPassword
3. make database :  "your_dbNAME"
4. Now goto .env in root directory and change database credentials to what you set in steps 2 & 3.

# Laravel Project Setup (laravel: 5.6.*)
---
1. Install Composer using `sudo apt install composer`
2. Run in shell `cd ProjectDirectory`
3. Run Command `composer install`
    this wiil install all dependencies for projects 
4. Run Command `php artisan migrate`
5. Run Command `php artisan serve`


## References:

- For more reference follow this https://laravel.com/docs/4.2/quick
- https://www.howtoforge.com/tutorial/install-laravel-on-ubuntu-for-apache/
- https://unowp.com/install-laravel-php-framework-on-ubuntu-18-04-lts/