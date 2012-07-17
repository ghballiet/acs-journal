<div class="page-header">
  <h1>Edit Submission
    <small><? echo $submission['Submission']['title']; ?></small>
  </h1>
</div>

<?
echo $this->BootstrapForm->create('Submission');

echo $this->Html->tag('h3', 'Submission Information');
echo $this->BootstrapForm->input('title', array('icon'=>'pencil'));
echo $this->BootstrapForm->input('abstract', array('icon'=>'pencil'));
echo $this->Html->tag('hr');

echo $this->Html->tag('h3', 'Coauthors');
pr($submission['Coauthor']);

echo $this->BootstrapForm->end('Save Changes');
?>