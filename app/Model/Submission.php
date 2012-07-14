<?
class Submission extends AppModel {
  public $name = 'Submission';
  public $belongsTo = array(
    'User', 'Category', 'Collection',
    'Paper' => array(
      'className' => 'Upload',
      'foreignKey' => 'current_version'
    ),
    'Final' => array(
      'className' => 'Upload',
      'foreignKey' => 'final_version'
    ),
    'Previous' => array(
      'className' => 'Submission',
      'foreignKey' => 'previous_submission'
    )
  );

  public $hasMany = array('Keyword', 'Coauthor');
}
?>