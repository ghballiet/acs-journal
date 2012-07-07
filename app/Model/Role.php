<?
class Role extends AppModel {
  public $name = 'Role';
  public $belongsTo = array('Collection', 'RoleType', 'User');
}
?>