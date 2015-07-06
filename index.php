<?php

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

$security_check = 1;

// define configurations
$config = require_once('config.php');

// define root folder
define('ROOT', $config['root']);

// define database
$database_config = $config['connection'][$config['database']];
$driver = $database_config['driver'];
define('DATABASE', ucfirst($driver).'Database');
define('DATABASE_NAME', $database_config['database']);
define('DATABASE_USER', $database_config['username']);
define('DATABASE_PASS', $database_config['password']);
define('DATABASE_SERVER', $database_config['host']);

// register apps
$GLOBALS['APPS'] = $config['apps'];

//encription type
define('ENCRIPTION',$config['encription']);

// define production secret key
define('SECRET', $config['secret']);

// include template
require_once('includes/TemplateFunctions.php');
$tmpl=new TemplateFunctions();
$tmpl->show();