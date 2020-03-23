<?php

/**
 * This is header of the default theme. 
 * THis header contains logo, main menu and search box in the top section of the web page.
 * @author Harish Kumar
 * @copyright Flowkl | Programming and web development
 * @link https://www.flowkl.com
 * @version 1.0
 */

?>
<!DOCTYPE html>
<html>

<head>
  <title>MyCMS from screech</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link type='text/css' rel='stylesheet' href='<?php echo STATIC_PATH; ?>css/bootstrap.min.css' />
  <link type='text/css' rel='stylesheet' href='<?php echo STATIC_PATH; ?>css/style.css' />
  <script type="text/javascript" src="<?php echo STATIC_PATH; ?>js/jquery-2.1.1.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <?php if ($this->is_login()) { ?>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        <?php } ?>
        <a class="navbar-brand" href="<?php echo ROOT; ?>"><?php $this->widget_output('logo_position'); ?></a>
      </div>
      <?php if ($this->is_login()) { ?>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php $this->widget_output('nav_position'); ?>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      <?php } ?>
    </div>
  </nav>
  <div class="container-fluid clean">
    <div class="row content">