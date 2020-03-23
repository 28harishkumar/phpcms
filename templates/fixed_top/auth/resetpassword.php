<?php
if (isset($_GET['error'])) {
  $error = $_GET['error'];
}

?>
<div id="resetpaswd" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="panel-title">Reset Password</div>
    </div>
    <div class="panel-body">
      <form id="resetform" class="form-horizontal" role="form" method="post" action="<?php echo $this->to_url('reset'); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
        <div id="erroralert" style="<?php if (!isset($error)) echo 'display:none'; ?>" class="alert alert-danger">
          <p>Error:</p>
          <span><?php if (isset($error)) echo $error; ?></span>
        </div>

        <input type="hidden" name="e" value=<?php echo $email; ?>>
        <input type="hidden" name="i" value=<?php echo $code; ?>>

        <div class="form-group">
          <label for="pass1" class="col-md-3 control-label">Password</label>
          <div class="col-md-9">
            <input required="required" type="password" class="form-control" name="pass1" placeholder="Password">
          </div>
        </div>

        <div class="form-group">
          <label for="password2" class="col-md-3 control-label">Confirm Password</label>
          <div class="col-md-9">
            <input required="required" type="password" class="form-control" name="pass2" placeholder="Confirm Password">
          </div>
        </div>

        <div class="form-group">
          <!-- Button -->
          <div class="col-md-offset-3 col-md-9">
            <input id="btn-signup" type="submit" class="btn btn-info" value="Submit" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>