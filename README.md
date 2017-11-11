# Poster

Poster is a simple project for learning the silex framework. 

# Features

 - You can add/edit/remove post messages
 - You can add/edit/remove admin users
 - Shows post messages in descending order. 

# Requirements

- Composer available from your PATH 
- Bower available from your PATH 
- PHP 5.6 > 
- Apache 2.4 is recommended
- MySQL 5.6 >

# Installation

 - Go to your MySQL database and create blanc database
 - Change the .htaccess in public/ setup to dev.php or index.php for production
 - For debug: change the config inside app/config/debug.php
 - For production: change the config inside app/config/production.php
 - Run from your CLI "composer update" this will install the required vendor packages inside /vendor and /public/vendor
 - You ready! default username / password : admin/admin01