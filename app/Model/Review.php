<?
class Review extends AppModel {
  public $name = 'Review';
  public $belongsTo = array('User', 'Submission', 'ReviewForm');
  public $hasMany = array('Answer');
}
?>