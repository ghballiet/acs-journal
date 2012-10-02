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
?>

<div class="page-header">
  <ul class="nav nav-pills pull-right">
    <li>
      <a href="<? echo $this->Html->url(array('action'=>'status')); ?>">
        &larr; Return to List
      </a>
    </li>
  </ul>
  <h1>Review&nbsp;&nbsp;<small><? echo $title; ?></small></h1>
  <h4 class="authors"><? echo $auth_str; ?></h4>
  <div class="reviewer">
    <? echo $this->Profile->badge($review['User']); ?>
  </div>
</div>

<div class="row">
  <div class="span3" data-spy="affix">
    <div class="well">
      <h3>Metareview</h3>
    </div>
  </div>
  
  <div class="span9">
    <? foreach($questions as $question): ?>
    <div class="question">
      <div class="order"><? echo $question['Question']['position']; ?></div>
      <div class="question-text">
        <p class="text"><? echo $question['Question']['text']; ?></p>        
        <p class="answer">
          <strong>Answer:</strong>
          
        </p>
        <p class="comments">
          <strong>Comments:</strong>
        </p>
      </div>
    </div>
    <? endforeach; ?>
  </div>
</div>
