<?php
require_once('includes/Widget.php');
class NavWidget extends Widget{		
	function display()
	{
		if($this->is_login())
		{
		?>
	        <li><a href="<?php echo $this->to_url('new-todo'); ?>">New</a></li>
	        <li><a href="<?php echo $this->to_url('todo-home'); ?>">View</a></li>
	        <li class="dropdown" role="presentation">
	        	<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Label<span class="caret"></span></a>
	        	<ul class="dropdown-menu">
			    	<li><a href="<?php echo $this->to_url('todo-label',['label' => 'inbox']); ?>">Inbox</a></li>
					<li><a href="<?php echo $this->to_url('todo-label',['label' => 'stared']); ?>">Stared</a></li>
					<li><a href="<?php echo $this->to_url('todo-label',['label' => 'important']); ?>">Important</a></li>
				</ul>
			</li>
			<li><a href="<?php echo $this->to_url('logout'); ?>">Log out</a></li>
		<?php
		}
	}
}
?>