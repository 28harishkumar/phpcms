<?php 
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
$security_check = 1;

//define configurations
$config = require_once('config.php');

//define root folder
define('ROOT', $config['root']);

//define database to tell index.php where to look for requested information
$database_config = $config['connection'][$config['database']];
$driver = $database_config['driver'];
define('DATABASE', ucfirst($driver).'Databse');
define('DATABASE_NAME', $database_config['database']);
define('DATABASE_USER', $database_config['username']);
define('DATABASE_PASS', $database_config['password']);
define('DATABASE_SERVER', $database_config['host']);

//register apps defined in config.php
$GLOBALS['APPS'] = $config['apps'];

//define production secret key
define('SECRET', $config['secret']);
