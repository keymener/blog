# myblog
To install this app:
 
-put the content into the www folder of apache
-configure the webroot folder to "public"
-add rewrite rules into vhost.conf like this:
<VirtualHost *:80>
	ServerName myblog
	DocumentRoot "c:/wamp64/www/myblog/public"
	<Directory  "c:/wamp64/www/myblog/public/">
   Allow From All
		RewriteEngine On
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
	</Directory>
</VirtualHost>

-create the mysql database with 3 tables: comment, post and user ( see classes into "entity" folder to link attributes names with tables columns names)
-change the "Database.php" const into "model" folder for database configuration
-change the "email.ini" file into "config" folder to run with your own gmail account



