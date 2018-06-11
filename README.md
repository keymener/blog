## Synopsis

This is my first personnal php website including a simple blog, posts and comments administration.
I've used mvc and pattern.

## Libraries

Composer autoloader.
PHP-DI for dependency injection container.
Twig for views.

## Installation

Put the content into the www folder of apache.

Configure your webserver to point to the webroot folder "public".

Add apache rewrite rules like this:

		RewriteEngine On
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]


Create the mysql database with 3 tables: comment, post and user ( see classes into "entity" folder to link attributes names with tables columns names).

Change the "Database.php" const into "model" folder for database configuration.

Change the "email.ini" file into "config" folder to run with your own gmail account.



