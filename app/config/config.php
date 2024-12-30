<?php
// DB Params
//Localhost Example
//define('DB_HOST', 'localhost'); 
//define('DB_USER', 'root'); 
//define('DB_PASS', ''); 
//define('DB_NAME', '18v5');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'canebricks');

define('SENDGRID_API_KEY', 'APIKEY');

//app root 
define('APPROOT', dirname(dirname(__FILE__)));
//url root
//localhost example
define('URLROOT', 'http://localhost/canebricks/');
//Redirect error message
define('RE_ERROR', 'If you are seeing this message, you probably have redirects blcocked. <a href="' . URLROOT . '">Home Page.</a>');
//site name
define('SITENAME', 'SITE_NAME');
//app version 
define('APP_VERSION', '1.6.0');
ini_set('display_errors', 1);
date_default_timezone_set("America/Toronto");
