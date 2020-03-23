<div id="login" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="panel-title">Log In</div>
      <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#forgetpassword" onClick="$('#login').hide(); $('#forgetpassword').show()">Forgot password?</a></div>
    </div>

    <div style="padding-top:30px" class="panel-body">
      <?php if (isset($_SESSION['l_error'])) { ?>
        <div id="login-alert" class="alert alert-danger col-sm-12">
          <p>Error:</p>
          <span><?php echo $_SESSION['l_error'];
                unset($_SESSION['l_error']); ?></span>
        </div>
      <?php } ?>
      <form id="loginform" class="form-horizontal" role="form" action="<?php echo $this->to_url('login'); ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
        <div style="margin-bottom: 25px" class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input required="required" id="login-email" type="email" class="form-control" name="login-email" value="" placeholder="email">
        </div>

        <div style="margin-bottom: 25px" class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input required="required" id="login-password" type="password" class="form-control" name="password" placeholder="password">
        </div>

        <div style="margin-top:10px" class="form-group">
          <!-- Button -->
          <div class="col-sm-12 controls">
            <input type="submit" value="Log in" id="btn-login" class="btn btn-success">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 control">
            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%">
              Don't have an account!
              <a href="#signup" onClick="$('#login').hide(); $('#signup').show()">
                Sign Up Here
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="signup" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="panel-title">Sign Up</div>
      <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#login" onclick="$('#signup').hide(); $('#login').show()">Log In</a></div>
    </div>
    <div class="panel-body">
      <form id="signupform" class="form-horizontal" role="form" method="post" action="<?php echo $this->to_url('register'); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
        <?php if (isset($_SESSION['error'])) { ?>
          <div id="signupalert" class="alert alert-danger">
            <p>Error:</p>
            <?php echo "<span>" . $_SESSION['error'] . "</span>";
            unset($_SESSION['error']);
            ?>
          </div>
        <?php } ?>
        <div class="form-group">
          <label for="email" class="col-md-3 control-label">Email</label>
          <div class="col-md-9">
            <input required="required" type="email" class="form-control" name="email" placeholder="Email Address">
          </div>
        </div>

        <div class="form-group">
          <label for="password1" class="col-md-3 control-label">Password</label>
          <div class="col-md-9">
            <input required="required" minlenght="8" type="password" class="form-control" name="password1" placeholder="Password">
          </div>
        </div>

        <div class="form-group">
          <label for="password2" class="col-md-3 control-label">Confirm Password</label>
          <div class="col-md-9">
            <input required="required" minlenght="8" type="password" class="form-control" name="password2" placeholder="Confirm Password">
          </div>
        </div>

        <div class="form-group">
          <!-- Button -->
          <div class="col-md-offset-3 col-md-9">
            <input id="btn-signup" type="submit" class="btn btn-info" value="Sign Up" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="forgetpassword" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="panel-title">Forget Password</div>
      <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#login" onclick="$('#forgetpassword').hide(); $('#login').show()">Log In</a></div>
    </div>
    <div class="panel-body">
      <form id="forgetpswdform" class="form-horizontal" role="form" method="post" action="<?php echo $this->to_url('forget-password'); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
        <div id="signupalert" style="display:none" class="alert alert-danger">
          <p>Error:</p>
          <span></span>
        </div>

        <div class="form-group">
          <label for="email" class="col-md-3 control-label">Email</label>
          <div class="col-md-9">
            <input required="required" type="email" class="form-control" name="forget-email" placeholder="Email Address">
          </div>
        </div>

        <div class="form-group">
          <!-- Button -->
          <div class="col-md-offset-3 col-md-9">
            <input id="btn-signup" type="submit" class="btn btn-info" vslue='Send Verification Link' />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    var tab = window.location.href.split('#');
    if (tab.length == 2) {
      if (tab[1] !== 'login') {
        $('#login').hide();
        $('#' + tab[1]).show();
      }

    }
  });
</script>