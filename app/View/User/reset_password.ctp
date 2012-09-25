<div class="page-header">
  <h1>Reset Your Password</h1>
</div>

<?
echo $this->BootstrapForm->create('User');
echo $this->BootstrapForm->input('id', array('type'=>'hidden', 'value'=>$reset_for['User']['id']));
echo $this->BootstrapForm->input('email', array('type'=>'email', 'autofocus'=>true));
echo $this->BootstrapForm->input('password', array('type'=>'password', 'label'=>'New Password'));
echo $this->BootstrapForm->input('confirm_password', array('type'=>'password', 'label'=>'Confirm New Password'));
echo $this->BootstrapForm->end('Reset Password');
?>
