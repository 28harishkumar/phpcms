<link type='text/css' rel='stylesheet' href='<?php echo STATIC_PATH;?>css/theme-list.css' />
<div class="page-header">
	<h1>Themes</h1>
	<p>Change your theme from here!</p>
</div>
<h3>Currently active theme</h3>
<div class="themes panel col-sm-12">
	<div class="theme panel-body col-xs-12 col-md-4">
		<div class="theme-screenshot">
			<img src="<?php echo ROOT.'/templates/'.THEME.'/Screenshot.png'; ?>" width="100%" class=""/>
		</div>
		<span class="more-details" id="<?php echo THEME; ?>-action">Theme Details</span>
		<h3 class="theme-name" id="<?php echo THEME; ?>-name"><?php echo ucwords(str_replace('_', ' ', THEME)); ?></h3>
		<div class="theme-actions">
			<a class="btn btn-primary" href="#">Activated</a>
		</div>
	</div>
</div>

<div class="themes panel">
<h3>All themes in store</h3>
<?php
	foreach ($themes as $theme) {
		if($theme!=='..' && $theme!=='.'){ ?>
		<div class="theme panel-body col-xs-12 col-md-4" tabindex="0" aria-describedby="<?php echo $theme; ?>-action <?php echo $theme; ?>-name">
			<div class="theme-screenshot">
				<img src="<?php echo ROOT.'/templates/'.$theme.'/Screenshot.png'; ?>" width="100%" class=""/>
			</div>
			<span class="more-details" id="<?php echo $theme; ?>-action">Theme Details</span>
			<h3 class="theme-name" id="<?php echo $theme; ?>-name"><?php echo ucwords(str_replace('_', ' ', $theme)); ?></h3>
			<div class="theme-actions">
				<?php if(THEME !== $theme ){ ?>
				<form action="<?php echo $this->to_url('theme-activate').'?theme='.$theme; ?>" method="post">
				<input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
				<input type="submit" class="btn btn-default" value="Activate">
				</form>
				<a class="btn btn-primary" href="#?theme=<?php echo $theme; ?>">Live Preview</a>
				<?php }else{ ?>
				<a class="btn btn-primary" href="#">Activated</a>
				<?php } ?>
			</div>
		</div>
		<?php }
	}
?>
</div>