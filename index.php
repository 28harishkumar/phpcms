<?php

if (ini_get('display_errors')) {
  ini_set('display_errors', '0');
}

$security_check = 1;

// define configurations
$config = require_once('config.php');

// define root folder
define('ROOT', $config['root']);

// define database
$database_config = $config['connection'][$config['database']];
$driver = $database_config['driver'];
define('DATABASE', ucfirst($driver) . 'Database');
define('DATABASE_NAME', $database_config['database']);
define('DATABASE_USER', $database_config['username']);
define('DATABASE_PASS', $database_config['password']);
define('DATABASE_SERVER', $database_config['host']);

// register apps
$GLOBALS['APPS'] = $config['apps'];

// define production secret key
define('SECRET', $config['secret']);

session_start();

if (isset($_SESSION['CSRF']) !== true) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < 32; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  $_SESSION['CSRF'] = hash('sha512', time() . '' . $randomString);
}

define('CSRF', $_SESSION['CSRF']);

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  if (!isset($_REQUEST['csrf_token']) || $_REQUEST['csrf_token'] !== $_SESSION['CSRF']) {
    header('HTTP/1.1 403 Forbidden');
    exit;
  }
}
// include template
require_once('includes/TemplateFunctions.php');
$tmpl = new TemplateFunctions();

define('TEMPLATE_PATH', $tmpl->get_current_template_path());
define('STATIC_PATH', $tmpl->get_static_path());
define('THEME', $tmpl->get_current_theme());

$tmpl->run();
