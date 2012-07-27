<?
$this->start('css');
echo $this->Html->css('2012-toc');
$this->end();

$sub = ClassRegistry::init('Submission');


$papers = array(
  array(
    'title' => 'Advances in Cognitive Systems',
    'author' => 'Pat Langley', 
    'slug' => '',
    'pages' => 2,
  ),
  array(
    'id' => 11,
  ),
  array(
    'id' => 8,
  ),
  array(
    'id' => 13,
  ),
  array(
    'id' => 7,
  ),
  array(
    'id' => 9,
  ),
  array(
    'id' => 6,
  ),
  array(
    'id' => 12,
  ),
  array(
    'id' => 10, 
  )
);
?>
<div class="page-header">
  <h1>Advances in Cognitive Systems</h1>
  <div class="published_info">
    <div class="volume">Volume 1, July 2012 to present</div>
  </div>
  <h2>Table of Contents</h2>
  <h3>Invited Essays</h3>
</div>

<table class="table">
<?

$page = 1;

foreach($papers as $i=>$paper) {
  $buttons = '';
  $title = '';
  $author = '';
  $pages = 0;

  if($i == 0)
    echo $this->Html->tableHeaders(array('Editorial', 'Authors', 'Page', ''));
  else if ($i == 1)
    echo $this->Html->tableHeaders(array('Invited Essays', '', '', ''));

  // get pdf and abstract links
  if(!isset($paper['id'])) {
    $buttons = '<a href="#" class="btn btn-mini btn-danger disabled">PDF</a>';
    $buttons .= '&nbsp;';
    $buttons .= '<a href="#" class="btn btn-mini disabled">Abstract</a>';
    $title = $paper['title'];
    $author = $paper['author'];
    $pages = $paper['pages'];
  } else {
    $item = $sub->findById($paper['id']);
    $title = $item['Submission']['title'];
    $author = sprintf('%s %s', $item['User']['name'], $item['User']['surname']);
    $pages = $item['Submission']['pages'];
    $slug = $item['Submission']['slug'];
    
    $pdf = $this->Html->link('PDF', array(
      'controller'=>'submissions', 'action'=>'paper', 'ext'=>'pdf',
      $slug), array('class'=>'btn btn-mini btn-danger'));
    $abstract = $this->Html->link('Abstract', array(
      'controller'=>'submissions', 'action'=>'view',
      $slug), array('class'=>'btn btn-mini'));

    $buttons = sprintf('%s&nbsp;%s', $pdf, $abstract);      
  }

  echo $this->Html->tableCells(array(
    $title, $author, $page, $buttons
  ), array(), array(), true);

  $page += $pages;
  
  if($page % 2 == 0)
    $page++;
}
?>
</table>
