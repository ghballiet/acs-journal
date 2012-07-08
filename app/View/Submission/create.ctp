<div class="page-header">
  <h1>Create Submission</h1>
</div>

<?
echo $this->BootstrapForm->create('Submission');
echo $this->BootstrapForm->input('collection_id', array(
    'type'=>'hidden', 'value'=>$collection['Collection']['id']));
echo $this->BootstrapForm->input('paper_id', array(
    'type'=>'hidden', 'value'=>$paper['Paper']['id']));
echo $this->BootstrapForm->input('presenter_name');
echo $this->BootstrapForm->end('Create Submission');
?>
