<?
$this->start('css');
echo $this->Html->css('view_submission');
$this->end();

// general variables to be used on the page
$submission = $data['Submission'];
$paper = $data['Paper'];
$final = $data['Final'];
$previous = $data['Previous'];
$category = $data['Category'];
$collection = $data['Collection'];
$author = $data['User'];
$modified = $this->Time->timeAgoInWords($submission['modified']);

$authors = array();
$authors[] = array(
  'name' => $this->Profile->name($author),
  'email' => $author['email'],
  'institution' => $author['institution']
);
foreach($data['Coauthor'] as $coauthor)
  $authors[] = $coauthor;
?>

<div class="page-header">
<?
// download button
$url = $this->Html->url(array(
  'controller'=>'submissions',
  'action'=>'paper',
  'ext'=>'pdf',
  $submission['id']), true);
printf('<a href="%s" class="pdf btn btn-danger pull-right">' .
       '<i class="icon-file"></i> PDF</a>',
       $url);

// actions menu: edit, delete, etc; depending on user's role
$links = array();

if($auth['id'] == $user['id'] || $user['is_admin'] == 1) {
  // users or admins can edit and retract this submission
  $edit = array(
    'text' => 'Edit', 
    'link' => array('action'=>'edit', $submission['id']),
    'icon' => 'edit');
  $retract = array(
    'text' => 'Retract'
    'link' => array('action'=>'retract', $submission['id']),
    'icon' => 'remove');
  $links[] = $edit;
  $links[] = $retract;
}

// only display this menu if we have some links to show
if(count($links) > 0) {
  echo $this->Bootstrap->dropdownBtn(
    'Actions', $links, 'btn-primary', 'pull-right');

?>
  <h1><? echo $submission['title']; ?></h1>
</div>

<div class="row">
  <div class="span3 left">
    <div class="authors well">
      <h3>Authors</h3>
      <ul class="nav nav-pills nav-stacked">
<?
// TODO: add user badges (using the profile helper)
foreach($authors as $a) {
  printf('<li><a href="mailto:%s">%s</a></li>', 
         $a['email'], $a['name']);
}
?>
      </ul>
    </div>
    <div class="timestamp">
      modified <? echo $modified; ?>
    </div>
  </div>
  <div class="span9 right">
    <div class="abstract">
      <h3>Abstract</h3>
      <? echo $submission['abstract']; ?>
    </div>
  </div>
</div>
