<div class="todolist-app table-responsive">
  <h2>Todo Task Application Dashboard</h2>
  <h3>My Todolist<?php if ($label != 'all') {
                    echo ' label: ' . $label;
                  } ?></h3>
  <table id="no-more-tables" class="table-bordered table-striped table-condensed cf">
    <thead class="cf">
      <tr>
        <th class="col-sm-3">Task</th>
        <th class="col-sm-2">Progress</th>
        <th class="col-sm-1">Time Left</th>
        <?php if ($label == 'all') {
          echo '<th>Label</th>';
        } ?>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($rows)) {
        foreach ($rows as $row) {
      ?>
          <tr>
            <td data-title="Task"><a href="<?php echo $this->to_url('show-todo', ['id' => $row['id']]); ?>"> <?php echo $row['title']; ?></a></td>
            <td data-title="Progress">
              <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $row['progress']; ?>%">
                </div>
              </div>
            </td>
            <td data-title="Time Left"><?php echo $this->time_left($row['end_date']); ?></td>
            <?php if ($label == 'all') {
              echo '<td data-title="Label">' . $row['label'] . '</td>';
            } ?>
            <td data-title="Action">
              <div class="left"><a href="<?php echo $this->to_url('edit-todo', ['id' => $row['id']]); ?>">Edit</a> |&nbsp;</div>
              <form id="delete-todo-form-<?php echo $row['id']; ?>" class="delete-form" method='post' action="<?php echo $this->to_url('delete-todo', ['id' => $row['id']]); ?>">
                <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
                <a href="#" onclick="$('#delete-todo-form-<?php echo $row['id']; ?>').submit();return false;">Delete</a>
              </form>
            </td>
          </tr>
      <?php
        }
      } else {
        echo "<tr><th colspan='4'>No todo under this label.</th></tr>";
      }
      ?>
    </tbody>
  </table>
</div>