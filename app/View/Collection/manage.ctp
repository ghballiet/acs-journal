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
echo $this->Html->tableHeaders(array('Title', 'Submissions', 'Accepting Submissions', 'Modified'));

foreach($collections as $collection) {
  $title = $collection['Collection']['title'];
  $num_submissions = count($collection['Submission']);
  $accepting = $collection['Collection']['accepting_submissions'] === 1; 
  $modified = $collections['Collection']['modified'];

  echo $this->Html->tableCells(array($title, $num_submissions, $accepting, $modified), 
                               array(), array(), true);
}
?>
</table>