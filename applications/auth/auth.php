<?php

/**
 * @author Harish Kumar
 * @copyright Flowkl
 * @link https://www.flowkl.com
 * @version 1.0
 * This file is for authentication purpose
 * It performs task => login, logout, register, reset-password, send verification email
 */

require_once('includes/Application.php');

class AuthApplication extends Application
{

  /**
   * default function that will run if no operation is choosen
   */
  function display()
  {
    //check if any session exists otherwise login
    $this->check_login($this->to_url('login-form'));
  }

  /**
   * verify if any session exists
   * @param string $url
   */
  private function check_login($url = null)
  {
    if (isset($_SESSION['user_session'])) {
      $this->redirect();
    }
    if ($url !== null) {
      $this->redirect($url);
    }
  }

  /**
   * return authentication form
   */
  function login_form()
  {
    $this->check_login();
    require_once(TEMPLATE_PATH . 'auth/auth.php');
  }

  /**
   * login user
   * @param string $email
   * @param string $password
   * @return redirect
   */
  private function login($email, $password)
  {
    $db = $this->get_dbo();
    $email = $db->quote($email);
    $password = crypt($password, sprintf('$6$rounds=%d$%s$', 10000, SECRET));

    $sql = "SELECT * FROM `users` WHERE email=? AND password=? AND is_active = 1";
    $query = $db->load_single_result($sql, array($email, $password));

    if (isset($query['id'])) {
      $_SESSION['user_session'] = $query;

      if (isset($_SESSION['user_session'])) {
        $this->redirect();
      } else {
        $_SESSION['l_error'] = 'Email and password do not match';
        $this->redirect($this->to_url('login-form'));
      }
    } else {
      $_SESSION['l_error'] = 'Email and password do not match';
      $this->redirect($this->to_url('login-form'));
    }

    $this->redirect();
  }

  /**
   * take login credentials from user
   * pass credentials to login function
   */
  function login_user()
  {
    $this->check_login();
    $email = $_POST['login-email'];
    $password = $_POST['password'];
    $this->login($email, $password);
  }

  /**
   * logout the user
   */
  private function logout()
  {
    if (isset($_SESSION['user_session']) && $_SESSION['user_session']) {
      session_destroy();
    }
    $this->redirect($this->to_url('login-form'));
  }

  /**
   * logout a user
   */
  function logout_user()
  {
    $this->logout();
  }

  /**
   * returns user information
   * @param string $email
   * @return query $query
   */
  private function get_user_info($email)
  {
    $db = $this->get_dbo();
    $query = $db->load_single_result("SELECT * FROM users WHERE email = ?", array($email));
    return $query;
  }

  /**
   * send error if any exists during registeration
   * @param staring $error_code
   * @return redirect
   */
  private function error_info($error_code = null)
  {
    switch ($error_code) {
      case 'incomplete':
        $error = 'All fields are required';
        break;
      case 'passmismatch':
        $error = 'Passwords do not match';
        break;
      case 'alreadyexist':
        $error = 'Email already exists';
        break;
      case 'loginfail':
        $error = 'Email and password do not match';
        break;
      case 'min_lenght_error':
        $error = 'minimum 8 character password required';
        break;
      default:
        $error = 'Some error occurred';
        break;
    }

    $_SESSION['error'] = $error;
    $url = $this->to_url('signup-form');
    $this->redirect($url);
  }

  /**
   * register new user
   * @param string $email
   * @param string $password
   * @return int $count
   */
  private function register($email, $password)
  {
    $db = $this->get_dbo();
    $eml = $db->quote($email);
    if ($this->get_user_info($eml)) {
      $this->error_info('alreadyexist');
    }
    $password = crypt($password, sprintf('$6$rounds=%d$%s$', 10000, SECRET));
    $code = hash('sha512', 'register' . $email . '' . time());
    $created_at = new DateTime();
    $created_at = $created_at->format('Y-m-d H:i:s');
    $updated_at = new DateTime();
    $updated_at = $updated_at->format('Y-m-d H:i:s');

    $sql = "INSERT INTO `users` (email,password,confirm_code,created_at,updated_at) VALUES(?,?,?,?,?)";
    $query = $db->prepare($sql, array($eml, $password, $code, $created_at, $updated_at));
    $count = $query->rowCount();
    if ($count) {
      $this->send_register_email($email, $code);
    }
    return $count;
  }

