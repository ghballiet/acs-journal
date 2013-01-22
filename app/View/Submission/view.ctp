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

$sub = ClassRegistry::init('Submission');

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

// Back to collection button (for published papers)
// Need a more graceful way of doing this - BM 12/2012
$back = "";
$incollection = false;
$jvol1 = array(14, 11, 8, 13, 7, 9, 6, 12, 10, 210);
foreach($jvol1 as $i) {
	$item = $sub->findById($i);
	if($submission['slug'] == $item['Submission']['slug']) {
		$back = "/journal/volume-1";
		$incollection = true;
	}}
$jvol2 = array('141', '140', '133', '102', '134', '39', '55',
'139', '136', '135', '104', '8', '97', '57', '38', '121');
foreach($jvol2 as $i) {
	if($submission['slug'] == ('paper-3-2-' . $i)) {
		$back = "/journal/volume-2";
		$incollection = true;
	}}
$pvol1 = array('123','138','9','87','78','132','98','91','23');
foreach($pvol1 as $i) {
	if($submission['slug'] == ('paper-3-2-' . $i)) {
		$back = "/posters/2012";
		$incollection = true;
	}}
if($incollection){
printf('<a href="%s" class="btn btn pull-right">' .
       '<i class="icon-file"></i> Return to Collection</a>',
       $back);
}


if(($submission['category_id'] != '-1') && ($submission['category_id'] != '0')){ // BM 18 Jan 2013
// BM 8 Jan 2013
// This should create the collated-style review if the user is a site admin,
// admin or editor, or if they are the author of the paper.
// if($user_role == 'site_admin' || $user_role == 'admin' || $user_role == 'editor'){
if($author['id'] == $user['id'] || $user['is_admin'] == 1){
	$sub_id = $submission['id'];
    $review_button = $this->Html->link('Reviews', array(
			'controller'=>'submissions',
			'action'=>'reviews',
			substr(md5($sub_id),0,7)
		), array('class'=>'btn btn-primary pull-right'));
		//'btn-primary', 'pull-right');
    //echo $this->Html->tableCells(array($order, $title, $author, $buttons));
	//echo $this->Html->$review_button;
	echo $this->Html->tableCells(array($review_button));
	//echo $this->$review_button;
	//echo $this->Bootstrap->dropdownBtn('Actions', $links, 'btn-primary', 'pull-right');
	// $url = "../sources/" . $submission['slug'] . ".zip";
	// printf('<a href="%s" class="pdf btn btn-danger pull-right">' .
	//        '<i class="icon-file"></i> View Reviews</a>',
	//        $url);
 }
}
 
// download button
$url = $this->Html->url(array(
  'controller'=>'submissions',
  'action'=>'paper',
  'ext'=>'pdf',
  $submission['slug']), true);
printf('<a href="%s" class="pdf btn btn-danger pull-right">' .
       '<i class="icon-file"></i> View PDF</a>',
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
  $accepting = ($collection['accepting_submissions'] == 1);
  if($accepting)
    $links[] = $revise;
  $links[] = $finalize; // ***
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
<? if(($submission['category_id'] != '-1') && ($submission['category_id'] != '0')){ ?>
<p class="alert alert-info">
  <strong>Quick tip:</strong> You can view any reviews this paper has received
  by clicking the <strong>'Reviews'</strong> button above.
</p>
<? } } ?>

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
