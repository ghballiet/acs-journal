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

echo $this->Html->tag('h3', 'Authors');
echo $this->Profile->badge($user);
if(isset($coauthors)) {
  foreach($coauthors as $coauthor) {
    echo $this->Profile->badge($coauthor);
  }
}

echo $this->BootstrapForm->end('Save Changes');
?>