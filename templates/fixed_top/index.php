<?php $this->get_header();
if (isset($_SESSION['error'])) {
  echo "<div class='alert alert-danger' role='alert'><p><strong>" . $_SESSION['error'] . "</strong></p></div>";
  unset($_SESSION['error']);
}
if (isset($_SESSION['message'])) {
  echo "<div class='alert alert-info' role='alert'><p><strong>" . $_SESSION['message'] . "</strong></p></div>";
  unset($_SESSION['message']);
}
if (isset($_SESSION['success'])) {
  echo "<div class='alert alert-success' role='alert'><p><strong>" . $_SESSION['success'] . "</strong></p></div>";
  unset($_SESSION['success']);
}
?>
<div class='col-sm-12 main'>
  <?php echo $this->app_output(); ?>
</div>
</div>
<div class="clear"></div>
<?php $this->get_footer(); ?>