<?
echo $this->start('css');
echo $this->Html->css('view-collection');
echo $this->end();

echo $this->start('scripts');
echo $this->Html->script('view-collection');
echo $this->Html->script('assign-reviewers');
echo $this->end();

echo $this->Breadcrumb->html(array(
  array(
    'link' => array('controller'=>'collections', 'action'=>'manage'),
    'text' => 'Collections'
  )
), $collection['Collection']['title']);
?>

<div class="page-header">
  <h1>
<? echo $collection['Collection']['title']; ?>
    <small>
<? echo $collection['Collection']['subtitle']; ?>
    </small>
  </h1>
</div>

<ul id="tab-headers" class="nav nav-tabs">
  <li class="active"><a href="#submissions" data-toggle="tab">Submissions</a></li>
<? if($user_role == 'site_admin' || $user_role == 'admin'): ?>
  <li><a href="#roles" data-toggle="tab">Roles</a></li>
  <li><a href="#review-form" data-toggle="tab">Review Form</a></li>
<?
  endif;
  if(count($submissions) > 0) {
?>
  <li><a href="#assign-reviewers" data-toggle="tab">Assign Reviewers</a></li>
<?
  }
?>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="submissions">
    <h2>Submissions</h2>
<?
if(count($submissions) == 0) {
  echo '<p class="alert alert-info">There are no submissions for this collection.</p>';
} else {
?>
    <table class="table condensed">
<?
  echo $this->Html->tableHeaders(array(
    'Order', 'Title', 'Author', 'Modified', ''
  ));

  foreach($submissions as $submission) {
		$id = $submission['Submission']['id'];
    $title = $submission['Submission']['title'];
    $slug = $submission['Submission']['slug'];
    $author = $this->Profile->name($submission['User']);
    $order = $submission['Submission']['order'];
    $modified = $submission['Submission']['modified'];
    $modified = $this->Time->timeAgoInWords($modified);
    $pdf = $this->Html->link('PDF', array(
      'controller'=>'submissions',
      'action'=>'paper', 
      'ext'=>'pdf',
      $slug
    ), array('class'=>'btn btn-mini btn-danger'));
    $abstract = $this->Html->link('Abstract', array(
      'controller'=>'submissions',
      'action'=>'view',
      $slug
    ), array('class'=>'btn btn-mini'));
		$review = $this->Html->link('Reviews', array(
			'controller'=>'submissions',
			'action'=>'reviews',
			$id
		), array('class'=>'btn btn-mini'));

		if ($user['is_admin'] == '1') {
			$buttons = array($pdf, $abstract, $review);
		}
		else
			$buttons = array($pdf, $abstract);

    $buttons = implode('&nbsp;', $buttons);

    echo $this->Html->tableCells(array($order, $title, $author, $modified, $buttons));
  }
?>
    </table>
<?
}
?>
  </div>
  
  <div class="tab-pane" id="roles">
    <h2>Roles</h2>
    <table class="table condensed">
<?
echo $this->Html->tableHeaders(array(
  'Name', 'Email', 'Role', ''
));

foreach($roles as $role) {
  $name = $role['User']['full_name'];
  $email = $role['User']['email'];
  $type = $role['RoleType']['name'];
  $role_id = $role['Role']['id'];
  $role_type_id = $role['RoleType']['id'];
  $user_id = $role['User']['id'];
  $max_reviews = $role['Role']['max_reviews'];

  $change_role_urls = array();

  foreach($role_types as $role_type) {
    $id = $role_type['RoleType']['id'];
    $role_name = $role_type['RoleType']['name'];
    $link = array(
      'controller'=>'collections',
      'action'=>'assign_role',
      'user'=>$user_id,
      'role'=>$role_id,
      'type'=>$id,
      // not sure if there is a way to edit the max_reviews - CM
      // 'max_reviews'=>$max_reviews 
    );
    $item = array(
      'text' => $role_name, 
      'link' => $link
    );
    
    $change_role_urls[] = $item;
  }

  $change_role_btn = $this->Bootstrap->dropdownBtn(
    $type, $change_role_urls, 'btn-mini btn-inverse'
  );

  $remove_btn = $this->Html->link(
    'Delete Role',
    array('action'=>'remove_role', 'id'=>$role_id),
    array('class'=>'btn btn-danger btn-mini'),
    'Are you sure you want to delete this role? This cannot be undone.');

  $buttons = array($remove_btn);
  $buttons = implode('&nbsp;', $buttons);
    

  echo $this->Html->tableCells(array(
    $name, $email, $change_role_btn, $buttons
  ));
}
?>
    </table>
    <hr />
    <h2>Assign New Role</h2>
