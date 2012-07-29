<?
$this->start('scripts');
echo $this->Html->script('add_collection');
$this->end();
?>

<div class="page-header">
  <h1>Create New Collection</h1>
</div>

<?
echo $this->BootstrapForm->create('Collection');
echo $this->BootstrapForm->input('title', array('autofocus'=>true));
echo $this->BootstrapForm->input('subtitle');
echo $this->BootstrapForm->input('slug');
echo $this->BootstrapForm->input('description', array(
  'required'=>false));
echo $this->BootstrapForm->input('accepting_submissions', array(
  'required'=>false));
echo $this->BootstrapForm->end('Create Collection');
?>