<?
class SubmissionsController extends AppController {
  public $name = 'Submission';

  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function view($slug) {
    $this->Submission->slug = $slug;
    $submission = $this->Submission->read();
    pr($submission);
    $this->set('data', $submission);
  }

  public function edit($slug) {
    $this->Submission->slug = $slug;
    $submission = $this->Submission->read();
    $this->set('submission', $submission);
    if($this->request->is('get')) {
      $this->request->data = $submission;
    } else {
    }
  }

  public function paper($slug) {
    $this->autoRender = false;
    $this->Submission->slug = $slug;
    $submission = $this->Submission->read();
    $paper = $submission['Paper'];
    $this->set('title_for_layout', $submission['Submission']['title']);

    $this->response->type($paper['type']);
    $this->response->body($paper['content']);
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
          'Error!',
          sprintf('The file you uploaded - <strong>%s</strong> - was not ' . 
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

      // now, create the slug and save
      $title = $submission['Submission']['title'];
      $id = $submission['Submission']['id'];
      $title = strtolower(trim($title));
      $slug = preg_replace('/\W+/', '', $title);
      $slug = str_replace(' ', '-', $title);
      $slug = sprintf('%d-%s', $id, $slug);
      $submission['Submission']['slug'] = $slug;
      $this->Submission->save($submission);

      // build the coauthors
      $ca = array();
      foreach($coauthors as $i=>$coauthor) {
        $coauthor['submission_id'] = $submission['Submission']['id'];
        $coauthor = array('Coauthor' => $coauthor);
        $this->Submission->Coauthor->create();
        $this->Submission->Coauthor->save($coauthor);
      }
      
      // success!
      $this->alertSuccess(
        'Success!', sprintf('<strong>%s</strong> was successfully submitted.',
                            $submission['Submission']['title']));
      // $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
    }
  }
}
?>