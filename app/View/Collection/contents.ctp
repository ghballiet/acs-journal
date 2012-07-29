<?
$this->start('css');
echo $this->Html->css('contents');
$this->end();
?>

<div class="page-header">
   <h1><? echo $collection['Collection']['title']; ?></h1>
   <div class="published_info">
     <div class="subtitle"><? echo $collection['Collection']['subtitle']; ?></div>     
   </div>
   <h2>Table of Contents</h2>
</div>

<?
if(empty($submissions)) {
  echo '<p class="alert alert-info">There are no submissions available for this collection.</p>';
} else {
  echo '<table class="table">';

  $page = 1;
  
  foreach($submissions as $paper) {
    $buttons = '';
    $title = $paper['Submission']['title'];
    $authors = array(sprintf('%s %s', $paper['User']['name'], $paper['User']['surname']));
    $pages = $paper['Submission']['pages'];
    $order = $paper['Submission']['order'];

    $slug = $paper['Submission']['slug'];

    foreach($paper['Coauthor'] as $coauthor)
      $authors[] = $coauthors['name'];

    $author = implode(', ', $authors);

    $pdf = $this->Html->link('PDF', array(
      'controller'=>'submissions', 'action'=>'paper', 'ext'=>'pdf',
      $slug), array('class'=>'btn btn-mini btn-danger'));
    $abstract = $this->Html->link('Abstract', array(
      'controller'=>'submissions', 'action'=>'view',
      $slug), array('class'=>'btn btn-mini'));

    $buttons = sprintf('%s&nbsp;%s', $pdf, $abstract);

    echo $this->Html->tableCells(array(
      $title, $author, $page, $buttons
    ), array(), array(), true);

    $page += $pages;

    if($page % 2 == 0)
      $page++;
  }

  echo '</table>';
}
?>
