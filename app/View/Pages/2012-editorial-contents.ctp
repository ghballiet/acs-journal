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
  <h1>Advances in Cognitive Systems, Volume 1<br><small>Table of Contents</small></h1>
</div>

<table class="table">
<?


foreach($papers as $i=>$paper) {
  $buttons = '';
  $buttons .= $this->Html->link('PDF', $paper['url'],
                                array('class'=>'btn btn-mini btn-danger'));
  $buttons .= '&nbsp;';
  $buttons .= $this->Html->link('Abstract', '#', array('class'=>'btn btn-mini'));

  echo $this->Html->tableHeaders(array('Title', 'Author', 'Page', ''));

  echo $this->Html->tableCells(array(
    $paper['title'], $paper['author'], $i * 6; $buttons
  ), array(), array(), true);
}
?>
</table>
