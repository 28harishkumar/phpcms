<div class="page-header">
  <h1>User Edit</h1>
  <h3><?php echo trim($user['email'], '\''); ?></h3>
  <a href="<?php echo  $this->to_url('admin-home'); ?>">Back to admin panel</a>
</div>
<div class="panel col-sm-12">
  <form class="form" method="post" action="<?php echo $this->to_url('admin-update-user', ['id' => $user['id']]); ?>">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
    <div class="form-group" style="clear:both; max-width:500px;">
      <input type="email" required name="email" class="form-control" palceholder='email' value="<?php echo trim($user['email'], '\'') ?>">
    </div>
    <div class="form-group" style="clear:both; max-width:500px;">
      <label>Password</label>
      <input type="password" name="password1" class="form-control" palceholder="Password">
    </div>
    <div class="form-group" style="clear:both; max-width:500px;">
      <label>Confirm Password</label>
      <input type="password" name="password2" class="form-control" palceholder='Confirm Password'>
    </div>
    <div class="form-group">
      <label>User role</label>
      <select name="role">
        <option <?php if ($user['role'] == 'admin') {
                  echo 'selected';
                } ?> value="admin">Admin</option>
        <option <?php if ($user['role'] == 'demo_checker') {
                  echo 'selected';
                } ?> value="demo_checker">Demo Checker</option>
        <option <?php if ($user['role'] == 'user') {
                  echo 'selected';
                } ?> value="user">User</option>
      </select>
    </div>
    <div class="form-group">
      <label>Is Active</label>
      <input type="checkbox" name="is_active" <?php if ($user['is_active']) {
                                                echo 'checked';
                                              } ?>>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-default">Update</button>
    </div>
  </form>
</div>