<div class="page-header">
  <h1>Submit Paper</h1>
</div>

<?
echo $this->BootstrapForm->create('Submission', array('type'=>'file'));
echo $this->BootstrapForm->input('collection_id', array('label'=>'Venue', 'autofocus'=>true));
echo $this->BootstrapForm->input('title');
echo $this->BootstrapForm->input('abstract');
echo $this->BootstrapForm->input('Upload', array('type'=>'file'));
echo $this->Html->link('Add Coauthor', '#', array('class'=>'btn btn-mini pull-right'));
echo $this->BootstrapForm->input('Coauthor.0.name');
echo $this->BootstrapForm->input('Coauthor.0.email');
echo $this->BootstrapForm->input('Coauthor.0.institution');
echo $this->BootstrapForm->end('Submit');
?>