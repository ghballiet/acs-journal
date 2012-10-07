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
if(isset($metareviews[$slug])) {
  echo $this->BootstrapForm->input(
    'id',
    array(
      'value'=>$metareviews[$slug]['id'],
      'type'=>'hidden'));
  $content = $metareviews[$slug]['content'];
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
