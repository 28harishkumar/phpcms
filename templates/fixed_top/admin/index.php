<div class="page-header">
	<h1>Admin Panel</h1>
	<p>Handle user interface from here. It is kept simple for basic learning.</p>
</div>
<div class="col-sm-offset-1">
	<ul>
		<li><a href="<?php echo  $this->to_url('theme-settings');?>">Manage Theme</a></li>
		<li><a href="<?php echo  $this->to_url('admin-user-list');?>">Manage Users</a></li>
		<li><a href="<?php echo  $this->to_url('menu-list');?>">Manage Menus - (code still in progress)</a></li>
		<li><a href="<?php echo  $this->to_url('widget-settings');?>">Manage Widgets - (code still in progress)</a></li>
	</ul>
</div>