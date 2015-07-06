<div>
  	<h2>Todolist Application Dashboard</h2>
    <h3>Add New Todolist</h3>
					
	<form role="form" method="post" action="<?php echo $this->to_url('add-todo'); ?>">
	
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="title" class="form-control" />
		</div>

		<div class="form-group">
			<label for="desc">Description</label>
			<textarea name="desc" class="form-control"></textarea>
		</div>

		<div class="form-group">
			<label for="title">End Date (YYYY-MM-DD)</label>
			<input type="text" name="end_date" class="form-control"  />
		</div>

		<div class="form-group">
			<label for="title">Label</label>
			<select type="text" name="label" class="form-control">
				<option value="inbox">Inbox</option>
				<option value="important">Important</option>
				<option value="starred">Stared</option>
			</select>
		</div>

		<button type="submit" class="btn btn-default">Add Task</button>					
	</form>
</div>