<div class="page-header">
  <h1>Create Submission</h1>
</div>

<?
echo $this->BootstrapForm->create('Submission');
echo '<div class="control-group">';
echo '<label for="SubmissionCollection" class="control-label">Collection</label>';
echo '<div class="controls">';
printf('<a href="#" rel="popover" data-content="%s" data-original-title="%s">%s</a>',
  $collection['Collection']['description'], $collection['Collection']['title'],
  $collection['Collection']['title']);
echo '</div>';
echo '</div>';
echo $this->BootstrapForm->input('presenter_name');
echo $this->BootstrapForm->end('Create Submission');
?>
