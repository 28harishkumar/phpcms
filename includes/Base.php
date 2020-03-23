<?php

/**
 * @author Harish Kumar
 * @copyright Flowkl
 * @link https://www.flowkl.com
 * @version 1.0
 * THis is base file
 * Anything here will be accessible to all of the CMS. 
 * Make sure everything here should be static and be using singlton design pattern
 */
if (!isset($security_check)) {
  echo "This is restricted directory";
  exit();
}

require_once('libraries/core/database/' . $driver . '_database.php');
require_once('libraries/core/http/routes.php');
abstract class Base
{

  /**
   * create a instance of database class
   * Open a database commenction
   * @return instance $db_object MysqlDatabase
   */
  protected function get_dbo()
  {
    static $db_object = null;
    if (null === $db_object) {
      $db = DATABASE;
      $db_object = new $db();
    }
    return $db_object;
  }

  /**
   * chcek if user is logged in
   * @return boolean
   */
  protected function is_login()
  {
    if (isset($_SESSION['user_session'])) {
      return true;
    }
    return false;
  }

  /**
   * get an instance of Route class
   * load all routes
   * @return instance $route Routes()
   */
  protected function get_routes()
  {
    static $routes = null;
    if (null === $routes) {
      $routes = new Route();
      $routes->load_routes();
    }
    return $routes;
  }

  /**
   * it is used for named urls
   * @param string $name
   * @param array $args
   * @return string url
   */
  protected function to_url($name, $args = null)
  {
    $r = $this->get_routes();
    if ($args !== null)
      return $r->to_route($name, $args);
    else
      return $r->to_route($name);
  }

  /**
   * abatract function run for executing applicaiton
   */
  abstract function run($arg = null, $param = null);
}
