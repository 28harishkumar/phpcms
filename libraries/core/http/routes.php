<?php
/**
* This class handles the routes comming from browsers
* These routes are permalink routes
*/
class Route
{
	private $config;
	private $routes;

	/**
	 * load all routes for applications
	 */
	function load_routes()
	{
		$apps = $GLOBALS['APPS'];
		foreach ($apps as $app) {
			foreach (require('applications/'.$app.'/routes.php') as $regex => $control) {
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
		$trimed = trim($_SERVER['REQUEST_URI'],'/');
		$url = split('/',$trimed);

		$number_of_folders = count(split('/', ROOT))-3;
		for ($i=0; $i < $number_of_folders; $i++) { 
			array_shift($url);
		}			

		$url = join("/",$url);
		return $url;
	}

	/**
	 * filter parameters from url's regex
	 * @param string $regex
	 * @return array (string $regex) (array parameters)
	 */
	private function filter_regex($regex)
	{
		// untill there is a dynamic parameter in url
		$args = array();
		$arg_pos = array();
		$regex_array = split('/',$regex);
		
		foreach ($regex_array as $pos => $r) 
		{
			if (strpos($r,'{') !== false) 
			{
		    	$perm = substr($r,strpos($r,'{')+1,strpos($r,'}')-strpos($r,'{')-1);
		    	array_push($args, $perm);
		    	array_push($arg_pos, $pos);
		    	$regex_array[$pos] = str_replace( '{'.$perm.'}', '', $r );
		    }
		}
		$regex = join('/',$regex_array);
		return ['regex' =>$regex, 'args' => $args, 'arg_pos' => $arg_pos];
	}

	/**
	 * match current url with registered url regexes
	 */
	private function check_regex()
	{
		$url = $this->get_url();
		foreach ($this->routes as $regex => $url_meta) {
			
			// filter the regex string
			$filtered_regex = $this->filter_regex($regex);

			// matich regex
			if(preg_match('#^'.$filtered_regex['regex'].'$#',$url, $matches, PREG_OFFSET_CAPTURE))
			{
				$args = array();
				if(!empty($filtered_regex['args']))
				{
					$url_split = split('/', $url);
					$pos = 0;
					foreach ($filtered_regex['args'] as $arg) {
						$args[$arg] = $url_split[$filtered_regex['arg_pos'][$pos++]];
					}
				}
				if(is_array($url_meta))
					$control = $url_meta['control'];
				else
					$control = $url_meta;
				return ['control' => $control,'args' => $args];
			}
		}
		return false;
	}

	function get_destination()
	{
		$destination = $this->check_regex();
		if($destination!==false)
		{
			return $destination;
		}

	}

	/**
	 * map values to parameters in url regex
	 */
	private function map_url($regex, $args)
	{
		$regex_array = split('/', $regex);
		foreach ($args as $k => $v) {
			$pos=0;
			foreach ($regex_array as $r) {		
				if(strpos($r, '{'.$k.'}') !== false)
				{
					$regex_array[$pos] = $v;
				}
				$pos++;
			}
		}
		return join($regex_array,'/');
	}

	/**
	 * return a named url
	 */
	public function to_route($name,$args = null)
	{
		foreach ($this->routes as $regex => $meta) 
		{
			if(is_array($meta))
			{
				if($name === $meta['name'])
				{
					if($args!==null)
						return ROOT.'/'.$this->map_url($regex, $args);
					else
						return ROOT.'/'.$regex;
				}
			}
		}
	}
}