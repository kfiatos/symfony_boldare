<h3>Simple application for benchmarking of loading time one website compared agains multiple others websites<h3>
Based on Symfony 4.1 and using CURL library as testing means <br>

Properly configured app will send email notification if tested site is slower than any other competitor or an email and SMS if given site is twice as slow as any of the competitors.
Test results are also stored in log.txt file, located in this application folder `var\log`

No special requirements, different than regular Symfony 4.1 application. Just PHP 7.1 and Mysql database.

Standard installation requires:
+ clone repo:  <br>
+ copy `.env.dist` to `.env`  and update credentials to proper ones for Your setup
```git clone https://github.com/kfiatos/symfony_boldare.git```
+ do `composer install`
+ create database `bin/console doctrine:database:create`
+ update schema `bin/console doctrine:schema:update --force`

After that you're ready to go.
Navigate to address setup for this application and have fun.

Langing page form has 3 input fields
+ for base site to be tested
+ for competitor sites to be base site tested against (sites can be separated with `,` or `|`)
+ email address for sending notifications
All fields are required

<h3>Have fun<h3>