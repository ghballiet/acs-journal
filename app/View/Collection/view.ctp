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
  <li><a href="#users" data-toggle="tab">Users</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="submissions">
    <h2>Submissions</h2>
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
  </div>
  
  <div class="tab-pane" id="users">
    <h2>Users</h2>
    <table class="table condensed">
<?
echo $this->Html->tableHeaders(array(
  'Name', 'Email', 'Role'
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

  echo $this->Html->tableCells(array(
    $name, $email, $change_role_btn
  ));
}
?>
    </table>

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
</div>

<? echo $this->start('scripts'); ?>
<script type="text/javascript">
var user_list = <? echo json_encode(array_values($users)); ?>;
$(document).ready(function() {
  $('#CollectionUser').typeahead({
    source: user_list
  });
});
</script>
<? echo $this->end(); ?>
