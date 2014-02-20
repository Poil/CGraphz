CGraphz - Collectd GraphZ
=============
Demo
-------
* daUrl : http://web.quakelive.fr/CGraphz
* Login/Pass : admin/pass
* Database is reseted once per hour

Installation on Ubuntu
-------

Apache MysqL PHP
-----
> aptitude install mysql-server mysql-client php5 libapache2-mod-php5 php5-mysql

Clone Git
-----
> cd /var/www/

> wget https://github.com/Poil/CGraphz/archive/v2.20alpha1.tar.gz

Or

> git clone http://github.com/Poil/CGraphz.git

=======

Post Installation
-----
* MySQL : 

> mysql -u root -p -e "source /var/www/CGraphz/sql/initial_cgraphz_2.10.sql; source /var/www/CGraphz/sql/upgrade_from_2.10_to_2_20.sql;"

* Configuration
 * Edit /var/www/CGraphz/config/config.php.tpl
 * Move /var/www/CGraphz/config/config.php.tpl to /var/www/CGraphz/config/config.php
 * Edit /var/www/CGraphz/config/databases.ini.php.tpl
 * Move /var/www/CGraphz/config/databases.ini.php.tpl to /var/www/CGraphz/config/databases.ini.php

> mv /var/www/CGraphz/config/config.php.tpl /var/www/CGraphz/config/config.php

> mv /var/www/CGraphz/config/databases.ini.php.tpl /var/www/CGraphz/config/databases.ini.php


* Better file permissions to root / apache

> chown -R root.www-data /var/www/CGraphz/

> find /var/www/CGraphz/ -type d -print0 | xargs -0 -r chmod 2750

> find /var/www/CGraphz/ -type f -print0 | xargs -0 -r chmod 640

* Create LOGS dir must be apache writable :

> mkdir -p /var/www/CGraphz/logs

> chmod 2770 /var/www/CGraphz/logs

Add your first server
-------
1. Open your webbrowser and goto http://localhost/CGraphz
 * Login : admin
 * Password : pass

1. Goto Administration / Serveurs
 * Add servers, you can enter a description
1. Goto Administration / Projets
 * Click on the project "test"
 * Put some servers in this project
 * Add the admin group to the permissions tab
1. You can now go on dashboard and view your RRDs

