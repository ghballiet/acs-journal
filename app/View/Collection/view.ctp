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
  <li><a href="#roles" data-toggle="tab">Roles</a></li>
  <li><a href="#review-form" data-toggle="tab">Review Form</a></li>
  <li><a href="#assign-reviewers" data-toggle="tab">Assign Reviewers</a></li>
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

  $change_role_urls = array();

  foreach($role_types as $role_type) {
    $id = $role_type['RoleType']['id'];
    $role_name = $role_type['RoleType']['name'];
    $link = array(
      'controller'=>'collections',
      'action'=>'assign_role',
      'user'=>$user_id,
      'role'=>$role_id,
      'type'=>$id
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
echo $this->BootstrapForm->input('collection_id', array('type'=>'hidden', 
                                                        'value'=>$collection['Collection']['id']));
echo $this->BootstrapForm->end('Assign Role');
?>    
  </div>

  <div class="tab-pane" id="review-form">
<?
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
?>    
    <h2>Review Form</h2>
<?
if(count($questions == 0)) {
   echo '<p class="alert alert-info">No questions have been added to this review form.</p>';
} else {
}
?>    
  </div>

  <div class="tab-pane" id="assign-reviewers">
    <h2>Assign Reviewers</h2>
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
