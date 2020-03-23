<div class="todolist-app">
  <h2>Edit Todo Task</h2>
  <form role="form" method="post" action="<?php echo $this->to_url('update-todo'); ?>">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />

    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" name="title" value="<?php echo $row['title']; ?>" class="form-control" />
    </div>

    <div class="form-group">
      <label for="desc">Description</label>
      <textarea name="desc" class="form-control"><?php echo $row['desc']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="title">Progress (in %)</label>
      <input type="text" name="progress" value="<?php echo $row['progress']; ?>" class="form-control" />
    </div>

    <div class="form-group">
      <label for="title">End Date (YYYY-MM-DD)</label>
      <input type="text" name="end_date" value="<?php echo $row['end_date']; ?>" class="form-control" />
    </div>

    <div class="form-group">
      <label for="title">Label</label>
      <select type="text" name="label" class="form-control">
        <option value="inbox" <?php if ($row['label'] == 'inbox') echo "selected"; ?>>Inbox</option>
        <option value="important" <?php if ($row['label'] == 'important') echo "selected"; ?>>Important</option>
        <option value="stared" <?php if ($row['label'] == 'stared') echo "selected"; ?>>Stared</option>
      </select>
    </div>

    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>