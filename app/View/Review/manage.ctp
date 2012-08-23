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

  $buttons = array();

  // edit review
  $edit_btn = $this->Html->link('Edit Review', array(
    'controller'=>'reviews',
    'action'=>'edit',
    $id
  ), array('class'=>'btn btn-mini btn-primary'));
  $buttons[] = $edit_btn;

  $buttons = implode('&nbsp;', $buttons);
  
  $cells = array($paper['title'], $review['User']['full_name'], $buttons);
  echo $this->Html->tableCells($cells);
}
?>
</table>