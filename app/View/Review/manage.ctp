<div class="page-header">
  <h1>Manage Reviews</h1>
</div>

<table class="table condensed">
  <tr>
    <th>Title</th>
    <th>Author</th>
    <th>Assigned To</th>
    <th>Answers</th>
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

  $user_id = $review['Submission']['user_id'];
  $name = $user_list[$user_id];
  $sub_id = $review['Submission']['id'];

  $authors = array($name);

  if(isset($coauthors[$sub_id])) {
    foreach($coauthors[$sub_id] as $k=>$v)
      $authors[] = $v;
  }

  $author_str = implode(', ', $authors);

  $buttons = implode('&nbsp;', $buttons);

  $num_answers = count($review['Answer']);
  
  $cells = array(
    $paper['title'],
    $author_str,
    $review['User']['full_name'],
    $num_answers,
    $buttons
  );
  echo $this->Html->tableCells($cells);
}
?>

<tr>
  <td colspan="5">&nbsp;</td>
</tr>

<?
foreach($reviews as $review) {
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

  $user_id = $review['Submission']['user_id'];
  $name = $user_list[$user_id];
  $sub_id = $review['Submission']['id'];

  $authors = array($name);

  if(isset($coauthors[$sub_id])) {
    foreach($coauthors[$sub_id] as $k=>$v)
      $authors[] = $v;
  }

  $author_str = implode(', ', $authors);

  $buttons = implode('&nbsp;', $buttons);

  $num_answers = count($review['Answer']);
  
  $cells = array(
    $paper['title'],
    $author_str,
    $review['User']['full_name'],
    $num_answers,
    $buttons
  );
  echo $this->Html->tableCells($cells);
}
?>
</table>
