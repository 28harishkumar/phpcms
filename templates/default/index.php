<?php $this->get_header(); ?>
<div class='content col-md-8 col-lg-10'>
  <?php echo $this->app_output(); ?>
</div>
<div class="sidebar col-lg-1"><?php $this->get_sidebar(); ?></div>
</div>
<div class="clear"></div>
<?php
$this->get_footer(); ?>