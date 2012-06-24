<?
class Paper extends AppModel {
  public $name = 'Paper';
  public $belongsTo = array('User');
  public $hasOne = array('Submission');
  public $hasMany = array('Keyword', 'Coauthor');
}
?>