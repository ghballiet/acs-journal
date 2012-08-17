<?
class Answer extends AppModel {
  public $name = 'Answer';
  public $belongsTo = array('Question', 'Choice', 'User', 'Review');
}
?>