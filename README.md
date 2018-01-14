ZendSkeletonApplication
=======================

Introduction
------------
This is a simple, skeleton application using the ZF2 with Album, Divisison, Giftcard modules

Installation
------------

composer install

### Start server

    php -S 0.0.0.0:8080 -t public/ public/index.php

**Note: ** The built-in CLI server is *for development only*.

### Apache Setup

gedit /etc/httpd/conf/httpd.conf

  
    <VirtualHost *:80>
        ServerName skeleton.test
        DocumentRoot /var/www/html/skeleton/public
        <Directory /var/www/html/skeleton/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
           
        </Directory>
    </VirtualHost>
    
##### Set Hosts    
gedit /etc/hosts

    127.0.0.1 skeleton.test
    
##Install php default server symphony

    CREATE TABLE `album_imag` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `album_id` varchar(100) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
     );