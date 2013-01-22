<?
$this->start('css');
echo $this->Html->css('2012-toc');
$this->end();

$sub = ClassRegistry::init('Submission');


$papers = array(
  array(
    'slug' => 'paper-3-2-123',
	),
  array(
    'slug' => 'paper-3-2-138',
	),
  array(
    'slug' => 'paper-3-2-9',
	),
  array(
    'slug' => 'paper-3-2-87',
	),
  array(
    'slug' => 'paper-3-2-78',
	),
  array(
    'slug' => 'paper-3-2-132',
	),
  array(
    'slug' => 'paper-3-2-98',
	),
  array(
    'slug' => 'paper-3-2-91',
	),
  array(
    'slug' => 'paper-3-2-23',
	)
);
?>
<div class="page-header">
  <h2>First Annual Conference on</h2>
  <h1>Advances in Cognitive Systems</h1>
  <h2>2012 Poster Collection</h2>
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
    echo $this->Html->tableHeaders(array('Poster', '', '', ''));

  // get pdf and abstract links
  if(!isset($paper['slug'])) {
    $buttons = '<a href="#" class="btn btn-mini btn-danger disabled">PDF</a>';
    $buttons .= '&nbsp;';
    $buttons .= '<a href="#" class="btn btn-mini disabled">Abstract</a>';
    $title = $paper['title'];
    $author = $paper['author'];
    $pages = $paper['pages'];
  } else {
    $item = $sub->findBySlug($paper['slug']);
    $title = $item['Submission']['title'];
    $author = sprintf('%s %s', $item['User']['name'], $item['User']['surname']);
    $pages = $item['Submission']['pages'];
    $slug = $item['Submission']['slug'];

    $authors = array($author);

    foreach($item['Coauthor'] as $coauthor)
      $authors[] = $coauthor['name'];

    $author_str = implode(', ', $authors);
    
    $pdf = $this->Html->link('PDF', array(
      'controller'=>'submissions', 'action'=>'paper', 'ext'=>'pdf',
      $slug), array('class'=>'btn btn-mini btn-danger'));
    $abstract = $this->Html->link('Abstract', array(
      'controller'=>'submissions', 'action'=>'view',
      $slug), array('class'=>'btn btn-mini'));

    $buttons = sprintf('%s&nbsp;%s', $pdf, $abstract);      
  }

  echo $this->Html->tableCells(array(
    $title, $author_str, $page, $buttons
  ), array(), array(), true);

  $page += $pages;
  
  if($page % 2 == 0)
    $page++;
}
?>
</table>
