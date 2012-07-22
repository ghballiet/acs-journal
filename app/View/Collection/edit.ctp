<div class="page-heaer">
  <h1>Edit Collection
    <small><? echo $collection['Collection']['title']; ?></small>
  </h1>
</div>

<?
echo $this->BootstrapForm->create('Collection');
echo $this->BootstrapForm->input('id', array('type'=>'hidden'));
echo $this->BootstrapForm->input('title');
echo $this->BootstrapForm->input('description', array('required'=>false));
echo $this->BootstrapForm->input('accepting_submissions', 
                                 array('required'=>false));
echo $this->BootstrapForm->end('Save Changes');
?>
