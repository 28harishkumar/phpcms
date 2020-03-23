<?php

/**
 * This is header of the default theme. 
 * THis header contains logo, main menu and search box in the top section of the web page.
 * @author Harish Kumar
 * @copyright Flowkl 
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
  <div class="hfeed site">
    <div id="header" class="header col-sm-12">
      <header id="masthead" class="site-header" role="banner">
        <div class="site-branding">
          <h1 class="site-title"><a href="<?php echo ROOT; ?>" rel="home"><?php $this->widget_output('logo_position'); ?></a></h1>
        </div><!-- .site-branding -->
      </header><!-- .site-header -->
    </div><!-- .header -->
    <div class="container-fluid">