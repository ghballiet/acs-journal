
<div class="page-header">
<center>
  <h1>
    <span class="leading">Advances in Cognitive Systems</span>
  </h1>
</center>
</div>

<br>
<center>
  <h1>
    <h2>Volumes of the Journal</h2>
  </h1>
</center>


<!--

<p>
<font size="3">
<a href="/journal/volume-1">Volume 1:</a>
<br>
July to December 2012
<br><br>
<?
$buttonj1 = '';
$buttonj1 = '<a href="#" class="btn btn disabled">Collection</a>';
$viewcollect = $this->Html->link('View Volume', "/journal/volume-1", array('class'=>'btn btn'));
$buttonj1 = sprintf('%s', $viewcollect);
echo $buttonj1;
?>
<hr>
<a href="/journal/volume-2">Volume 2:</a>
<br>
December 2012
<br>
(First Annual Conference for Advances in Cognitive Systems)
<br><br>
<?
$buttonj2 = '';
$buttonj2 = '<a href="#" class="btn btn disabled">Collection</a>';
$viewcollect = $this->Html->link('View Volume', "/journal/volume-2", array('class'=>'btn btn'));
$buttonj2 = sprintf('%s', $viewcollect);
echo $buttonj2;
?>
</font>
<hr>
<br>

<div class="page-header">
<center>
  <h1>
    <h2>Associated Collections</h2>
  </h1>
</center>
</div>

<p>
<font size="3">
<a href="/posters/2012">Poster collection 1:</a>
<br>
December 2012
<br>
(First Annual Conference for Advances in Cognitive Systems)
</font>
<br><br>
<?
$buttonp1 = '';
$buttonp1 = '<a href="#" class="btn btn disabled">Collection</a>';
$viewcollect = $this->Html->link('View Collection', "/posters/2012", array('class'=>'btn btn'));
$buttonp1 = sprintf('%s', $viewcollect);
echo $buttonp1;
?>
<hr>

-->





<table class="table">
<?
//echo $this->Html->tableHeaders(array('Volume', '', ''));
{
  $titlej1 = '<font size="3"><i>Volume 1: July to December 2012</i></font>';
  $infoj1 = 'Inaugural volume of <i>Advances in Cognitive Systems</i>';
  $buttonj1 = '<a href="#" class="btn btn disabled">Volume</a>';
  $viewcollect = $this->Html->link('View Volume', "/journal/volume-1", array('class'=>'btn btn'));
  $buttonj1 = sprintf('%s', $viewcollect);
  echo $this->Html->tableCells(array($titlej1, $infoj1, $buttonj1), array(), array(), true);
}
{
  $titlej2 = '<font size="3"><i>Volume 2: December 2012</i></font>';
  $infoj2 = 'First Annual Conference for Advances in Cognitive Systems';
  $buttonj2 = '<a href="#" class="btn btn disabled">Volume</a>';
  $viewcollect = $this->Html->link('View Volume', "/journal/volume-2", array('class'=>'btn btn'));
  $buttonj2 = sprintf('%s', $viewcollect);
  echo $this->Html->tableCells(array($titlej2, $infoj2, $buttonj2), array(), array(), true);
}
?>
</table>
<hr>

<br> <br>
<center>
  <h1>
    <h2>Associated Collections</h2>
  </h1>
</center>

<table class="table">
<?
//echo $this->Html->tableHeaders(array('Collection', '', ''));
{
  $titlep1 = '<font size="3"><i>Poster Collection 1: December 2012</i></font>';
  $infop1 = 'First Annual Conference for Advances in Cognitive Systems';
  $buttonp1 = '<a href="#" class="btn btn disabled">Collection</a>';
  $viewcollect = $this->Html->link('View Collection', "/posters/2012", array('class'=>'btn btn'));
  $buttonp1 = sprintf('%s', $viewcollect);
  echo $this->Html->tableCells(array($titlep1, $infop1, $buttonp1), array(), array(), true);
}
?>
</table>
<hr>