<?
echo $this->BootstrapForm->create('Collection', array('action'=>'assign_role'));
echo $this->BootstrapForm->input('user', array('type'=>'text'));
echo $this->BootstrapForm->input('role_type', array('options'=>$role_type_list));
// Set the maximum number of reviews assignable for a given role. 
// This shouldn't have to be filled out for all types but I wasn't
// sure what the best way to disable the field would be. - CM
// Also, should have a maximum value of the collections max_submissions_per
// reviewer, which I couldn't remember how to add -CM
echo $this->BootstrapForm->input('max_reviews', array(
    'label'=>'Maximum number of reviews assignable', 
    'default'=>3));
echo $this->BootstrapForm->input(
  'collection_id',
  array(
    'type'=>'hidden',
    'value'=>$collection['Collection']['id']
  )
);
echo $this->BootstrapForm->end('Assign Role');
?>    
  </div>

  <div class="tab-pane" id="review-form">
<?
/*
echo $this->Html->link(
  'Add Question',
  array(
    'controller'=>'questions',
    'action'=>'add',
    $review_form['ReviewForm']['id']
  ),
  array(
    'class' => 'btn btn-primary pull-right'
  )
  );
*/
?>    
    <h2>Review Form</h2>
    <div class="question hidden question-template">
      <a href="#" data-id="" class="btn-delete btn-delete-question close">&times;</a>
      <div class="order"></div>
      <div class="question-text">
        <p class="text"></p>
        <ul class="answers">
          <li class="answer">
            <input type="radio" class="radio" disabled="disabled"/>
            <input type="text" class="text" name="choice" data-id=""
                   placeholder="Type answer here."/>
            <a href="#" class="btn btn-add">Save</a>
          </li>
        </ul>
      </div>
      <div class="clearfix"></div>
    </div>
<?
$add_choice_url = $this->Html->url(array('controller'=>'choices', 'action'=>'addJson'));
$delete_choice_url = $this->Html->url(array('controller'=>'choices', 'action'=>'deleteJson'));
$add_question_url = $this->Html->url(array('controller'=>'questions', 'action'=>'addJson'));
$delete_question_url= $this->Html->url(
  array('controller'=>'questions', 'action'=>'deleteJson'));
printf('<input type="hidden" class="add-choice-url" value="%s" />', $add_choice_url);
printf('<input type="hidden" class="delete-choice-url" value="%s" />', $delete_choice_url);
printf('<input type="hidden" class="add-question-url" value="%s" />', $add_question_url);
printf('<input type="hidden" class="delete-question-url" value="%s" />',
       $delete_question_url);
echo '<div class="questions">';

