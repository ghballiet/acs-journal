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
   <h2>Papers</h2>
<?
if(count($papers) == 0) {
  echo '<div class="alert alert-info">';
  echo 'You haven\'t uploaded any papers. ';
  echo $this->Html->link(
    'Submit a Paper',
    array('controller'=>'papers', 'action'=>'upload'),
    array('class'=>'btn btn-primary'));
  echo '</div>';
} else {
  echo '<table class="table table-condensed">';
  echo $this->Html->tableHeaders(array(
      'Title', 'Abstract', 'Modified', ''));
  foreach($papers as $paper) {
    $id = $paper['Paper']['id'];
    $title = $paper['Paper']['title'];
    $abstract = $paper['Paper']['abstract'];
    $modified = $paper['Paper']['modified'];
    
    $delete = $this->Bootstrap->linkBtn(
      'Delete',
      array('controller'=>'papers', 'action'=>'delete', $id),
      'btn-mini btn-danger'
    );

    $btns = array($delete);
    $btn_html = $btns.join(' ');
    
    echo $this->Html->tableCells(
      array($title, $abstract, $modified, $btn_html),
      array(), array(), true);
  }
  echo '</table>';
}
?>
  </div>
</div>
