<?php
require_once('includes/Application.php');
require_once('includes/TemplateFunctions.php');
class TodoApplication extends Application{

	/**
	 * cunstructor
	 * login is required for each function in todo application
	 */
	function __construct()
	{
		$this->login_required();
		$this->template = new TemplateFunctions();
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

		echo $time_left;
	}

	/**
	 * show the list of listed todos
	 */
    function index($args= null)
	{
		$label = isset($args['label']) ? $args['label']:'all';
		$user_id = $_SESSION['user_session']['id'];
		$db=$this->get_dbo();
		if($label == 'all')
		{
			$sql="SELECT * FROM todolist WHERE user_id=?";
			$args = array($user_id);
		}	
		else
		{
			$sql="SELECT * FROM todolist WHERE label=? AND user_id=? ";
			$args = array($label,$user_id);
		}
		$rows=$db->load_result($sql,$args);
		// include view todo list
		include_once($this->template->get_current_template_path().'/todo/index.php');
	}

	/**
	 * form for adding a new todo
	 */
	function add()
	{
		include_once($this->template->get_current_template_path().'/todo/new.php');
	}

	/**
	 * add a new todo task
	 */
	function create()
	{
		
		$title= filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
		$desc= filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_SPECIAL_CHARS);
		$end_date= filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_SPECIAL_CHARS);
		$label= filter_input(INPUT_POST, 'label', FILTER_SANITIZE_SPECIAL_CHARS);
		$start_date = date("Y-m-d");
		$sql="INSERT INTO todolist VALUES(?,?,?,?,?,?,?,?)";
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
	 */
	function edit($args)
	{
		$id=$args['id'];
		$user_id = $_SESSION['user_session']['id'];
		$sql="SELECT * FROM todolist WHERE id=? AND user_id=?";
		$db=$this->get_dbo();
		$row=$db->load_single_result($sql,array($id,$user_id));		
		include_once($this->template->get_current_template_path().'/todo/edit.php');
	}

	/**
	 * edit an existing todo
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
		$sql="UPDATE todolist as tasks SET tasks.title='$title',tasks.desc='$desc', tasks.progress='$progress', tasks.end_date='$end_date', tasks.label='$label' WHERE id=? AND user_id =?";
		$db=$this->get_dbo();				
		if($db->prepare($sql,array($id,$user_id)))
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
	 */
	function show($args = null)
	{
		$id = $args['id'];
		$user_id = $_SESSION['user_session']['id'];
		$sql="SELECT * FROM todolist WHERE id=? AND user_id=?";
		$args = array($id,$user_id);
		$db=$this->get_dbo();
		$row=$db->load_single_result($sql,$args);
		// include view todo list
		include_once($this->template->get_current_template_path().'/todo/show.php');
	}

	/**
	 * delete an existing task
	 */
	function destroy($args)
	{
		$id=$args['id'];
		$user_id = $_SESSION['user_session']['id'];
		$db=$this->get_dbo();
		$sql="DELETE FROM todolist WHERE id=? AND user_id =?";
		$db->prepare($sql,array($id,$user_id));
		$this->redirect($this->to_url('todo-home'));			
	}

	
}
?>