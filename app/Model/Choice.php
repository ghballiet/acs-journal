<?
class Choice extends AppModel {
  public $name = 'Choice';
  public $belongsTo = array('Question');
  public $hasMany = array('Answer', 'Metareview');
}
?>