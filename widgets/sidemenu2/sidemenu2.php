<?php
require_once('includes/Widget.php');
class Sidemenu2Widget extends Widget
{
  function display()
  {
    if ($this->is_login()) {
?>
      <h4>Labels</h4>
      <ul class="nav nav-pills nav-stacked">
        <li><a href="<?php echo $this->to_url('todo-list'); ?>">All</a></li>
        <li><a href="<?php echo $this->to_url('todo-label', ['label' => 'inbox']); ?>">Inbox</a></li>
        <li><a href="<?php echo $this->to_url('todo-label', ['label' => 'stared']); ?>">Stared</a></li>
        <li><a href="<?php echo $this->to_url('todo-label', ['label' => 'important']); ?>">Important</a></li>
      </ul>
<?php
    }
  }
}
?>