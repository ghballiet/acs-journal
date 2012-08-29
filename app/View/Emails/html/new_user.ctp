<div class="page-header">
  <h3>New User</h3>
</div>

<p>Dear <? printf('%s %s', $admin['name'], $admin['surname']); ?>,</p>

<p>A new user has created an account:</p>

<?
unset($user['confirm_password']);
pr($user);
?>
