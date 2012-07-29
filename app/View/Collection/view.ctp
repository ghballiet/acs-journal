<div class="page-header">
  <h1>
<? echo $collection['Collection']['title']; ?>
    <small>
<? echo $collection['Collection']['subtitle']; ?>
    </small>
  </h1>
</div>

<table class="table condensed">
<?
echo $this->Html->tableHeaders(array(
  'Order', 'Title', 'Author', 'Modified', ''
));

foreach($submissions as $submission) {
  $title = $submission['Submission']['title'];
  $slug = $submission['Submission']['slug'];
  $author = $this->Profile->name($submission['User']);
  $order = $submission['Submission']['order'];
  $modified = $submission['Submission']['modified'];
  $modified = $this->Time->timeAgoInWords($modified);
  $pdf = $this->Html->link('PDF', array(
    'controller'=>'submissions',
    'action'=>'paper', 
    'ext'=>'pdf',
    $slug
  ), array('class'=>'btn btn-mini btn-danger'));
  $abstract = $this->Html->link('Abstract', array(
    'controller'=>'submissions',
    'action'=>'view',
    $slug
  ), array('class'=>'btn btn-mini'));

  $buttons = array($pdf, $abstract);
  $buttons = implode('&nbsp;', $buttons);

  echo $this->Html->tableCells(array($order, $title, $author, $modified, $buttons));
}
?>
</table>
