<?php
require_once('Base.php');
class TemplateFunctions extends Base{
	//All CMS template management related functions will be here.
	private $template_name='default';
	private $widget_positions=array();
	function get_header()
	{
		require_once($this->get_current_template_path().'header.php');
	}

	function get_footer()
	{
		require_once($this->get_current_template_path().'footer.php');
	}

	function show()
	{
		require_once($this->get_current_template_path().'functions.php');
		require_once($this->get_current_template_path().'index.php');
	}

	function get_current_template_path()
	{
		return 'templates/'.$this->template_name.'/';
	}

	function get_static_path()
	{
		return ROOT.'/'.$this->get_current_template_path();
	}
	
	function app_output()
	{
		// Route class instance
		$routes = $this->get_routes();
		// fetch app and function name
		$destination = $routes->get_destination();

		$app_name = split('@',$destination['control']);

		require_once('applications/'.$app_name[0].'/'.$app_name[0].'.php');
		$application=ucfirst($app_name[0]).'Application';
		$app=new $application();
		$app->run($app_name[1],$destination['args']);
	}

	function set_template($templateName)
	{
		$this->templateName=$templateName;
	}

	function widget_output($position='default')
	{
		if(!empty($this->widget_positions[$position]))
		{
			$widgets=$this->widget_positions[$position];//gets all widgets in given position
			foreach($widgets as $widget_object)//display each widget
			{
				$widget_name=$widget_object->name;
				$widget_parameters=$widget_object->parameters;
				require_once('widgets/'.$widget_name.'/'.$widget_name.'.php');
				$widget_class=ucfirst($widget_name).'Widget';
				$widget=new $widget_class();
				$widget->run($widget_name,$widget_parameters);
			}
		}
	}

	function set_widget($position,$widget_name,$params=array())
	{
		$widget=new StdClass;
		$widget->name=$widget_name;
		$widget->parameters=$params;
		//if there is no widget in position then create a new array
		if(empty($this->widget_positions[$position])) 
		{
			$this->widget_positions[$position]=array($widget);
		}
		//if there is already a widget present in that position then just push new widget in array
		else
		{
			array_push($this->widget_positions[$position],$widget);
		}		
	}
}