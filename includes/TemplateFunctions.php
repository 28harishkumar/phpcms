<?php

/**
 * @author Harish Kumar
 * @copyright Flowkl
 * @link https://www.flowkl.com
 * @version 1.0
 * This is base template controller file. 
 * The purpose of this file is to provide php functions to the template files
 * This file contains helpers for template files.
 * All CMS template management related functions will be here.
 */

require_once('Base.php');
class TemplateFunctions extends Base
{
  // default theme
  private $template_name = null;
  // hook for widgets
  private $widget_positions = array();

  /**
   * initialize template
   */
  function __construct()
  {
    if ($this->template_name == null) {
      $this->template_name = $this->get_current_template();
    }
  }

  /**
   * run whole CMS and render generated html page
   */
  function run($arg = null, $param = null)
  {
    require_once(TEMPLATE_PATH . 'functions.php');
    require_once(TEMPLATE_PATH . 'index.php');
  }

  /**
   * set a template
   */
  function set_template($template_name)
  {
    $this->template_name = $template_name;
  }

  /**
   * get currently active template
   */
  private function get_current_template()
  {
    if (isset($_GET['preview']) && isset($_GET['theme']) && $_SESSION['user_session']['role'] !== 'user') {
      define('PREVIEW', true);
      return $_GET['theme'];
    }

    $db = $this->get_dbo();
    $sql = "SELECT `option_value` FROM `site_option` WHERE option_name = ?";
    $template_name = $db->load_single_result($sql, array('theme'));

    if ($template_name) {
      return $template_name['option_value'];
    }

    return 'default';
  }

  /**
   * return current theme name
   * @return string $this->template_name
   */
  function get_current_theme()
  {
    return $this->template_name;
  }

  /**
   * return currently active template path
   * it is relative path to root index.php
   * @return string template_path
   */
  function get_current_template_path()
  {
    return 'templates/' . $this->template_name . '/';
  }

  /**
   * return static media path in template path
   * it is absolute path
   * @return string template_path
   */
  function get_static_path()
  {
    return ROOT . '/' . TEMPLATE_PATH;
  }

  /**
   * action for app output
   * resoulve app name and requested function from url
   * then run application class for generating output
   */
  function app_output()
  {
    // Route class instance
    $routes = $this->get_routes();
    // fetch app and function name
    $destination = $routes->get_destination();

    $app_name = explode('@', $destination['control']);

    require_once('applications/' . $app_name[0] . '/' . $app_name[0] . '.php');
    $application = ucfirst($app_name[0]) . 'Application';
    $app = new $application();
    $app->run($app_name[1], $destination['args']);
  }

  /**
   * take output from widget
   */
  function widget_output($position = 'default')
  {
    if (!empty($this->widget_positions[$position])) {
      //gets all widgets in given 
      $widgets = $this->widget_positions[$position];

      //display each widget
      foreach ($widgets as $widget_object) {
        $widget_name = $widget_object->name;
        $widget_parameters = $widget_object->parameters;
        require_once('widgets/' . $widget_name . '/' . $widget_name . '.php');
        $widget_class = ucfirst($widget_name) . 'Widget';
        $widget = new $widget_class();
        $widget->run($widget_name, $widget_parameters);
      }
    }
  }

  /**
   * regiseter widgets for theme
   */
  function set_widget($position, $widget_name, $params = array())
  {
    $widget = new StdClass;
    $widget->name = $widget_name;
    $widget->parameters = $params;
    //if there is no widget in position then create a new array
    if (empty($this->widget_positions[$position])) {
      $this->widget_positions[$position] = array($widget);
    }
    //if there is already a widget present in that position then just push new widget in array
    else {
      array_push($this->widget_positions[$position], $widget);
    }
  }

  /**
   * return header.php file from current template
   */
  function get_header()
  {
    require_once(TEMPLATE_PATH . 'header.php');
  }

  /**
   * return footer.php file from current template
   */
  function get_footer()
  {
    require_once(TEMPLATE_PATH . 'footer.php');
  }

  /**
   * return sidebar.php file from current template
   */
  function get_sidebar()
  {
    require_once(TEMPLATE_PATH . 'sidebar.php');
  }
}
