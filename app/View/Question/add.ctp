<?
echo $this->Breadcrumb->html(array(
  array(
    'link' => array('controller'=>'collections', 'action'=>'manage'),
    'text' => 'Collections'
  ),
  array(
    'link' => array(
      'controller'=>'collections',
      'action'=>'view',
      $collection_slug,
      '#' => 'review-form'
    ),
    'text' => $collection_title
  )
), 'Add Question');
?>

<div class="page-header">
  <h1>Add Question
    <small><? echo $collection_title; ?></small>
  </h1>
</div>

<?
echo $this->BootstrapForm->create('Question');
echo $this->BootstrapForm->input('text', array('autofocus'=>true));
echo $this->BootstrapForm->input('position', array('value'=>1));
echo $this->BootstrapForm->end('Add Question');
?>