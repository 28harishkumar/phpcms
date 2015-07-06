<?php
require_once('includes/Widget.php');
class SidemenuWidget extends Widget{		
	function display()
	{
		if($this->is_login())
		{
		?>
		  <div>
		    <h3>Links</h3>
		  	<div class="col-lg-12" style="padding:0px;">
		      <ul class="nav nav-pills nav-stacked">
		        <li><a href="<?php echo $this->to_url('new-todo'); ?>">Add Todo Task</a></li>
		        <li><a href="<?php echo $this->to_url('todo-home'); ?>">View Todo List</a></li>
		        <li><a href="<?php echo $this->to_url('logout'); ?>">Log out</a></li>
		      </ul>
		    </div>
		    <h3>Labels</h3>
		  	<div class="col-lg-12" style="padding:0px;">
		      <ul class="nav nav-pills nav-stacked">
		      	<li><a href="<?php echo $this->to_url('todo-list'); ?>">All</a></li>
		        <li><a href="<?php echo $this->to_url('todo-label',['label' => 'inbox']); ?>">Inbox</a></li>
		        <li><a href="<?php echo $this->to_url('todo-label',['label' => 'stared']); ?>">Stared</a></li>
		        <li><a href="<?php echo $this->to_url('todo-label',['label' => 'important']); ?>">Important</a></li>
		      </ul>
		    </div>
		   </div>
		<?php
		}
	}
}
?>