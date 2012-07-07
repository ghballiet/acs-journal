<div class="page-header">
  <h1>Upload Paper</h1>
</div>

<?
echo $this->BootstrapForm->create('Paper', array('type'=>'file'));
echo $this->BootstrapForm->input('title',
  array('autofocus'=>'true')
);
echo $this->BootstrapForm->input('abstract');
echo $this->BootstrapForm->input('paper');
echo $this->BootstrapForm->end('Upload Paper');
?>