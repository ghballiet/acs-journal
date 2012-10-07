<?
class Metareview extends AppModel {
  public $name = 'Metareview';
  public $belongsTo = array('Submission', 'User', 'Collection', 'Question', 'Choice');
}
?>