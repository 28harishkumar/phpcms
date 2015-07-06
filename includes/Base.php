<?php
if(!isset($security_check))
{
	echo "This is restricted directory";
	exit();
}

require_once('libraries/core/database/'.$driver.'_database.php');
require_once('libraries/core/http/routes.php');
class Base{
	//Anything here will be accessible to all of the CMS. 
	//Make sure everything here should be static and be using singlton design pattern
	public function get_dbo()
	{
		static $db_object = null;
        if (null === $db_object) {
        	$db = DATABASE;
        	$db_object = new $db();   
        }
       return $db_object;
	}
	
	protected function is_login()
	{
		session_start();
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
		return false;
	}

	public function get_routes()
	{
		static $routes = null;
        if (null === $routes) {
          $routes = new Route();
          $routes->load_routes();           
        }
       return $routes;
	}

	public function to_url($name, $args=null)
	{
		$r = $this->get_routes();
		if($args!==null)
			return $r->to_route($name,$args);
		else
			return $r->to_route($name);
	}
}
?>