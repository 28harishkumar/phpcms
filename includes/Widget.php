<?php
require_once('Base.php');
class Widget extends Base{
	private $widget_path='';
	private $widget_name='';
	private $parameters=array();

	function set_widget_path($widget_name)
	{
		$this->widget_path='widgets/'.$widget_name.'/';
		$this->widget_name=$widget_name;
	}

	function get_widget_path()
	{
		return $this->widget_path;
	}

	function display()
	{
		echo 'this will be default output of widget if this function is not overrided by derived class';
	}

	function run($widget_name,$params)// this function will be called by template function class to display widget
	{
		$this->parameters=$params;
		$this->set_widget_path($widget_name);
		$this->display();
	}
}
?>