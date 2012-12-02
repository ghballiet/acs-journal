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
$keywords = $data['Keyword'];
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
  $submission['slug']), true);
printf('<a href="%s" class="pdf btn btn-danger pull-right">' .
       '<i class="icon-file"></i> PDF</a>',
       $url);
			 
 // Final version button
 if(($author['id'] == $user['id'] || $user['is_admin'] == 1) && $submission['source_uploaded'] == 1){
	 $url = "../sources/" . $submission['slug'] . ".zip";
	 printf('<a href="%s" class="pdf btn btn-danger pull-right">' .
	        '<i class="icon-file"></i> Camera-Ready Version</a>',
	        $url);
 }

// actions menu: edit, delete, etc; depending on user's role
$links = array();

if($author['id'] == $user['id'] || $user['is_admin'] == 1) {
  // users or admins can edit and retract this submission
  $slug = $submission['slug'];
  $edit = array(
    'text' => 'Edit Submission Details', 
    'link' => array('action'=>'edit', $slug),
    'icon' => 'edit');
  $retract = array(
    'text' => 'Retract',
    'link' => array('action'=>'retract', $slug),
    'icon' => 'remove');
  $revise = array(
    'text' => 'Submit Revision',
    'link' => array('action'=>'revise', $slug),
    'icon' => 'share');
  $finalize = array(
    'text' => 'Submit Camera-Ready Version',
    'link' => array('action'=>'finalize', $slug),
    'icon' => 'share');
  $links[] = $edit;
//  $links[] = $revise;
	$links[] = $finalize;
  $links[] = $retract;
}

// only display this menu if we have some links to show
if(count($links) > 0) {
  echo $this->Bootstrap->dropdownBtn(
    'Actions', $links, 'btn-primary', 'pull-right');
}
?>
  <h1><? echo $submission['title']; ?></h1>
</div>

<? if($author['id'] == $user['id']) { ?>
<p class="alert alert-info">
  <strong>Quick tip:</strong> You can submit a camera-ready version of this
  paper by clicking <strong>Actions > Submit Camera-Ready Version</strong>.
	You can use the same procedure to resubmit camera-ready versions up until the 
	deadline. 
</p>
<? } ?>

<div class="row">
  <div class="span3 left">
    <div class="authors well">
      <ul class="nav nav-pills nav-stacked">
        <li class="nav-header">Authors</li>
<?
// TODO: add user badges (using the profile helper)
foreach($authors as $a) {
  //printf('<li><a href="mailto:%s">%s</a></li>', 
  //       $a['email'], $a['name']);
  printf('<li><a>%s</a></li>', $a['name']);
}
?>
<?
if(!empty($keywords)) {
?>
        <li class="divider"></li>
        <li class="nav-header">Keywords</li>
<?
  foreach($keywords as $keyword) {
    printf('<li><a href="#">%s</a></li>', $keyword['value']);
  }
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
