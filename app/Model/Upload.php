<?
class Upload extends AppModel {
  public $name = 'Upload';
  public $hasOne = array(
		'Submission' => array(
      'className' => 'Submission',
      'foreignKey' => 'current_version'
		)
	);
  public $belongsTo = array('User');
}
?>