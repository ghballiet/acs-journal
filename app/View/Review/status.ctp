<div class="page-header">
  <h1>Manage Reviews</h1>
</div>

<p class=" alert alert-info">
  Click the paper title to see reviews. 
</p>

<div class="accordion" id="reviews">
  <? foreach($papers as $slug=>$reviews): ?>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#reviews" href="#<? echo $slug; ?>">
        <? echo sprintf('<span class="pull-right">%s</span> %s', $authors[$slug]['full_name'], $titles[$slug]); ?>
      </a>
    </div>
    <div class="accordion-body collapse" id="<? echo $slug; ?>">
      <div class="accordion-inner">
        <!-- metareview form -->
        <?
echo $this->BootstrapForm->create('Metareview', array(
  'controller'=>'metareviews', 'action'=>'create'));
$content = null;
$categ = '-1';
if(isset($metareviews[$slug])) {
  echo $this->BootstrapForm->input(
    'id',
    array(
      'value'=>$metareviews[$slug]['id'],
      'type'=>'hidden'));
  $content = $metareviews[$slug]['content'];
  $categ = $metareviews[$slug]['category_id'];
  // BM 18 Jan:
  /*echo $this->BootstrapForm->input(
    'choice_id',
    array(
      //'value'=>$metareviews[$slug]['choice_id'],
	  'value'=>$metareviews[$Choice]['category_id'],
      'type'=>'hidden'));*/
}

echo $this->BootstrapForm->input('user_id', array(
  'value'=>$user['id'],
  'type'=>'hidden'));
$rev = array_values($reviews);
$sub_id = $rev[0]['Submission']['id'];
$coll_id = $rev[0]['Submission']['collection_id'];

echo $this->BootstrapForm->input('submission_id', array(
  'value'=>$sub_id,
  'type'=>'hidden'));
echo $this->BootstrapForm->input('collection_id', array(
  'value'=>$coll_id,
  'type'=>'hidden'));

echo '<p>';
echo $question['Question']['text'];
echo '</p>';

$qid = $question['Question']['id'];

if(!isset($metareviews[$slug]))
  $metareviews[$slug] = array('choice_id'=>'-1');

echo $this->BootstrapForm->input(
  'question_id',
  array(
    'value' => $qid,
    'type' => 'hidden'
  ));
  
/*echo $this->BootstrapForm->input(
  'choice_id',
  array(
    'value' => $categ,
    'type' => 'hidden'
  ));*/

  
    
foreach($question['Choice'] as $i=>$choice) {
  echo '<label class="radio">';
  echo '<input type="radio" name="data[Metareview][category_id]"';
  //echo '<input type="radio" name="data[Metareview][choice_id]"';
  printf('id="choice-%d" value="%d"', $choice['id'], $choice['id']);
  /* There's something strange here.
  ___________________________________________________________________________________
  |     CATEGORY     |  $choice['id']  |  $categ  |  $choice['text']				|
  | uncategorized    |                 |  '-1'    |									|
  | talk             |    '51'         |  '1'     | 'Accept as talk'				|
  | condition        |    '52'         |  '2'     | 'Accept conditionally as talk'	|
  | poster           |    '53'         |  '3'     | 'Accept as poster'				|
  | major revisions  |     ?           |  '4'     |	'Accept with major revisions'	|
  | reject           |    '54'         |  '5'     | 'Reject'						|
  |_________________________________________________________________________________|
  */
  //if($choice['id'] == $metareviews[$slug]['choice_id']) ORIGINAL
  //if($choice['id'] == $metareviews[$Choice]['category_id']) //BM
  //if($choice['id'] == $categ) BM
  if($choice['id'] == $metareviews[$slug]['category_id'])
  /* if(
      (($categ == '-1') && ($choice['text'] == 'Uncategorized')) ||
	  (($categ == '1') && ($choice['text'] == 'Accept as talk')) ||
	  (($categ == '2') && ($choice['text'] == 'Accept conditionally as talk')) ||
	  (($categ == '3') && ($choice['text'] == 'Accept as poster')) ||
	  (($categ == '4') && ($choice['text'] == 'Accept with major revisions')) ||
	  (($categ == '5') && ($choice['text'] == 'Reject'))
	 )*/
	 {
		echo 'checked="checked"';
	 }
  echo '>';
  echo $choice['text'];
  
/*$question['Answer']['choice_id']) = $choice['id'];
 foreach($question['Answer'] as $j=>$answer) {
	$ans = $answer['choice_id'];
	if($ans == $choice['id'])*/
  
  
  /*
  
  //$foo3 = $question['Choice']; // 0 1 2 3
  //$foo4 = $question['Answer']; // 0 1 2 3 4 5 6 7
  //if($choice['id'] == $question['Answer']['choice_id']){
//		something = ?
 // }
 $question['Answer']['choice_id']) = $choice['id'];
 
 
 foreach($question['Answer'] as $j=>$answer) {
	$ans = $answer['choice_id'];
	if($ans == $choice['id'])
		echo 'checked="checked"';
}
  echo '>';
  echo $choice['text'];
  */
  
  //echo '|';  echo $choice['id'];  echo '|';  echo $categ;  echo '|';
  echo '</label>';
}

  
echo $this->BootstrapForm->input('content', array(
  'label'=>'Metareview',
  'placeholder'=>'Enter your overall impression of this paper here, based ' . 
  'on the reviews given below.',
  'value'=>$content));
echo $this->BootstrapForm->end('Submit Metareview');
        ?>
        

        <? foreach($reviews as $id=>$review): ?>
        <?
        $progress = count($review['Answer']) / $questions * 100;
        $remaining = 100 - $progress;
        ?>
        <a href="<? echo $this->Html->url(array('action'=>'view', $id), true);?>" class="btn btn-primary pull-right">
          View Review<i class="icon-chevron-right" style="margin-left:10px"></i>
        </a>
        <? echo $this->Profile->badge($review['User']); ?>       
        <? endforeach; ?>
      </div>
    </div>
  </div>
  <? endforeach; ?>
</div>

<? $this->start('scripts'); ?>
<script type="text/javascript">
$(document).ready(function() {
  if(window.location.hash != null)
    $(window.location.hash).collapse('show');
});
</script>
<? $this->end(); ?>
