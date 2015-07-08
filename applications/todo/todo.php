<?php
/**
 * @author Harish Kumar
 * @copyright Find All Together
 * @link http://www.findalltogeher.com
 * @version 1.0
 * This file handles the control of todo apliaction
 */
require_once('includes/Application.php');
class TodoApplication extends Application{

	/**
	 * cunstructor
	 * login is required for each function in todo application
	 */
	function __construct()
	{
		$this->login_required();
	}

	/**
	 * display list of all todos
	 */
	function display()
	{
		$this->index();
	}

	/**
	 * calculate time left for listed todo tasks
	 * @param date $end_date
	 * @return string $time_left
	 */
	private function time_left($end_date)
	{
		$today = strtotime("now");
		$due_date = strtotime($end_date);
		if($due_date>$today)
		{
			$hours = $due_date - $today;
			$hours = $hours/3600;
			$time_left = $hours/24;
			
			if($time_left < 1)
			{
				$time_left = 'Less than 1 day';
			}
			else
			{
				$time_left = round($time_left).' days';
			}
		}
		else
		{
			$time_left = 'Expired';
		}

		return $time_left;
	}

	/**
	 * show the list of listed todos
	 * @param array $args
	 * @param string $args['label']
	 * @return HttpResponse
	 */
    function index($args= null)
	{
		$label = isset($args['label']) ? $args['label']:'all';
		$user_id = $_SESSION['user_session']['id'];
		$db=$this->get_dbo();
		if($label == 'all')
		{
			$sql="SELECT * FROM `todolist` WHERE user_id=?";
			$args = array($user_id);
		}	
		else
		{
			$sql="SELECT * FROM `todolist` WHERE label=? AND user_id=? ";
			$args = array($label,$user_id);
		}
		$rows=$db->load_result($sql,$args);
		// include view todo list
		include_once(TEMPLATE_PATH.'/todo/index.php');
	}

	/**
	 * form for adding a new todo
	 * @return HttpResponse
	 */
	function add()
	{
		include_once(TEMPLATE_PATH.'/todo/new.php');
	}

	/**
	 * add a new todo task
	 * @return redirect
	 */
	function create()
	{
		
		$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
		$desc= filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_SPECIAL_CHARS);
		$end_date= filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_SPECIAL_CHARS);
		$label= filter_input(INPUT_POST, 'label', FILTER_SANITIZE_SPECIAL_CHARS);
		$start_date = date("Y-m-d");
		$sql="INSERT INTO `todolist` VALUES(?,?,?,?,?,?,?,?)";
		$user_id = $_SESSION['user_session']['id'];
		$args = array(NULL,$title,$desc,0,$start_date,$end_date,$label,$user_id);
		$db=$this->get_dbo();			
		if($db->prepare($sql,$args))
		{				
			$this->redirect($this->to_url('todo-home'));				
		}
		else
		{
			$this->redirect();		
		}

	}

	/**
	 * form for editing a todo entry
	 * @param array $args
	 * @param string $args['id']
	 * @return HttpResponse
	 */
	function edit($args)
	{
		$id=$args['id'];
		$user_id = $_SESSION['user_session']['id'];
		$sql="SELECT * FROM `todolist` WHERE id=? AND user_id=?";
		$db=$this->get_dbo();
		$row=$db->load_single_result($sql,array($id,$user_id));		
		include_once(TEMPLATE_PATH.'/todo/edit.php');
	}

	/**
	 * edit an existing todo
	 * @return redirect
	 */
	function update()
	{	
		$id= filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
		$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
		$desc= filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_SPECIAL_CHARS);
		$end_date= filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_SPECIAL_CHARS);
		$label= filter_input(INPUT_POST, 'label', FILTER_SANITIZE_SPECIAL_CHARS);
		$progress = $_POST['progress'];
		$user_id = $_SESSION['user_session']['id'];
		$sql="UPDATE `todolist` as tasks SET tasks.title=?,tasks.desc=?, tasks.progress=?, tasks.end_date=?, tasks.label=? WHERE id=? AND user_id =?";
		$db=$this->get_dbo();				
		if($db->prepare($sql,array($title,$desc,$progress,$end_date,$label,$id,$user_id)))
		{
			$this->redirect($this->to_url('todo-home'));				
		}
		else
		{				
			$this->redirect();
		}			
	}

	/**
	 * show discription of todo
	 * @param array $args
	 * @param string $args['id']
	 * @return HttpResponse
	 */
	function show($args = null)
	{
		$id = $args['id'];
		$user_id = $_SESSION['user_session']['id'];
		$sql="SELECT * FROM `todolist` WHERE id=? AND user_id=?";
		$args = array($id,$user_id);
		$db=$this->get_dbo();
		$row=$db->load_single_result($sql,$args);
		// include view todo list
		include_once(TEMPLATE_PATH.'/todo/show.php');
	}

	/**
	 * delete an existing task
	 * @param array $args
	 * @param string $args['id']
	 * @return redirect
	 */
	function destroy($args)
	{
		$id=$args['id'];
		$user_id = $_SESSION['user_session']['id'];
		$db=$this->get_dbo();
		$sql="DELETE FROM `todolist` WHERE id=? AND user_id =?";
		if($db->prepare($sql,array($id,$user_id))->rowCount()!==0)
		{
			$_SESSION['success'] = 'deleted successfully'.$id;
			$this->redirect($this->to_url('todo-home'));
		}
		$_SESSION['error'] = 'could not deleted successfully';
		$this->redirect($this->to_url('todo-home'));
	}

	
}
?>