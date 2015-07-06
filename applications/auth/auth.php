<?php
/**
 * @author Harish Kumar
 * @copyright Find All Together
 * @link http://www.findalltogeher.com
 * @version 1.0
 * This file is for authentication purpose
 * It performs task => login, logout, register, reset-password, send verification email
 */

require_once('includes/Application.php');
require_once('includes/TemplateFunctions.php');

class AuthApplication extends Application{
	/**
	 * defining an instance for TemplateFunction class
	 */
	function __construct()
	{
		if(!isset($this->temp))
			$this->temp = new TemplateFunctions();
	}

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
		if(isset($_SESSION['user_session']))
		{
			$this->redirect();
		}
		if($url !== null)
		{
			$this->redirect($url);
		}
	}

	/**
	 * return authentication form
	 */
	function login_form()
	{
		$this->check_login();
		require_once($this->temp->get_current_template_path().'auth/auth.php');
	}

	/**
	 * login user
	 */
	private function login($email,$password)
	{
		$db=$this->get_dbo();
		$email = $db->quote($email);
		$password = crypt($password,sprintf('$6$rounds=%d$%s$',10000,SECRET));

		$sql = "SELECT * FROM users WHERE email=? AND password=? AND is_active = 1";
		$query = $db->load_single_result($sql,array($email,$password));

		if(isset($query['id']))
		{
			session_start();
			$_SESSION['user_session'] = $query;
			if(isset($_SESSION['user_session']))
			{
				$this->redirect();
			}
			else{
				$_SESSION['l_error'] = 'Email and password do not match';
				$this->redirect($this->to_url('login-form'));			
			}
		}
		else
		{
			$_SESSION['l_error'] = 'Email and password do not match';
			$this->redirect($this->to_url('login-form'));
		}
		$this->redirect($url);
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
		$this->login($email,$password);
	}

	/**
	 * logout the user
	 */
	private function logout()
	{
		session_start();
		if(isset($_SESSION['user_session']) && $_SESSION['user_session'])
		{
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
	 */
	private function get_user_info($email)
	{
		$db=$this->get_dbo();
		$query = $db->load_single_result("SELECT * FROM users WHERE email = ?",array($email));
		return $query;
	}

	/**
	 * send error if any exists during registeration
	 */
	private function error_info($error_code = null){
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
				$error ='minimum 8 character password required';
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
	 */
	private function register($email,$password)
	{
		$db=$this->get_dbo();
		$eml = $db->quote($email);
		if($this->get_user_info($eml))
		{
			$this->error_info('alreadyexist');
		}
		$password = crypt($password,sprintf('$6$rounds=%d$%s$',10000,SECRET));
		$code = hash('sha512', 'register'.$email.''.time());

		$sql = "INSERT INTO users (email,password,confirm_code) VALUES(?,?,?)";
		$query = $db->prepare($sql,array($eml,$password,$code));
		$count = $query->rowCount();
		if($count)
		{
			$this->send_register_email($email,$code);
		}
		return $count;
	}

	/**
	 * prepare verification email for registering user
	 */
	private function email_message($title,$link,$message)
	{
		$body="<html>
		<body>
			<h1>".$title."</h1>
			<p>Click on the link <a href=".$link.">".$message."></a></p>
			<p><a href=".ROOT.">Go Back to Home page</a></p>
			</br></br></br></br></br>
			<small>It is auto generated message. Don't reply for this message. Only click on the links.</small>
		</body>
		</html>";
		return $body;
	}

	/**
	 * send email to registered user
	 * config your init.php for working this function
	 */
	private function send_register_email($email,$code)
	{
		$subject = "My to do email register";
		//put domain name instead of localhost
		$link = $this->to_url('verify-email',[ 'code' => $code, 'email' => $email]);
		$title = 'Confirm email for registeration';
		$message = 'Confirm Email';
		$txt = $this->email_message($title,$link,$message);
		$headers = "From: webmaster@example.com" . "\r\n" .
		"CC: somebodyelse@example.com";

		mail($email,$subject,$txt,$headers);
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
		if(!isset($email) or !isset($pass1) or !isset($pass2))
		{
			$this->error_info('incomplete');
		}
		
		if($pass1 !== $pass2)
		{
			$this->error_info('passmismatch');
		}

		if(strlen($pass1) < 8)
		{
			$this->error_info('min_lenght_error');
		}

		if($this->register($email,$pass1))
		{
			$message = 'You have register succesfully. Now open your email id and click on the confirmation link';
			$heading = 'Success';		
			require($this->temp->get_current_template_path().'auth/message.php');
		}
		else
		{
			$this->error_info();
		}
	}

	/**
	 * match the confirmation code in link for verifying registered email
	 */ 
	function verify_email($args)
	{
		$this->check_login();
		if(!isset($args['code']) or !isset($args['email']))
		{
			$this->redirect();
		}

		$code = $args['code'];
		$email = $args['email'];
		$db=$this->get_dbo();
		$email = $db->quote($email);
		$data = $this->get_user_info($email);
		$query = null;
		if($data['confirm_code']==$code && $code != '0')
		{
			$sql = "UPDATE users as user SET user.is_active='1', user.confirm_code='0' WHERE user.email= ?";
			$query = $db->prepare($sql,array($email));
		}
		else
		{
			$this->redirect();
		}

		if($query->rowCount())
		{
			session_start();
			$_SESSION['user_session'] = $data;
		}
		$this->redirect();
	}

	/**
	 * return reset password form
	 */
	function forget_password()
	{
		$this->check_login();
		if(!isset($_POST['forget-email']))
		{
			$redirect();
		}

		$email = $_POST['forget-email'];
		$code = hash('sha512','forget$kfsdgf8dsfds'.$email.''.time());
		$db=$this->get_dbo();
		$eml = $db->quote($email);
		$sql = "UPDATE users SET confirm_code= '$code' WHERE email= ?";
		$query = $db->prepare($sql,array($eml));
		if($query->rowCount())
		{
			$this->send_reset_email($code,$email);
			$message = 'Your reset password information has been sent to your email address.';
			$heading = 'Success';		
		}
		else
		{
			$message = 'You have provide invalid email address';
			$heading = 'Error';
		}
		require($this->temp->get_current_template_path().'auth/message.php');
	}

	/**
	 * emails reset password link
	 */
	private function send_reset_email($code,$email)
	{
		$subject = "My to do password reset";
		//put domain name instead of localhost
		$link = $this->to_url('reset-password',['code' =>$code, 'email' => $email]);
		$title = 'Reset Password';
		$message = "confirm reset Password";
		$txt = $this->email_message($title,$link,$message);
		$headers = "From: webmaster@example.com" . "\r\n" .
		"CC: somebodyelse@example.com";

		mail($email,$subject,$txt,$headers);
	}

	/**
	 * send reset password form
	 */
	function reset_password_form($args)
	{
		$this->check_login();
		if(!isset($args['code']) or !isset($args['email']))
		{
			$this->redirect();
		}

		$code = $args['code'];
		$email = $args['email'];
		$db=$this->get_dbo();
		$email = $db->quote($email);
		$data = $this->get_user_info($email);
		
		if($data['confirm_code']!==$code || $code == '0')
		{
			$this->redirect();
		}

		require($this->temp->get_current_template_path().'auth/resetpassword.php');
	}

	/**
	 * reset user password
	 */
	function reset_password()
	{
		$this->check_login();
		if(!isset($_POST['i']) or !isset($_POST['e']) or !isset($_POST['pass1']) or !isset($_POST['pass2']))
		{
			header('HTTP/1.1 403 Forbidden');
			$heading = 'forbidden request!';
			$message = 'all fields are required. Try again by clicking on link in email.';
			require($this->temp->get_current_template_path().'auth/message.php');
			exit();
		}

		$pass1 = $_POST['pass1'];
		$pass2 = $_POST['pass2'];
		$email = $_POST['e'];
		$code = $_POST['i'];
			
		if($pass2 !== $pass1)
		{
			$error = 'password mismatch';
			require($this->temp->get_current_template_path().'auth/resetpassword.php');
			exit();
		}

		$db=$this->get_dbo();
		$eml = $db->quote($email);
		$data = $this->get_user_info($eml);
		$query = null;

		if($data['confirm_code']==$code && $code != '0')
		{
			$sql = "UPDATE users as user SET user.confirm_code='0' WHERE user.email= ?";
			$query = $db->prepare($sql,array($eml));
		}
		else
		{
			header('HTTP/1.1 403 Forbidden');
			$heading = 'forbidden request!';
			$message = 'Validation error. Try again by clicking on link in email.';
			require($this->temp->get_current_template_path().'auth/message.php');
			exit();
		}

		if($query and $query->rowCount())
		{
			$pass1 = crypt($pass1,sprintf('$6$rounds=%d$%s$',10000,SECRET));
			$db=$this->get_dbo();
			$eml = $db->quote($email);
			$sql = "UPDATE users SET confirm_code= '0', password = ? WHERE email= ?";
			$query = $db->prepare($sql,array($pass1,$eml));
			if($query->rowCount())
			{
				$message = 'Your reset password has been reseted.';
				$heading = 'Success';		
			}
			else
			{
				$message = 'You have provide invalid data';
				$heading = 'Error';
			}
		}
		else
		{
			$message = 'You have provide invalid data';
			$heading = 'Error';
		}
		require($this->temp->get_current_template_path().'auth/message.php');
	}
}
?>