<?
$this->start('css');
echo $this->Html->css('2012-toc');
$this->end();

$sub = ClassRegistry::init('Submission');


$papers = array(
  array(
    'slug' => 'paper-3-2-141',
  ),
  array(
    'slug' => 'paper-3-2-140',
  ),
  array(
    'slug' => 'paper-3-2-133',
  ),
  array(
    'slug' => 'paper-3-2-102',
  ),
  array(
    'slug' => 'paper-3-2-134',
  ),
  array(
    'slug' => 'paper-3-2-39',
  ),
  array(
    'slug' => 'paper-3-2-55',
  ),
  array(
    'slug' => 'paper-3-2-139',
  ),
  array(
    'slug' => 'paper-3-2-136',
  ),
  array(
    'slug' => 'paper-3-2-135',
  ),
  array(
    'slug' => 'paper-3-2-104',
  ),
  array(
    'slug' => 'paper-3-2-8',
  ),
  array(
    'slug' => 'paper-3-2-97',
  ),
  array(
    'slug' => 'paper-3-2-57',
  ),
  array(
    'slug' => 'paper-3-2-38',
  ),
  array(
    'slug' => 'paper-3-2-121',
  )
);
?>
<div class="page-header">
  <h1>Advances in Cognitive Systems</h1>
  <h2>Volume 2, December 2012</h2>
  <h3>Table of Contents</h3>
</div>

<table class="table">
<?

$page = 1;

foreach($papers as $i=>$paper) {
  $button1 = '';
  $button2 = '';
  $title = '';
  $author = '';
  $pages = 0;

  if($i == 0)
    echo $this->Html->tableHeaders(array('Editorial', '', '', '', ''));
  else if ($i == 1)
    echo $this->Html->tableHeaders(array('Essay', '', '', '', ''));
  else if ($i == 2)
    echo $this->Html->tableHeaders(array('Refereed Articles', '', '', '', ''));

  // get pdf and abstract links
  if(!isset($paper['slug'])) {
    $button1 = '<a href="#" class="btn btn-mini btn-danger disabled">PDF</a>';
    $button2 = '<a href="#" class="btn btn-mini disabled">Abstract</a>';
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

/*	if ($paper['slug'] == 'paper-3-2-141')
		$author_str = 'Pat Langley';
	if ($paper['slug'] == 'paper-3-2-140')
		$author_str = 'Pat Langley';
	if ($paper['slug'] == 'paper-3-2-133')
		$author_str = ''; */
	if ($paper['slug'] == 'paper-3-2-102')
		$author_str = 'Boyang Li, Stephen Lee-Urban, Darren S. Appling, Mark Riedl';
/*	if ($paper['slug'] == 'paper-3-2-134')
		$author_str = '';
	if ($paper['slug'] == 'paper-3-2-39')
		$author_str = ''; */
	if ($paper['slug'] == 'paper-3-2-55')
		$author_str = 'Siddharth Narayanaswamy, Andrei Barbu, Jeffrey M. Siskind';
/*	if ($paper['slug'] == 'paper-3-2-139')
		$author_str = '';
	if ($paper['slug'] == 'paper-3-2-136')
		$author_str = '';
	if ($paper['slug'] == 'paper-3-2-135')
		$author_str = '';
	if ($paper['slug'] == 'paper-3-2-104')
		$author_str = '';
	if ($paper['slug'] == 'paper-3-2-8')
		$author_str = '';
	if ($paper['slug'] == 'paper-3-2-97')
		$author_str = '';
		*/
	if ($paper['slug'] == 'paper-3-2-57')
		$author_str = 'Andrei Barbu, Siddharth Narayanaswamy, Aaron Michaux, Jeffrey M. Siskind';
	if ($paper['slug'] == 'paper-3-2-38')
		$title = 'Online Determination of Value-Function Structure and Action-value <br> Estimates for Reinforcement Learning in a Cognitive Architecture';
//	if ($paper['slug'] == 'paper-3-2-121')
//		$author_str = '';

    $pdf = $this->Html->link('PDF', array(
      'controller'=>'submissions', 'action'=>'paper', 'ext'=>'pdf',
      $slug), array('class'=>'btn btn-mini btn-danger'));
    $abstract = $this->Html->link('Abstract', array(
      'controller'=>'submissions', 'action'=>'view',
      $slug), array('class'=>'btn btn-mini'));

    $button1 = sprintf('%s', $pdf);
	$button2 = sprintf('%s', $abstract);
  }

  echo $this->Html->tableCells(array(
    $title, $author_str, $page, $button1, $button2
  ), array(), array(), true);

  $page += $pages;
  
  if($page % 2 == 0)
    $page++;
}
?>
</table>
