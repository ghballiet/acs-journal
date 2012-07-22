<div class="page-header">
  <h1>Reset Your Password</h1>
</div>

<p class="alert alert-info">
  To reset your password, fill out the form below. You should recieve
  a message within 24 hours from <strong>acs@cogsys.org</strong> with
  a link to reset your password.
</p>

<?
echo $this->BootstrapForm->create('User');
echo $this->BootstrapForm->input('email', array('type'=>'email',
                                                'icon'=>'envelope'));
echo $this->BootstrapForm->input('surname', array('label'=>'Last Name',
                                                  'icon'=>'user'));
echo $this->BootstrapForm->end('Reset Password');
?> 
