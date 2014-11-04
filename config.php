<?php

//SITE_ROOT contain the full path
define('SITE_ROOT', dirname(__FILE__));

//you can chenge this line according to your directory file
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/wordcounter/');




//*****************MySql DataBase Information*******************//

///** MySQL hostname */
define('SERVERNAME', 'localhost');

///** MySQL database port */
define('PORT', '3306');

///** The name of the database */
define('DBNAME', 'wordcounter');

///** MySQL database username */
define('DBUSER', 'root');

///** MySQL database password */
define('DBPASS', '');

///** MySQL database password */
define('DSN', 'mysql:host='.SERVERNAME.';dbname='.DBNAME.';');

