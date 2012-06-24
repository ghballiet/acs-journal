<div class="page-header">
<?
   echo $this->Html->link('Create Collection',
                          array('controller'=>'collections', 'action'=>'add'),
                          array('class'=>'pull-right btn btn-primary'));
?>
  <h1>Manage Collections</h1>
</div>

<table class="table table-condensed">
<?
echo $this->Html->tableHeaders(array('Title', 'Submissions', 'Accepting Submissions', 'Modified', ''));

foreach($collections as $collection) {
  $title = $collection['Collection']['title'];
  $num_submissions = count($collection['Submission']);
  $accepting = $collection['Collection']['accepting_submissions'] == 1; 
  $modified = $collection['Collection']['modified'];
  $edit = $this->Html->link('Edit',
                            array('controller'=>'collections', 
                                  'action'=>'edit',
                                  $collection['Collection']['id']),
                            array('class'=>'btn btn-mini'));
  $delete = $this->Html->link('Delete', 
                              array('controller'=>'collections',
                                    'action'=>'delete',
                                    $collection['Collection']['id']),
                              array('class'=>'btn btn-mini btn-danger'),
                              'Are you sure you want to delete this collection? This cannot be undone.');

  echo $this->Html->tableCells(array($title, $num_submissions, $accepting, $modified, $edit . ' ' . $delete), 
                               array(), array(), true);
}
?>
</table>