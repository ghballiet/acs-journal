<?
class ReviewForm extends AppModel {
  public $name = 'ReviewForm';
  public $belongsTo = 'Collection';
  public $hasMany = array('Question', 'Review', 'Answer');
}
?>