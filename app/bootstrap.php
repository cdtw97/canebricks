<?php
//load config file
require_once('config/config.php');
//load helpers
require_once('helpers/helpers.php');


require(dirname(__DIR__, 1) . '/vendor/autoload.php');





//Auto load core Libraries
spl_autoload_register(function ($className) {
    require_once 'core/' . $className . '.php';
});
