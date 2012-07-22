<div class="page-header">
  <h1><? echo $collection['Collection']['title']; ?></h1>
</div>

<table class="table condensed">
<?
echo $this->Html->tableHeaders(array(
  'Title', 'Author', 'Modified', ''
));

foreach($submission as $submission) {
  $title = $submission['Submission']['title'];
  $slug = $submission['Submission']['slug'];
  $author = $this->Profile->name($submission['User']);
  $modified = $submission['Submission']['modified'];
  $link = $this->Html->link('PDF', array(
    'controller'=>'submissions',
    'action'=>'view', 
    $slug
  ), array('class'=>'btn btn-mini btn-danger'));

  echo $this->Html->tableCells(array($title, $author, $modified, $link));
}
?>
</table>