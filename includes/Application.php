<?php

/**
 * @author Harish Kumar
 * @copyright Flowkl
 * @link https://www.flowkl.com
 * @version 1.0
 * This is base application file which will be extended by 
 * other applications. This provides basic interface.
 */

require_once('Base.php');
abstract class Application extends Base
{

  /**
   * executing an applicaition
   */
  function run($method = 'default', $args = null)
  {
    if (!empty($args)) {
      $this->$method($args);
    } else {
      $this->$method();
    }
  }

  /**
   * default response to user for any request
   * 
   */
  abstract function display();

  /**
   * redirect function for application
   */
  protected function redirect($url = null, $msg = null)
  {
    if (empty($url)) {
      header('Location:' . ROOT);
    } else {
      header('Location:' . $url);
    }
    exit(0);
  }

  /**
   * protect application with logged in required layer
   */
  protected function login_required()
  {
    if (!isset($_SESSION['user_session'])) {
      $this->redirect($this->to_url('login-form'));
    }
  }
}
