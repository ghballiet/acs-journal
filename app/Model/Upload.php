<?
class Upload extends AppModel {
  public $name = 'Upload';
  public $hasOne = array('Submission');
  public $belongsTo = array('User');
}
?>