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
echo $this->Html->tableHeaders(array('Title', 'Submissions',
                                     'Status', 'Modified', ''));

foreach($collections as $collection) {
  $title = $collection['Collection']['title'];
  $id = $collection['Collection']['id'];
  $slug = $collection['Collection']['slug'];
  $link = $this->Html->link($title, array(
    'controller'=>'collections', 'action'=>'view', $slug
  ));
  $num_submissions = count($collection['Submission']);
  $accepting = $collection['Collection']['accepting_submissions'] == 1; 

  if($accepting)
    $status = '<span class="label label-success">Accepting Submissions</span>';    
  else
    $status = '<span class="label label-important">Closed</span>';

  $modified = $collection['Collection']['modified'];
  $modified = $this->Time->timeAgoInWords($modified);
  $edit = $this->Html->link('Edit',
                            array('controller'=>'collections', 
                                  'action'=>'edit', $slug),
                            array('class'=>'btn btn-mini'));
  $delete = $this->Html->link('Delete', 
                              array('controller'=>'collections',
                                    'action'=>'delete',
                                    $slug),
                              array('class'=>'btn btn-mini btn-danger'),
                              'Are you sure you want to delete this collection? ' . 
                              'This cannot be undone.');

  echo $this->Html->tableCells(
    array($link, $num_submissions, $status, $modified, $edit . ' ' . $delete), 
    array(), array(), true);
}
?>
</table>