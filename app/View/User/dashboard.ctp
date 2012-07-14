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

<?
pr($submissions);
?>

<table class="table table-condensed">
</table>
