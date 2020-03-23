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
abstract class Widget extends Base
{
  private $widget_path = '';
  private $widget_name = '';
  private $parameters = array();

  function set_widget_path($widget_name)
  {
    $this->widget_path = 'widgets/' . $widget_name . '/';
    $this->widget_name = $widget_name;
  }

  function get_widget_path()
  {
    return $this->widget_path;
  }

  abstract function display();

  function run($widget_name = null, $params = null) // this function will be called by template function class to display widget
  {
    $this->parameters = $params;
    $this->set_widget_path($widget_name);
    $this->display();
  }
}
