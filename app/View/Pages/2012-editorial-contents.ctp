<?
$this->start('css');
echo $this->Html->css('2012-toc');
$this->end();

$sub = ClassRegistry::init('Submission');
$winston = $sub->findByTitle('The Right Way');
$sammut = $sub->findByTitle('When Do Robots Have to Think?');
$bello = $sub->findByTitle('Cognitive Foundations for a Computational' . 
                           'Theory of Mindreading');

$winston_url = $this->Html->url(array(
  'controller'=>'submissions', 'action'=>'view', 
  $winston['Submission']['slug']), true);


$papers = array(
  array(
    'title' => 'Advances in Cognitive Systems',
    'author' => 'Pat Langley', 
    'url' => '#', 
    'pages' => 1,
  ),
  array(
    'title' => 'The Cognitive Systems Paradigm',
    'author' => 'Pat Langley',
    'url' => '#',
    'pages' => 10,
  ),
  array(
    'title' => 'Beyond Idiot-Savant AI',
    'author' => 'Scott E. Fahlman',
    'url' => '#',
    'pages' => 7,
  ),
  array(
    'title' => 'The Right Way',
    'author' => 'Patrick Henry Winston',
    'url' => $winston_url,
    'pages' => 12
  ),
  array(
    'title' => 'Human-Level Artificial Intelligence Must be an Extraordinary Science',
    'author' => 'Nicholas L. Cassimatis',
    'url' => '#',
    'pages' => 10,
  ),
  array(
    'title' => 'How Minds Will Be Built',
    'author' => 'Kenneth D. Forbus',
    'url' => '#',
    'pages' => 12, 
  ),
  array(
    'title' => 'When Do Robots Have to Think?',
    'author' => 'Claude Sammut',
    'url' => '#',
    'pages' => 10,
  ),
  array(
    'title' => 'Practical Evaluation of Integrated Cognitive Systems', 
    'author' => 'Randolph M. Jones, Robert E. Wray, and Michael van Lent',
    'url' => '#',
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
  $buttons .= $this->Html->link('PDF', $paper['url'],
                                array('class'=>'btn btn-mini btn-danger'));
  $buttons .= '&nbsp;';
  $buttons .= $this->Html->link('Abstract', '#', array('class'=>'btn btn-mini'));

  echo $this->Html->tableCells(array(
    $paper['title'], $paper['author'], $page, $buttons
  ), array(), array(), true);

  $page += $paper['pages'];
}
?>
</table>