if(count($questions) == 0) {
   echo '<p class="alert alert-info">No questions have been added to this review form.</p>';
} else {

  foreach($questions as $question) {
    // choices should be managed here. 
    $id = $question['Question']['id'];
    $text = $question['Question']['text'];
    $order = $question['Question']['position'];
    
    echo '<div class="question">';
    printf('<a href="#" data-id="%s" class="btn-delete btn-delete-question close">&times;</a>',
           $id);
    printf('<div class="order">%s</div>', $order);
    
    echo '<div class="question-text">';
    printf('<p class="text">%s</p>', $text);

    echo '<ul class="answers">';
    
    // answer radio buttons
    foreach($question['Choice'] as $choice) {
      echo '<li class="answer">';
      printf('<a href="#" data-id="%s" class="btn-delete btn-delete-choice close">&times;</a>',
             $choice['id']);
      echo '<input type="radio" class="radio" disabled="disabled"/>';
      printf('<span>%s</span>', $choice['text']);
      echo '</li>';
    }

    // add answer radio button
    echo '<li class="answer">';
    echo '<input type="radio" class="radio" disabled="disabled"/>';
    printf('<input type="text" class="text" name="choice" data-id="%s" ' .
           'placeholder="Type answer here."/>', $id);
    echo $this->Html->link('Save', '#', array('class'=>'btn btn-add'));
    echo '</li>';
    
    echo '</ul>'; // end of answers

    echo '</div>'; // end of question-text

    echo '<div class="clearfix"></div>';
    echo '</div>';
  }
}

echo '</div>'; // end of questions
?>    
    <div class="add-question question">
      <h2>Add Question</h2>
      <input type="hidden" class="review-form-id"
             value="<? echo $review_form['ReviewForm']['id']; ?>" />
      <div class="order">
        <input name="order" type="number" min="1" placeholder="#" class="new-order"
               value="<? echo count($questions) + 1; ?>"/>
      </div>
      <div class="question-text">
        <textarea name="question" class="new-question"
                  placeholder="Enter a question here."></textarea>
        <a href="#" class="btn btn-primary btn-add-question">Add Question</a>
      </div>
    </div>
  </div>


<?

$assign_url = $this->Html->url(array('controller'=>'reviews', 'action'=>'createJson'));
$unassign_url = $this->Html->url(array('controller'=>'reviews', 'action'=>'deleteJson'));
printf('<input type="hidden" class="assign-url" value="%s" />', $assign_url);
printf('<input type="hidden" class="unassign-url" value="%s" />', $unassign_url);
?>

  <div class="tab-pane" id="assign-reviewers">
    <h2>Assign Reviewers</h2>
    <div class="navbar navbar-fixed-top hidden">
      <div class="navbar-inner">
        <div class="container">
          <p class="navbar-text">This is some text.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="span5 review-users">
        <h4>Eligible Reviewers</h4>
        <div class="active-users"></div>
<?
foreach($roles as $role) {
  $type = $role['RoleType'];
  if($type['can_review'] != 1)
    continue;

  $id = $role['User']['id'];  
  $reviews = array();
  $num_reviews = 0;

  if(isset($review_counts[$id])) {
    $reviews = $review_counts[$id];
    $num_reviews = count($reviews);
  }
  
  // not eligible if the user has reached their max - CM
  // this should be fixed so that the user simply cannot be assigned
  // additional reviews. 
  // if($num_reviews >= $role['Role']['max_reviews'])
  //   continue;

  echo $this->Profile->badge($role['User'], (string)$num_reviews);
}

// create the javascript variable
$this->start('scripts');
$js_user_reviews = json_encode($review_counts, true);
$js_sub_reviews = json_encode($submission_reviews, true);

if($js_user_reviews == '[]')
  $js_user_reviews = '{}';

if($js_sub_reviews == '[]')
  $js_sub_reviews = '{}';
?>
<script type="text/javascript">
  var user_reviews = <? echo $js_user_reviews; ?>;
  var submission_reviews = <? echo $js_sub_reviews; ?>;
</script>
<?
$this->end();
?>
      </div>
      <div class="span7 review-submissions">
        <h4>Submissions</h4>
        <div class="active-submissions"></div>
<?
foreach($submissions as $submission) {
  echo $this->Submission->badge($submission);
}
?>
      </div>
    </div>
  </div>
</div>

<? echo $this->start('scripts'); ?>
<script type="text/javascript">
var user_list = <? echo json_encode(array_values($users)); ?>;
$(document).ready(function() {
  $('#CollectionUser').typeahead({
    source: user_list
  });

  // switch to active tab
  var hash = window.location.hash;
  $('#tab-headers a[href="' + hash + '"]').tab('show');
});
</script>
<? echo $this->end(); ?>
