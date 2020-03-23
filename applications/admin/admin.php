<?php

/**
 * @author Harish Kumar
 * @copyright Flowkl
 * @link https://www.flowkl.com
 * @version 1.0
 * This file is for administration purpose
 * It performs task => update theme, update widgets, handle menues, handle users
 */

require_once('includes/Application.php');
require_once('includes/TemplateFunctions.php');

class AdminApplication extends Application
{

  /**
   * login is required for accessing admin
   * NOTE: in production also restrict only for admin 
   */
  function __construct()
  {
    $this->login_required();
    // uncomment this line for admin required
    // $this->admin_required();
  }

  /**
   * restrict only for admin
   */
  private function admin_required()
  {
    if ($_SESSION['user_session']['role'] !== 'admin') {
      $_SESSION['error'] = 'Only admin can access this page.';
      $this->redirect($this->to_url('home'));
    }
  }

  /**
   * default display function for admin
   */
  function display()
  {
    $this->index();
  }

  /**
   * view admin dashboard
   */
  function index()
  {
    require_once(TEMPLATE_PATH . '/admin/index.php');
  }

  /**
   * show the list of all themes
   */
  function theme_list()
  {
    $themes = scandir('templates');
    require_once(TEMPLATE_PATH . '/admin/themes.php');
  }

  /**
   * check if user is admin
   * @return string $theme
   */
  private function theme_validator()
  {
    // this if statement is only because admin_required is not called in constructor
    // only for demo purpose
    if ($_SESSION['user_session']['role'] !== 'admin') {
      $_SESSION['error'] = 'Only admin can change the theme. You can use live preview';
      $this->redirect($this->to_url('theme-settings'));
    }

    if (!isset($_GET['theme']) || empty($_GET['theme'])) {
      require TEMPLATE_PATH . '/400.php';
      http_response_code(400);
      exit;
    }

    $theme = $_GET['theme'];
    $dir = 'templates/' . $theme;
    if (!is_dir($dir)) {
      require TEMPLATE_PATH . '/400.php';
      http_response_code(400);
      exit;
    }

    return $theme;
  }

  /**
   * activate a new theme
   */
  function theme_activate()
  {

    $theme = $this->theme_validator();
    $db = $this->get_dbo();
    $sql = "UPDATE `site_option` SET `option_value` = ? WHERE  option_name = 'theme'";
    if ($db->prepare($sql, array($theme))->rowCount()) {
      $_SESSION['success'] = 'theme is updated';
      $this->redirect($this->to_url('theme-settings'));
    }
    $_SESSION['error'] = 'theme could not be updated';
    $this->redirect($this->to_url('theme-settings'));
  }

  /**
   * live preview of theme
   */
  function preview()
  {
    if (!isset($_GET['theme']) || empty($_GET['theme']) || !isset($_GET['url'])) {
      require TEMPLATE_PATH . '/400.php';
      http_response_code(400);
      exit;
    }

    $theme = $_GET['theme'];
    $url = $_GET['url'];
    $this->redirect($url . '?preview=true&theme=' . $theme);
  }

  /**
   * display list of all users
   */
  function admin_user_list()
  {
    $db = $this->get_dbo();
    $sql = "SELECT * FROM `users`";
    $users = $db->load_result($sql, array());
    if ($users) {
      include(TEMPLATE_PATH . 'admin/users_list.php');
    } else {
      $_SESSION['error'] = 'database connection error';
      $this->redirect($this->to_url('admin-home'));
    }
  }

  /**
   * send edit user form
   * only admin restrict function
   */
  function admin_edit_user($args)
  {
    $this->admin_required();
    $id = $args['id'];
    $db = $this->get_dbo();
    $sql = "SELECT * FROM `users` WHERE id= ?";
    $user = $db->load_single_result($sql, array($id));
    if ($user) {
      include(TEMPLATE_PATH . 'admin/user_edit.php');
    } else {
      $_SESSION['error'] = 'database connection error';
      $this->redirect($this->to_url('admin-home'));
    }
  }

  /** 
   * if password is updated by admin
   */
  private function handle_password($id, $password1, $password2)
  {
    if ($password2 != $password1) {
      $_SESSION['error'] = 'passwords do not match';
      $this->redirect($this->to_url('admin-edit-user', ['id' => $id]));
    }

    $password = crypt($password1, sprintf('$6$rounds=%d$%s$', 10000, SECRET));
    return $password;
  }

  /**
   * update an user
   */
  function admin_update_user($args)
  {
    $this->admin_required();
    $id = $args['id'];

    if (!isset($_POST['email']) || !isset($_POST['role'])) {
      $_SESSION['error'] = 'fill required fields';
      $this->redirect($this->to_url('admin-edit-user', ['id' => $id]));
    }

    $email = $_POST['email'];
    if (!isset($_POST['is_active']))
      $is_active = 1;
    else
      $is_active = 0;

    $role = $_POST['role'];
    $password = null;

    if (isset($_POST['password1']) || isset($_POST['password2'])) {
      $password = $this->handle_password($id, $_POST['password1'], $_POST['password2']);
    }

    if ($password) {
      $sql = "UPDATE `users` as user SET user.email=?,user.role=?,user.is_active=?,user.password=? WHERE user.id= ?";
      $parms = [$email, $role, $is_active, $password, $id];
    } else {
      $sql = "UPDATE `users` as user SET user.email=?,user.role=?,user.is_active=? WHERE user.id= ?";
      $parms = [$email, $role, $is_active, $id];
    }

    $db = $this->get_dbo();
    $query = $db->prepare($sql, $parms);
    if ($query) {
      $_SESSION['success'] = 'User updated';
      $this->redirect($this->to_url('admin-edit-user', ['id' => $id]));
    } else {
      $_SESSION['error'] = 'database connection error';
      $this->redirect($this->to_url('admin-edit-user', ['id' => $id]));
    }
  }

  /**
   * delete an user
   */
  function admin_delete_user($args)
  {
    $this->admin_required();
    $id = $args['id'];
    $parms = [$id];

    $db = $this->get_dbo();
    $sql = "DELETE FROM `users` WHERE id=?";
    $query = $db->prepare($sql, $parms);
    if ($query->rowCount !== 0) {
      $_SESSION['success'] = 'User deleted successfully';
      $this->redirect($this->to_url('admin-user-list', ['id' => $id]));
    } else {
      $_SESSION['error'] = 'Database connection error';
      $this->redirect($this->to_url('admin-user-list', ['id' => $id]));
    }
  }
}
