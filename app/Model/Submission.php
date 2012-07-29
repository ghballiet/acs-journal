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

  public function createEmail($id, $url) {
    $submission = $this->findById($id);
    $submission['url'] = $url;
    $email = new CakeEmail();
    $email->template('submission', 'default');
    $email->emailFormat('html');
    $email->to($submission['User']['email']);
    $email->subject('Your Submission Was Received');
    $email->from('acs@cogsys.org');
    $email->viewVars($submission);
    $email->send();
  }
}
?>