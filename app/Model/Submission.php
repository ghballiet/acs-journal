<?
class Submission extends AppModel {
  public $name = 'Submission';
  public $hasOne = array('Paper');
  public $belongsTo = array('Collection', 'Category');
}
?>