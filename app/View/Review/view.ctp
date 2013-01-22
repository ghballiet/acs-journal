<?
$this->start('css');
echo $this->Html->css('edit-review');
$this->end();

$this->start('scripts');
echo $this->Html->script('edit-review');
$this->end();

$save_url = $this->Html->url(array(
  'controller'=>'answers',
  'action'=>'saveJson'
));

$user_id = $review['Submission']['user_id'];
$sub_id = $review['Submission']['id'];
$user_name = $user_list[$user_id];
$authors = array($user_name);

// grab the coauthors
if(isset($coauthors[$sub_id])) {
  foreach($coauthors[$sub_id] as $k=>$v)
    $authors[] = $v;
}

$auth_str = implode(', ', $authors);

$title = $review['Submission']['title'];
$slug = $review['Submission']['slug'];
?>


<?
// This tag should be used to screen so that the only people who can see a review are
// (a) The reviewer
// (b) An editor assigned to the paper being reviewed
// (c) Any admin.
// - BM

// The following code is partly based on manage() from ReviewsController.
// But I don't know how to access that properly.
/*
    $user_role = $this->ReviewsController->Review->User->Role->find('first', array(
      'conditions' => array(
        'Role.collection_id' => 3,
        'Role.user_id' => $this->Auth->user('id'))));
    if(	$user['is_admin'] == 1 ||
		$user_id == $user['id'] ||
		$user_role['RoleType']['name'] == 'editor' ||
		$user_role['RoleType']['name'] == 'admin' ||
		$user_role['RoleType']['name'] == 'site_admin'){
*/
// For now, though, don't screen anything.
if(true){
?>


<div class="page-header">
  <ul class="nav nav-pills pull-right">
    <li>
      <a href="<? echo $this->Html->url(array('action'=>'status', '#'=>$slug)); ?>">
        <i class="icon-chevron-left" style="margin-right: 10px;"></i>Return to List
      </a>
    </li>
  </ul>
  <h1>Review&nbsp;&nbsp;<small><? echo $title; ?></small></h1>
  <h4 class="authors"><? echo $auth_str; ?></h4>
  <div class="reviewer">
    <? echo $this->Profile->badge($review['User']); ?>
  </div>
</div>

<? foreach($questions as $question): ?>
<div class="question">
  <div class="order"><? echo $question['Question']['position']; ?></div>
  <div class="question-text">
    <p class="text"><? echo $question['Question']['text']; ?></p>        
    <? if(isset($answers[$question['Question']['id']])): ?>
    <p class="answer">
      <strong>Answer:</strong>
      <? echo $answers[$question['Question']['id']]['Choice']['text']; ?>
    </p>
    <p class="comments">
      <strong>Comments:</strong>
      <? echo $answers[$question['Question']['id']]['Answer']['comments']; ?>
    </p>
    <? else: ?>
    <!-- <p class="alert alert-error"><? echo $review['User']['full_name']; ?> has not answered this question.</p> -->
    <? endif; ?>
  </div>
</div>
<? endforeach; ?>
</div>

<? } ?>

