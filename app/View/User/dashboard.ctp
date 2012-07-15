<?
$this->start('css');
echo $this->Html->css('dashboard');
$this->end();
?>

<div class="page-header">
  <h1>Dashboard</h1>
</div>

<?
echo $this->Html->link(
  'Submit a Paper',
  array('controller'=>'submissions', 'action'=>'create'),
  array('class'=>'btn btn-primary pull-right')
);
?>
<h2>My Submissions</h2>

<table class="table table-condensed">
<?
echo $this->Html->tableHeaders(array(
  '', 'Title', 'Abstract', 'Venue', 'Modified', ''));

foreach($submissions as $submission) {
  $title = $submission['Submission']['title'];
  $abstract = $submission['Submission']['abstract'];
  $venue = $submission['Collection']['title'];
  $modified = $submission['Submission']['modified'];
  $locked = null;
  
  if($submission['Submission']['locked'] == true) {
    $locked = $this->Html->tag('i', array('class'=>'icon-lock'));
  }

  $cells = array($locked, $title, $abstract, $venue, $modified, null);
  
  echo $this->Html->tableCells($cells);
}
?>
</table>
