<div class="page-header">
  <h1>Create New Collection</h1>
</div>

<?
echo $this->BootstrapForm->create('Collection');
echo $this->BootstrapForm->input('title');
echo $this->BootstrapForm->input('description');
echo $this->BootstrapForm->input('accepting_submissions');
echo $this->BootstrapForm->end('Create Collection');
?>