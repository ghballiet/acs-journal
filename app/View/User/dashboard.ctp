<?
$this->start('css');
echo $this->Html->css('dashboard');
$this->end();
?>

<div class="page-header">
  <h1>Dashboard</h1>
</div>

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

    $links = array();
    foreach($submission_links as $link) {
      $link['link'][] = $id;
      $links[] = $link;
    }

    $submit = $this->Bootstrap->dropdownBtn(
      'Create Submission',
      $links,
      'btn-mini'
    );

    $delete = $this->Bootstrap->linkBtn(
      'Delete',
      array('controller'=>'papers', 'action'=>'delete', $id),
      'btn-mini btn-danger', array(),
      'Are you sure you want to delete this paper? This cannot be undone.'
    );
    $edit = $this->Bootstrap->linkBtn(
      'Edit',
      array('controller'=>'papers', 'action'=>'edit', $id),
      'btn-mini'
    );

    $btns = array($submit, $edit, $delete);
    $btn_html = implode(' ', $btns);
    $btn_html = sprintf('<div class="btn-toolbar">%s</div>', $btn_html);
    
    echo $this->Html->tableCells(
      array($title, $abstract, $modified, $btn_html),
      array(), array(), true);
  }
  echo '</table>';
}
?>
