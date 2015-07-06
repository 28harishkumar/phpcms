<div class="todolist-app table-responsive">
	<h2>Todolist Application Dashboard</h2>
	<h3>My Todolist<?php if($label != 'all'){echo ' label: '.$label;}?></h3>
	<table class="table table-bordered table-striped table-condensed">
		<thead  class="cf">
			<tr>
				<th class="col-sm-3">Task</th>
				<th class="col-sm-2">Progress</th>
				<th class="col-sm-1">Time Left</th>
				<?php if($label == 'all'){echo '<th>Label</th>';}?>						
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php			
		foreach($rows as $row)
		{
		?>
			<tr>
				<td><a href="<?php echo $this->to_url('show-todo',['id' => $row['id']]); ?>"> <?php echo $row['title'];?></a></td>
				<td><div class="progress">
				  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
				  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" 
				  style="width:<?php echo $row['progress'];?>%">
				  </div>
				</div></td>
				<td><?php $this->time_left($row['end_date']);?></td>
				<?php if($label == 'all'){ echo '<td>'.$row['label'].'</td>';}?>
				<td>
				   <a href="<?php echo $this->to_url('edit-todo',['id' => $row['id']]);?>">Edit</a>|
				   <a href="<?php echo $this->to_url('delete-todo',['id' => $row['id']]);?>">Delete</a>
				 </td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
</div>