<div>
  <h1><?php echo $row['title']; ?></h1>
  <div>
    <a href="<?php echo $this->to_url('edit-todo', ['id' => $row['id']]); ?>">Edit</a> |
    <a href="<?php echo $this->to_url('delete-todo', ['id' => $row['id']]); ?>">Delete</a>
  </div>
  <div>
    <p><?php echo $row['desc']; ?></p>
  </div>
</div>