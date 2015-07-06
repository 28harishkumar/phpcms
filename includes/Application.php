<?php
require_once('Base.php');
class Application extends Base{
	//here we can write as many functions as we want and those functions will be called by user directly.
	function run($method,$args)
	{
		if(!empty($args))
		{
			$this->$method($args);
		}	
		else{
			$this->$method();
		}
	}
	function display()
	{
		echo 'this is base display';
	}
	protected function redirect($url=null,$msg=null)
	{
		if(empty($url))
		{
			header('Location:'.ROOT);exit(0);
		}
		else
		{
			header('Location:'.$url);exit(0);
		}
	}
	protected function login_required()
	{
		if(!isset($_SESSION['user_session']))
		{
			$this->redirect($this->to_url('login'));
		}
	}
}
?>