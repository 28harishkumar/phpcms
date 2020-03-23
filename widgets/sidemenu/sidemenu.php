<?php
require_once('includes/Widget.php');
class SidemenuWidget extends Widget
{
  function display()
  {
    if ($this->is_login()) {
?>
      <h4>Links</h4>
      <ul class="nav nav-pills nav-stacked">
        <li><a href="<?php echo $this->to_url('new-todo'); ?>">Add Todo Task</a></li>
        <li><a href="<?php echo $this->to_url('todo-home'); ?>">View Todo List</a></li>
        <li><a href="<?php echo $this->to_url('logout'); ?>">Log out</a></li>
      </ul>
<?php
    }
  }
}
?>