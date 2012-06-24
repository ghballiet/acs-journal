<?
class Collection extends AppModel {
  public $name = 'Collection';
  public $hasMany = array('Submission', 'Category', 'Role');
}
?>