<?
$this->start('css');
echo $this->Html->css('2012-toc');
$this->end();

$sub = ClassRegistry::init('Submission');
$winston = $sub->findByTitle('The Right Way');
$sammut = $sub->findByTitle('When Do Robots Have to Think?');
$bello = $sub->findByTitle('Cognitive Foundations for a Computational ' . 
                           'Theory of Mindreading');


$papers = array(
  array(
    'title' => 'Advances in Cognitive Systems',
    'author' => 'Pat Langley', 
    'slug' => '',
    'pages' => 2,
  ),
  array(
    'title' => 'The Cognitive Systems Paradigm',
    'author' => 'Pat Langley',
    'slug' => '',
    'pages' => 10,
  ),
  array(
    'title' => 'Beyond Idiot-Savant AI',
    'author' => 'Scott E. Fahlman',
    'slug' => '',
    'pages' => 7,
  ),
  array(
    'title' => $winston['Submission']['title'],
    'author' => 'Patrick Henry Winston',
    'slug' => $winston['Submission']['slug'],
    'pages' => 12
  ),
  array(
    'title' => 'Human-Level Artificial Intelligence Must be an Extraordinary Science',
    'author' => 'Nicholas L. Cassimatis',
    'slug' => '',
    'pages' => 10,
  ),
  array(
    'title' => 'How Minds Will Be Built',
    'author' => 'Kenneth D. Forbus',
    'slug' => '',
    'pages' => 12, 
  ),
  array(
    'title' => $bello['Submission']['title'],
    'author' => 'Paul Bello',
    'slug' => $bello['Submission']['slug'],
    'pages' => 14,
  ),
  array(
    'title' => $sammut['Submission']['title'],
    'author' => 'Claude Sammut',
    'slug' => $sammut['Submission']['slug'], 
    'pages' => 10,
  ),
  array(
    'title' => 'Practical Evaluation of Integrated Cognitive Systems', 
    'author' => 'Randolph M. Jones, Robert E. Wray, and Michael van Lent',
    'slug' => '',
    'pages' => 0
  )
);
?>
<div class="page-header">
  <h1>Advances in Cognitive Systems</h1>
  <div class="published_info">
    <div class="volume">Volume 1, Issue 1, July, 2012</div>
  </div>
  <h2>Table of Contents</h2>
</div>

<table class="table">
<?
echo $this->Html->tableHeaders(array('Title', 'Authors', 'Page', ''));

$page = 1;

foreach($papers as $i=>$paper) {
  $buttons = '';

  // get pdf and abstract links
  if(empty($paper['slug'])) {
    $buttons = '<a href="#" class="btn btn-mini btn-danger disabled">PDF</a>';
    $buttons .= '&nbsp;';
    $buttons .= '<a href="#" class="btn btn-mini disabled">Abstract</a>';
  } else {
    $pdf = $this->Html->link('PDF', array(
      'controller'=>'submissions', 'action'=>'paper', 'ext'=>'pdf',
      $paper['slug']), array('class'=>'btn btn-mini btn-danger'));
    $abstract = $this->Html->link('Abstract', array(
      'controller'=>'submissions', 'action'=>'view',
      $paper['slug']), array('class'=>'btn btn-mini'));

    $buttons = sprintf('%s&nbsp;%s', $pdf, $abstract);      
  }

  echo $this->Html->tableCells(array(
    $paper['title'], $paper['author'], $page, $buttons
  ), array(), array(), true);

  $page += $paper['pages'];
}
?>
</table>
