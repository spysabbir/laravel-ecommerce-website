<p align="center"><a href="https://ecommerce.spysabbir.com/" target="_blank"><img src="https://ecommerce.spysabbir.com/uploads/default_photo/Logo-Photo.png"></a></p>

## About This Project

This is project is the eCommerce Website. Built with `Laravel` & various packages included.

## Setup

- First of all we have to `clone` the project at our local machine using below command
 ```
git clone https://github.com/spysabbir/laravel-ecommerce-website.git
``` 
- Now change the command line present working directory (pwd) by
 ```
cd laravel-ecommerce-website
``` 
- Now with help of `composer` download all required packages those need to run this laravel project
 ```
composer install
``` 
- Now, we need to copy the .env.example file as .env file for our laravel project. Use below command to copy the file
 ```
cp .env.example .env
``` 
- Currently our project do not have any key, we have generate it using
 ```
php artisan key:generate
``` 
- Basic setup is done at this point, now we have work on `.env`. Below changes should be done at .env file

Variable Name | Description
--- | ---
*DB | database settings for connect the database with this project
*MAIL | mail settings for send email via smtp server
*SMS | sms settings for send sms via bulksmsbd api
*SOCIAL_LOGIN | social login settings for login using social account via socialite package
*PAYMENT | payment settings for payment received via sslcommerz api

- Now migrate and seed the database using
 ```
php artisan migrate --seed
``` 

- At last, we can now run the project using
 ```
php artisan serve
``` 

- Demo login credentials 
 ```
Backend.....
For Super Admin:- 
Email: superadmin@email.com
For Admin:- 
Email: admin@email.com
For Warehouse:- 
Email: dhakawarehouse@email.com

Frontend.....
For Customer:- 
Email: customer1@email.com

All account password as same
Password: 12345678
```
