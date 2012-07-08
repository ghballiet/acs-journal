<?
class SubmissionsController extends AppController {
  public $name = 'Submission';

  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function create($collection_id, $paper_id) {
    $collection = $this->Submission->Collection->findById($collection_id);
    $paper = $this->Submission->Paper->findById($paper_id);
    $this->set('collection', $collection);
    $this->set('paper', $paper);

    if($this->request->is('post')) {
      // TODO: create the submission, using the proper collection and
      // paper ids
    }
  }
}
?>