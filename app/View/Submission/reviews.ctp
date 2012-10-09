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

	//print_r($submission);
$user_id = $submission['Submission']['user_id'];
$sub_id = $submission['Submission']['id'];
$user_name = $user_list[$user_id];
$authors = array($user_name);

// grab the coauthors
if(isset($coauthors[$sub_id])) {
  foreach($coauthors[$sub_id] as $k=>$v)
    $authors[] = $v;
}

$auth_str = implode(', ', $authors);

$title = $submission['Submission']['title'];
$slug = $submission['Submission']['slug'];
?>

<div class="page-header">
  <ul class="nav nav-pills pull-right">
    <li>
      <a href="<? echo $this->Html->url(array('controller'=>'Collections',
									'action'=>'view', $submission['Collection']['slug'])); ?>">
        <i class="icon-chevron-left" style="margin-right: 10px;"></i>Return to List
      </a>
    </li>
  </ul>
  <h1>Review&nbsp;&nbsp;<small><? echo $title; ?></small></h1>
  <h4 class="authors"><? echo $auth_str; ?></h4>
	<h3>Metareviewers:</h3>
  <div class="reviewer">
		<? //print_r($reviews); ?>
		<? foreach ($reviews as $review) {	
			if($review['Role']['role_type_id'] != 3)
    		echo $this->Profile->badge($review['User']);
		} ?>
  </div>
	<h3>Reviewers:</h3>
  <div class="reviewer">
		<? foreach ($reviews as $review) {	
			if($review['Role']['role_type_id'] == 3)
    		echo $this->Profile->badge($review['User']);
		} ?>

  </div>
</div>

<h3>Metareviews</h3>
<div class="question"> 
	<div class="question-text">
		<? foreach ($metareviews as $metareview){ ?>
			<p class="text"><? echo $metareview['Question']['text']; ?></p>
			<p class="answer">
				<? echo $this->Profile->badge($metareview['User']); ?>
				<strong>Answer:</strong>
				<? echo $metareview['Choice']['text']; ?>
			</p>
			<p class="comments">
				<strong>Comments:</strong>
				<? echo $metareview['Metareview']['content']; ?>
			</p>
		<? } ?>
		<? if (empty($metareviews)) {?>
	    <p class="alert alert-error">Metareview has not been completed.</p>
			<? } ?>
	</div>
</div>

<h3>Reviews</h3>
<? foreach($questions as $question): ?>
<div class="question">
  <div class="order"><? echo $question['Question']['position']; ?></div>
  <div class="question-text">
    <p class="text"><? echo $question['Question']['text']; ?></p>        
		<? foreach ($reviews as $review) {?>
			<? if($review['Role']['role_type_id'] == 3) {?>
				<? //print_r($review['Answers']); ?>
				<? //print_r($question['Question']['id'])?>
				<? echo $this->Profile->badge($review['User']); ?>
				<div style="padding-left:25px">
				<? if(isset($review['Answers'][$question['Question']['id']])): ?>
		    <? //if(isset($answers[$question['Question']['id']])): ?>
		    <p class="answer">
		      <strong>Answer:</strong>

					<? echo $review['Answers'][$question['Question']['id']]['Choice']['text'];?>
		      <? //echo $answers[$question['Question']['id']]['Choice']['text']; ?>
		    </p>
		    <p class="comments">
		      <strong>Comments:</strong>
					<? echo $review['Answers'][$question['Question']['id']]['Answer']['comments']; ?>
		      <? //echo $answers[$question['Question']['id']]['Answer']['comments']; ?>
		    </p>
		    <? else: ?>
		    <p class="alert alert-error"><? echo $review['User']['full_name']; ?> has not answered this question.</p>
				<? endif; ?>
				</div> <!-- End text-indent div -->
				<? } // ends if?>
		<? } // ends foreach?>
  </div>
</div>
<? endforeach; ?>
</div>
