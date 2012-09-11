<div class="page-header">
  <h1>Manage Reviews</h1>
</div>

<table class="table condensed">
  <tr>
    <th>Title</th>
    <th>Author</th>
    <th></th>
  </tr>
<?
foreach($user_reviews as $review) {
  $paper = $review['Submission'];
  $id = $review['Review']['id'];
  $slug = $review['Submission']['slug'];

  $abstract = $this->Html->link(
      'Abstract',
      array(
          'controller' => 'submissions',
          'action' => 'view',
          $slug
      ),
      array(
          'class' => 'btn btn-mini'
      )
  );

  $pdf = $this->Html->link(
      'PDF',
      array(
          'controller' => 'submissions',
          'action' => 'paper',
          $slug
      ),
      array(
          'class' => 'btn btn-mini btn-danger'
      )
  );

  $buttons = array();

  // edit review
  $edit_btn = $this->Html->link('Review', array(
    'controller'=>'reviews',
    'action'=>'edit',
    $id
  ), array('class'=>'btn btn-mini btn-primary'));

  $buttons[] = $pdf;
  $buttons[] = $abstract;
  $buttons[] = $edit_btn;

  $buttons = implode('&nbsp;', $buttons);
  
  $cells = array($paper['title'], $review['User']['full_name'], $buttons);
  echo $this->Html->tableCells($cells);
}
?>
</table>