<?
class Question extends AppModel {
  public $name = 'Question';
  public $belongsTo = 'ReviewForm';
  public $hasMany = array('Choice', 'Answer');
}
?>