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

$review_id = $review['Review']['id'];
$review_form_id = $review['ReviewForm']['id'];

printf('<input type="hidden" class="save-url" value="%s"/>', $save_url);
printf('<input type="hidden" class="review-id" value="%s" />', $review_id);
printf('<input type="hidden" class="review-form-id" value="%s" />', $review_form_id);
printf('<input type="hidden" class="user-id" value="%s" />', $user['id']);

$title = $review['Submission']['title'];
?>

<div class="page-header">
  <h1>Review&nbsp;&nbsp;<small><? echo $title; ?></small></h1>
  <h4 class="authors"><? echo $auth_str; ?></h4>
</div>

<p>
  Give reasons that support your answers rather than simply checking
  boxes. Your responses and comments will be saved automatically.
</p>

<hr />

<?
foreach($questions as $question) {
  $id = $question['Question']['id'];  
  $choices = $question['Choice'];
  $text = $question['Question']['text'];
  $order = $question['Question']['position'];
  $answer = null;
  $choice_id = null;
  $comments = null;
  if(isset($answers[$id])) {
    $answer = $answers[$id];
    $choice_id = key($answer);
    $comments = $answer[$choice_id];
  }
  
  printf('<div class="question" data-id="%d" id="question-%d">', $id, $id);
  printf('<div class="order">%s</div>', $order);
  echo '<div class="question-text">';
  printf('<p class="text">%s</text>', $text);
  
  // list the choices
  echo '<ul class="answers">';
  
  foreach($choices as $choice) {
    echo '<li class="answer">';
    printf('<input type="radio" class="radio" name="question-%d" value="%d" id="choice-%d" data-question="%d" data-id="%d"',
      $id, $choice['id'], $choice['id'], $id, $choice['id']);
      
    if($choice_id == $choice['id'])
      echo ' checked="checked"';

    if(!$editable)
      echo ' disabled';
              
    echo '/>'; // end input
    printf('<label for="choice-%d">%s</label>', $choice['id'], $choice['text']);
    echo '</li>';
  }

  echo '</ul>'; // end answers
  
  // show the comments textarea

  printf('<textarea name="question-%s" data-question-id="%d" placeholder="Type your comments here." %s',
         $id, $id, $editable ? null : 'disabled="disabled" ');

  if(count($choices) == 0) {
    echo 'class="full">';
  } else {
    echo '>';
  }

  echo $comments;
  echo '</textarea>';
  echo '<div class="clearfix"></div>';

  echo '</div>'; // end question-text
  echo '</div>'; // end question
}
?>
