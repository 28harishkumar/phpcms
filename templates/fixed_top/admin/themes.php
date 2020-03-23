<link type='text/css' rel='stylesheet' href='<?php echo STATIC_PATH; ?>css/theme-list.css' />
<div class="page-header">
  <h1>Themes</h1>
  <p>Change your theme from here! NOTE: Theme can be activated by only admin. If you are looking demo then use live preview</p>
  <a href="<?php echo  $this->to_url('admin-home'); ?>">Back to admin panel</a>
</div>
<h3>Currently active theme</h3>
<div class="themes row">
  <div class="theme col-lg-4 col-md-6">
    <div class="theme-screenshot">
      <img src="<?php echo ROOT . '/templates/' . THEME . '/Screenshot.png'; ?>" width="100%" class="" />
    </div>
    <span class="more-details" id="<?php echo THEME; ?>-action">Theme Details</span>
    <h3 class="theme-name" id="<?php echo THEME; ?>-name"><?php echo ucwords(str_replace('_', ' ', THEME)); ?></h3>
    <div class="theme-actions">
      <a class="btn btn-primary" href="#">Activated</a>
    </div>
  </div>
</div>

<div class="themes row">
  <h3>All themes in store</h3>
  <?php
  foreach ($themes as $theme) {
    if ($theme !== '..' && $theme !== '.') { ?>
      <div class="theme col-lg-4 col-md-6" tabindex="0" aria-describedby="<?php echo $theme; ?>-action <?php echo $theme; ?>-name">
        <div class="theme-screenshot">
          <img src="<?php echo ROOT . '/templates/' . $theme . '/Screenshot.png'; ?>" width="100%" class="" />
        </div>
        <div class="row">
          <span class="more-details" id="<?php echo $theme; ?>-action">Theme Details</span>
          <h3 class="theme-name" id="<?php echo $theme; ?>-name"><?php echo ucwords(str_replace('_', ' ', $theme)); ?></h3>
          <div class="theme-actions">
            <?php if (THEME !== $theme) { ?>
              <form action="<?php echo $this->to_url('theme-activate') . '?theme=' . $theme; ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
                <input type="submit" class="btn btn-default" value="Activate">
              </form>
              <form target="_blank" action="<?php echo $this->to_url('live-preview') . '?preview=true&theme=' . $theme . '&url=' . ROOT; ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
                <input type="submit" class="btn btn-primary" value="Live Preview">
              </form>
            <?php } else { ?>
              <a class="btn btn-primary" href="#">Activated</a>
            <?php } ?>
          </div>
        </div>
      </div>
  <?php }
  }
  ?>
</div>