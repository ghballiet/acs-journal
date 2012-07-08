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
echo $this->Html->link('Upload Paper', 
  array('controller'=>'papers', 'action'=>'upload'),
  array('class'=>'btn btn-primary pull-right'));
?>
   <h2>Papers</h2>
<?
if(count($papers) == 0) {
  echo '<div class="alert alert-info">';
  echo 'You haven\'t uploaded any papers. ';
  echo '</div>';
} else {
  echo '<table class="table table-condensed">';
  echo $this->Html->tableHeaders(array(
      'Title', 'Abstract', 'Modified', ''));

  // build a list of submission links for the dropdown menu
  $submission_links = array();
  foreach($collections as $collection) {
    $id = $collection['Collection']['id'];
    $title = $collection['Collection']['title'];
    $link = array();
    $link['text'] = $title;
    $link['link'] = array('controller'=>'submissions', 'action'=>'create', $id);
    $submission_links[] = $link;
  }

  foreach($papers as $paper) {
    $id = $paper['Paper']['id'];
    $title = $paper['Paper']['title'];
    $abstract = $paper['Paper']['abstract'];
    $modified = $paper['Paper']['modified'];  

    $links = $submission_links;
    foreach($links as $l)
      $l['link'][] = $id;

    $submit = $this->Bootstrap->dropdownBtn(
      'Create Submission',
      $links,
      'btn-mini btn-inverse'
    );

    $delete = $this->Bootstrap->linkBtn(
      'Delete',
      array('controller'=>'papers', 'action'=>'delete', $id),
      'btn-mini btn-danger'
    );
    $edit = $this->Bootstrap->linkBtn(
      'Edit',
      array('controller'=>'papers', 'action'=>'edit', $id),
      'btn-mini'
    );

    $btns = array($submit, $edit, $delete);
    $btn_html = implode(' ', $btns);
    
    echo $this->Html->tableCells(
      array($title, $abstract, $modified, $btn_html),
      array(), array(), true);
  }
  echo '</table>';
}
?>
  </div>
</div>
