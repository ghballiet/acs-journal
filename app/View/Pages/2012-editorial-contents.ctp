<?
$this->start('css');
echo $this->Html->css('2012-toc');
$this->end();

$papers = array(
  array(
    'title' => 'The Cognitive Systems Paradigm',
    'author' => 'Pat Langley',
    'url' => '#'
  ),
  array(
    'title' => 'Beyond Idiot-Savant AI',
    'author' => 'Scott E. Fahlman',
    'url' => '#'
  ),
  array(
    'title' => 'The Right Way',
    'author' => 'Patrick Henry Winston',
    'url' => '#'
  ),
  array(
    'title' => 'Human-Level Artificial Intelligence Must be an Extraordinary Science',
    'author' => 'Nicholas L. Cassimatis',
    'url' => '#'
  ),
  array(
    'title' => 'How Minds Will Be Built',
    'author' => 'Kenneth D. Forbus',
    'url' => '#'
  ),
  array(
    'title' => 'When Do Robots Have to Think?',
    'author' => 'Claude Sammut',
    'url' => '#'
  ),
  array(
    'title' => 'Evaluating Integrated, Knowledge-Rich Cognitive Systems',
    'author' => 'Randolph M. Jones, Robert E. Wray, and Michael van Lent',
    'url' => '#'
  )
);
?>
<div class="page-header">
  <h1>Advances in Cognitive Systems</h1>
  <div class="published_info">
    <div class="volume">Volume 1, Issue 1</div>
    <div class="date">July, 2012</div>
    <div class="clearfix"></div>
  </div>
  <h2>Table of Contents</h2>
</div>

<table class="table">
<?
echo $this->Html->tableHeaders(array('Title', 'Authors', 'Page', ''));

foreach($papers as $i=>$paper) {
  $buttons = '';
  $buttons .= $this->Html->link('PDF', $paper['url'],
                                array('class'=>'btn btn-mini btn-danger'));
  $buttons .= '&nbsp;';
  $buttons .= $this->Html->link('Abstract', '#', array('class'=>'btn btn-mini'));

  echo $this->Html->tableCells(array(
    $paper['title'], $paper['author'], ($i+1) * 6, $buttons
  ), array(), array(), true);
}
?>
</table>
