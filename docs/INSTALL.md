WorkBook
========

Requirements
------------
- PHP 7
- MySQL 5.6
- Composer

Required extensions
-------------------
- bz2
- curl
- fileinfo
- ftp
- gd2
- gettext
- gmp
- intl
- imap
- ldap
- mbstring
- exif
- mysqli
- openssl
- pdo_mysql

Installation
------------

Copy files to your PHP web server. You must have mod_rewrite enabled.
We recomment you to use nginx server. Make sure all requirements are satisfied
and required PHP extensions are enabled.

You must run "composer self-udpate" and "composer install"/"composer update" first.
Then you must run these commands:

- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate --no-interaction

After this you can start using your application.
