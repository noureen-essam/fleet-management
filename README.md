<p align="center" style="font-size: x-large"><b>Bus Booking system</b></p>

## Environment
Laravel 11
PHP 8.3.7
mysql  Ver 8.0.40


## About System

<b>Bus Booking system includes and covers:</b>
* User Authentication.
* Login, register and edit user's profile pages.
* Book Trip Page.
  * User choose start and destination stations.
  * Available routes will be listed.
  * By choosing route available bus trips with start time will be listed.
  * By choosing Bus Trip available bus Seats will be listed.
  * User should press Book Trip button to book selected bus trip.
  * After booking the trip successfully the system will redirect the user to dashboard page.


## In order to start the system

Pre-request
* install PHP 8.3.7
* install mysql  Ver 8.0.40

Create new database

Update .env with your database credentials: 

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=fleet_management

DB_USERNAME=root

DB_PASSWORD=your_password

Run the following command lines in the terminal in the project directory

* composer install   (install project dependencies)
* php artisan key:generate (Generate application key)
* php artisan migrate  (run database migration)
* php artisan db:seed  (run database seeder)
* php artisan serve  (run the application)

