<?php
/**
 * @author Harish Kumar
 * @copyright Find All Together
 * @link http://www.findalltogeher.com
 * @version 1.0
 * This file is for administration purpose
 * It performs task => update theme, update widgets, handle menues, handle users
 */

require_once('includes/Application.php');
require_once('includes/TemplateFunctions.php');

class AdminApplication extends Application{

	/**
	 * login is required for accessing admin
	 * NOTE: in production also restrict only for admin 
	 */
	function __construct()
	{
		$this->login_required();
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
		
	}

	/**
	 * show the list of all themes
	 */
	function theme_list()
	{
		$themes = scandir('templates');
		require_once(TEMPLATE_PATH.'/admin/themes.php');
	}

	/**
	 * check if user is admin
	 * @return string $theme
	 */
	private function theme_validator()
	{
		if($_SESSION['user_session']['role'] !== 'admin')
		{
			$_SESSION['error'] = 'Only admin can change the theme. You can use live preview';
			$this->redirect($this->to_url('theme-settings'));
		}

		if(!isset($_GET['theme']) || empty($_GET['theme']))
		{
			require TEMPLATE_PATH.'/400.php';
			http_response_code(400);
			exit;
		}

		$theme = $_GET['theme'];
		$dir = 'templates/'.$theme;
		if (!is_dir($dir)) {
		    require TEMPLATE_PATH.'/400.php';
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
		$db=$this->get_dbo();
		$sql="UPDATE `option` SET `option_value` = ? WHERE  option_name = 'theme'";		
		if($db->prepare($sql,array($theme))->rowCount())
		{
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
		if(!isset($_GET['theme']) || empty($_GET['theme']) || !isset($_GET['url']))
		{
			require TEMPLATE_PATH.'/400.php';
			http_response_code(400);
			exit;
		}

		$theme = $_GET['theme'];
		$url = $_GET['url'];
		$this->redirect($url.'?preview=true&theme='.$theme);
	}

	/**
	 * display list of all users
	 */
	function admin_user_list()
	{
		$db=$this->get_dbo();
		$sql="SELECT * FROM `users`";
		$users = $db->load_result($sql,array());
		if($users)
		{
			include(TEMPLATE_PATH.'admin/users_list.php');				
		}
		else{
			$_SESSION['error'] = 'database connection error';
			$this->redirect($this->to_url('admin-home'));
		}
	}
}