  /**
   * prepare verification email for registering user
   * @param string $title
   * @param string $link
   * @param string $message
   * @return string(html) $body
   */
  private function email_message($title, $link, $message)
  {
    return "<html>
		<body>
			<h1>" . $title . "</h1>
			<p>Click on the link <a href=" . $link . ">" . $message . "></a></p>
			<p><a href=" . ROOT . ">Go Back to Home page</a></p>
			</br></br></br></br></br>
			<small>It is auto generated message. Don't reply for this message. Only click on the links.</small>
		</body>
		</html>";
  }

  /**
   * send email to registered user
   * config your init.php for working this function
   * @param string $email
   * @param string $code
   */
  private function send_register_email($email, $code)
  {
    $subject = "My to do email register";
    //put domain name instead of localhost
    $link = $this->to_url('verify-email', ['code' => $code, 'email' => $email]);
    $title = 'Confirm email for registeration';
    $message = 'Confirm Email';
    $txt = $this->email_message($title, $link, $message);
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // $headers .= "From: webmaster@example.com";

    mail($email, $subject, $txt, $headers);
  }

  /**
   * take registeration credentials from user
   */
  function register_user()
  {
    $this->check_login();
    $email = $_POST['email'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];
    if (!isset($email) or !isset($pass1) or !isset($pass2)) {
      $this->error_info('incomplete');
    }

    if ($pass1 !== $pass2) {
      $this->error_info('passmismatch');
    }

    if (strlen($pass1) < 8) {
      $this->error_info('min_lenght_error');
    }

    if ($this->register($email, $pass1)) {
      $message = 'You have register succesfully. Now open your email id and click on the confirmation link';
      $heading = 'Success';
      require(TEMPLATE_PATH . 'auth/message.php');
    } else {
      $this->error_info();
    }
  }

  /**
   * match the confirmation code in link for verifying registered email
   * @param array $args
   * @param string $args['code']
   * @param staring $args['email']
   */
  function verify_email($args)
  {
    $this->check_login();
    if (!isset($args['code']) or !isset($args['email'])) {
      $this->redirect();
    }

    $code = $args['code'];
    $email = $args['email'];
    $db = $this->get_dbo();
    $email = $db->quote($email);
    $data = $this->get_user_info($email);
    $query = null;
    if ($data['confirm_code'] == $code && $code != '0') {
      $updated_at = new DateTime();
      $updated_at = $updated_at->format('Y-m-d H:i:s');
      $sql = "UPDATE `users` as user SET user.is_active='1', user.confirm_code='0', user.updated_at=? WHERE user.email= ?";
      $query = $db->prepare($sql, array($updated_at, $email));
    } else {
      $this->redirect();
    }

    if ($query->rowCount()) {
      $_SESSION['user_session'] = $data;
    }
    $this->redirect();
  }

  /**
   * return reset password form
   * @return HTMLResponse
   */
  function forget_password()
  {
    $this->check_login();
    if (!isset($_POST['forget-email'])) {
      $this->redirect();
    }

    $email = $_POST['forget-email'];
    $code = hash('sha512', 'forget$kfsdgf8dsfds' . $email . '' . time());
    $db = $this->get_dbo();
    $eml = $db->quote($email);
    $updated_at = new DateTime();
    $updated_at = $updated_at->format('Y-m-d H:i:s');
    $sql = "UPDATE `users` SET confirm_code= '$code', updated_at=? WHERE email= ?";
    $query = $db->prepare($sql, array($updated_at, $eml));
    if ($query->rowCount()) {
      $this->send_reset_email($code, $email);
      $message = 'Your reset password information has been sent to your email address.';
      $heading = 'Success';
    } else {
      $message = 'You have provide invalid email address';
      $heading = 'Error';
    }
    require(TEMPLATE_PATH . 'auth/message.php');
  }

