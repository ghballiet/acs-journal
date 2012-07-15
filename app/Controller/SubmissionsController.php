<?
class SubmissionsController extends AppController {
  public $name = 'Submission';

  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function create() {
    $options = array('condition'=>array('Collection.accepting_submissions' => true));
    $collections = $this->Submission->Collection->find('list', $options);
    $this->set('collections', $collections);

    if($this->request->is('post')) {
      $data = $this->request->data;
      $submission = $data['Submission'];
      $upload = $submission['Upload'];
      $coauthors = $data['Coauthor'];

      // remove the upload from the submission data array
      unset($submission['Upload']);

      // first, make sure a PDF file was uploaded
      if($upload['type'] != 'application/pdf') {
        $this->alertError(
          'Error!', sprintf('The file you uploaded - <strong>%s</strong> - was not ' . 
                            'a PDF file. Please select a PDF and re-submit.', $upload['name']));
        return false;
      }
      
      // build the upload data
      $upload['content'] = file_get_contents($upload['tmp_name']);
      $upload['extension'] = pathinfo($upload['tmp_name'], PATHINFO_EXTENSION);
      $upload['user_id'] = $this->Auth->user('id');
      $upload = array('Paper' => $upload);

      // save the upload
      $this->Submission->Paper->create();
      $upload = $this->Submission->Paper->save($upload);

      // build the submission data
      $submission['user_id'] = $this->Auth->user('id');
      $submission['current_version'] = $upload['Paper']['id'];
      $submission = array('Submission' => $submission);

      // save the submission
      $this->Submission->create();
      $submission = $this->Submission->save($submission);

      // build the coauthors
      foreach($coauthors as $i=>$coauthor) {
        $coauthor['submission_id'] = $submission['Submission']['id'];
        $coauthors[$i] = $coauthor;
      }
      $coauthors = array('Coauthor' => $coauthors);
      
      // save the coauthors
      $coauthors = $this->Submission->Coauthor->saveMany($coauthors);

      // success!
      $this->alertSuccess(
        'Success!', sprintf('<strong>%s</strong> was successfully submitted to <strong>%s</strong>.',
                            $submission['Submission']['title'], $submission['Collection']['title']));
      // $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
    }
  }
}
?>