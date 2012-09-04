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
    ),
    'Next' => array(
      'className' => 'Submission',
      'foreignKey' => 'next_submission'
    )
  );
  public $hasMany = array('Keyword', 'Coauthor', 'Review');

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

  public function revisedEmail($id, $url) {
    $submission = $this->findById($id);
    $submission['url'] = $url;
    $email = new CakeEmail();
    $email->template('revision', 'default');
    $email->emailFormat('html');
    $email->to($submission['User']['email']);
    $email->subject('Your Revision Was Received');
    $email->from('acs@cogsys.org');
    $email->viewVars($submission);
    $email->send();
  }

  public function getCurrent($conditions = array()) {
    $opts = array(
      'conditions' => array(
        'Submission.id = Submission.next_submission',
        'Submission.retracted' => 0
      ),
      'order' => array('Submission.title')
    );

    foreach($conditions as $key=>$value)
      $opts['conditions']['Submission.' . $key] = $value;
    
    return $this->find('all', $opts);
  }

  public function updateReviews($old_id, $new_id) {
    // update submission numbers for reviews
    $reviews = $this->Review->findAllBySubmissionId($old_id);
    
    foreach($reviews as $item) {
      $item['Review']['submission_id'] = $new_id;
      $this->Review->save($item);
    }
  }

  public function nextOrder($id) {
    $options = array(
      'fields' => array('MAX(Submission.order) AS `order`'),
      'group' => 'Submission.collection_id',
      'conditions' => array('Submission.collection_id'=>$id)
    );

    $data = $this->find('first', $options);
    if(empty($data))
      return 1;
    else
      return intval($data[0]['order']) + 1;
  }

  public function beforeSave() {
    $coll_id = $this->data['Submission']['collection_id'];
    $coll = $this->Collection->findById($coll_id);
    $order = $this->data['Submission']['order'];

    // update the slug
    $volume = $coll['Collection']['volume'];
    $slug = sprintf('paper-%d-%d-%d', $coll_id, $volume, $order);
    $this->data['Submission']['slug'] = $slug;

    return true; 
  }
}
?>