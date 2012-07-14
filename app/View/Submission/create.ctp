<div class="page-header">
  <h1>Submit Paper</h1>
</div>

<?
echo $this->BootstrapForm->create('Submission', array('type'=>'file'));
echo $this->BootstrapForm->input('collection_id', array('label'=>'Venue'));
echo $this->BootstrapForm->input('title');
echo $this->BootstrapForm->input('abstract');

// TODO: input the file here

// TODO: add coathors here

echo $this->BootstrapForm->end('Submit');
?>