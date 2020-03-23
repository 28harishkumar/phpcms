<?php

/**
 * @author Harish Kumar
 * @copyright Flowkl
 * @link https://www.flowkl.com
 * @version 1.0
 * This class handles the routes comming from browsers
 * These routes are permalink routes
 */

// security check
if (!isset($security_check)) {
  echo "This is restricted file";
  exit();
}

class Route
{
  private $routes;

  /**
   * load all routes for applications
   */
  function load_routes()
  {
    $apps = $GLOBALS['APPS'];
    foreach ($apps as $app) {
      foreach (require('applications/' . $app . '/routes.php') as $regex => $control) {
        $this->routes[$regex] = $control;
      }
    }
  }

  /**
   * get requested url
   * @return string $url
   */
  private function get_url()
  {
    $trimed = trim(explode('\?', $_SERVER['REQUEST_URI'])[0], '/');
    $url = explode('/', $trimed);

    $number_of_folders = count(explode('/', ROOT)) - 3;
    for ($i = 0; $i < $number_of_folders; $i++) {
      array_shift($url);
    }

    $url = join("/", $url);
    return $url;
  }

  /**
   * filter parameters from url's regex
   * @param string $regex
   * @return array (string $regex) (array $args) (array $arg_pos)
   */
  private function filter_regex($regex)
  {
    $args = array();
    $arg_pos = array();
    $regex_array = explode('/', $regex);

    foreach ($regex_array as $pos => $r) {
      // if there is a dynamic parameter in url
      if (strpos($r, '{') !== false) {
        $perm = substr($r, strpos($r, '{') + 1, strpos($r, '}') - strpos($r, '{') - 1);
        array_push($args, $perm);
        array_push($arg_pos, $pos);
        $regex_array[$pos] = str_replace('{' . $perm . '}', '', $r);
      }
    }
    $regex = join('/', $regex_array);
    return ['regex' => $regex, 'args' => $args, 'arg_pos' => $arg_pos];
  }

  /**
   * match current url with registered url regexes
   */
  private function check_regex()
  {
    $url = $this->get_url();
    foreach ($this->routes as $route => $url_meta) {
      // filter the regex string
      $filtered_regex = $this->filter_regex($route);
      $url_location = explode('?', $url)[0];

      // matich regex
      preg_match('#^' . $filtered_regex['regex'] . '$#', $url_location, $matches, PREG_OFFSET_CAPTURE);
      if (!empty($matches)) {
        if (is_array($url_meta)) {
          $control = $url_meta['control'];
          if (array_search($_SERVER['REQUEST_METHOD'], $url_meta['allow']) === false) {
            return false;
          }
        } else {
          $control = $url_meta;
        }

        $args = array();
        if (!empty($filtered_regex['args'])) {
          $url_split = explode('/', $url);
          $pos = 0;
          foreach ($filtered_regex['args'] as $arg) {
            $args[$arg] = $url_split[$filtered_regex['arg_pos'][$pos++]];
          }
        }

        return ['control' => $control, 'args' => $args];
      }
    }
    return false;
  }

  /**
   * find right app class and its funciton
   * @return array $destination
   */
  function get_destination()
  {
    $destination = $this->check_regex();
    if ($destination !== false) {
      return $destination;
    }
    header('HTTP/1.1 404 Page not found');
    exit;
  }

  /**
   * map values to parameters in url regex
   */
  private function map_url($regex, $args)
  {
    $regex_array = explode('/', $regex);
    foreach ($args as $k => $v) {
      $pos = 0;
      foreach ($regex_array as $r) {
        if (strpos($r, '{' . $k . '}') !== false) {
          $regex_array[$pos] = $v;
        }
        $pos++;
      }
    }
    return join($regex_array, '/');
  }

  /**
   * return a named url
   * @return string url
   */
  public function to_route($name, $args = null)
  {
    foreach ($this->routes as $regex => $meta) {
      if (is_array($meta)) {
        if ($name === $meta['name']) {
          if ($args !== null) {
            return ROOT . '/' . $this->map_url($regex, $args);
          } else {
            return ROOT . '/' . $regex;
          }
        }
      }
    }
  }
}
