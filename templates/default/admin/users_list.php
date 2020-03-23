<div class="page-header">
  <h1>Users</h1>
  <p>List of all users.</p>
  <p>By default record of the admin will not be displayed. User can be edited or deleted by only admin. If you are looking demo then you can not do this.</p>
  <a href="<?php echo  $this->to_url('admin-home'); ?>">Back to admin panel</a>
</div>
<div class="panel col-sm-12">
  <div class="table-responsive" id="no-more-tables">
    <table class="table-bordered table-striped table-condensed cf">
      <thead class="cf">
        <tr>
          <th>Email</th>
          <th>Role</th>
          <th>Is Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($users as $user) {
          if ($user['role'] !== 'admin') { ?>
            <tr>
              <td data-title="Email"><?php echo trim($user['email'], '\''); ?></td>
              <td data-title="Role"><?php echo ucfirst(str_replace('_', ' ', $user['role'])); ?></td>
              <td data-title="Is Active"><?php if ($user['is_active']) {
                                            echo 'Yes';
                                          } else {
                                            echo 'No';
                                          } ?></td>
              <td data-title="Action">
                <div class="left"><a href="<?php echo $this->to_url('admin-edit-user', ['id' => $user['id']]); ?>">Edit</a> |&nbsp;</div>
                <form id="delete-user-form-<?php echo $user['id']; ?>" class="delete-form" method='post' action="<?php echo $this->to_url('admin-delete-user', ['id' => $user['id']]); ?>">
                  <input type="hidden" name="csrf_token" value="<?php echo CSRF; ?>">
                  <a href="#" onclick="$('#delete-user-form-<?php echo $user['id']; ?>').submit();return false;">Delete</a>
                </form>
              </td>
            </tr>
        <?php  }
        } ?>
      </tbody>
    </table>
  </div>
</div>