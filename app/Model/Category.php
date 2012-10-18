<?
class Category extends AppModel {
  public $name = 'Category';
  public $belongsTo = array('Collection');
  public $hasMany = array('Submission', 'Metareview');
}
?>