<div class="page-header">
  <h1>Dashboard</h1>
</div>

<div class="row">
  <div class="span3 sidebar">
    <ul class="nav nav-list well">
      <li class="nav-header">Quick Links</li>
      <li><a href="#">Lorem Ipsum</a></li>
      <li><a href="#">Dolor Sit Amet</a></li>
    </ul>
  </div>

  <div class="span9 papers">
<?
if(count($papers) == 0) {
  echo '<div class="alert alert-info">';
  echo 'You haven\'t uploaded any papers. ';
  echo $this->Html->link(
    'Submit a Paper',
    array('controller'=>'submissions', 'action'=>'new'),
    array('class'=>'btn btn-primary'));
  echo '</div>';
} else {
   
}
?>
  </div>
</div>