  /**
   * emails reset password link
   * @param string $code
   * @param string $email
   */
  private function send_reset_email($code, $email)
  {
    $subject = "My to do password reset";
    //put domain name instead of localhost
    $link = $this->to_url('reset-password', ['code' => $code, 'email' => $email]);
    $title = 'Reset Password';
    $message = "confirm reset Password";
    $txt = $this->email_message($title, $link, $message);
    $headers = "From: webmaster@example.com" . "\r\n" .
      "CC: somebodyelse@example.com";

    mail($email, $subject, $txt, $headers);
  }

  /**
   * send reset password form
   * @param array $args
   * @param string $args['code']
   * @param string $args['email']
   */
  function reset_password_form($args)
  {
    $this->check_login();
    if (!isset($args['code']) or !isset($args['email'])) {
      $this->redirect();
    }

    $code = $args['code'];
    $email = $args['email'];
    $db = $this->get_dbo();
    $email = $db->quote($email);
    $data = $this->get_user_info($email);

    if ($data['confirm_code'] !== $code || $code == '0') {
      $this->redirect();
    }

    require(TEMPLATE_PATH . 'auth/resetpassword.php');
  }

  /**
   * reset user password
   * @return HTMLResponse
   */
  function reset_password()
  {
    $this->check_login();
    if (!isset($_POST['i']) or !isset($_POST['e']) or !isset($_POST['pass1']) or !isset($_POST['pass2'])) {
      header('HTTP/1.1 403 Forbidden');
      $heading = 'forbidden request!';
      $message = 'all fields are required. Try again by clicking on link in email.';
      require(TEMPLATE_PATH . 'auth/message.php');
      exit();
    }

    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $email = $_POST['e'];
    $code = $_POST['i'];

    if ($pass2 !== $pass1) {
      $error = 'password mismatch';
      require(TEMPLATE_PATH . 'auth/resetpassword.php');
      exit();
    }

    $db = $this->get_dbo();
    $eml = $db->quote($email);
    $data = $this->get_user_info($eml);
    $query = null;

    if ($data['confirm_code'] == $code && $code != '0') {
      $updated_at = new DateTime();
      $updated_at = $updated_at->format('Y-m-d H:i:s');
      $sql = "UPDATE `users` as user SET user.confirm_code='0', user.updated_at=? WHERE user.email= ?";
      $query = $db->prepare($sql, array($updated_at, $eml));
    } else {
      header('HTTP/1.1 403 Forbidden');
      $heading = 'forbidden request!';
      $message = 'Validation error. Try again by clicking on link in email.';
      require(TEMPLATE_PATH . 'auth/message.php');
      exit();
    }

    if ($query and $query->rowCount()) {
      $pass1 = crypt($pass1, sprintf('$6$rounds=%d$%s$', 10000, SECRET));
      $db = $this->get_dbo();
      $eml = $db->quote($email);
      $updated_at = new DateTime();
      $updated_at = $updated_at->format('Y-m-d H:i:s');
      $sql = "UPDATE `users` SET confirm_code= '0', password = ?, updated_at=? WHERE email= ?";
      $query = $db->prepare($sql, array($pass1, $eml, $updated_at));
      if ($query->rowCount()) {
        $message = 'Your reset password has been reseted.';
        $heading = 'Success';
      } else {
        $message = 'You have provide invalid data';
        $heading = 'Error';
      }
    } else {
      $message = 'You have provide invalid data';
      $heading = 'Error';
    }
    require(TEMPLATE_PATH . 'auth/message.php');
  }
}
