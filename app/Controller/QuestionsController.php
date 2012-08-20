<?
class QuestionsController extends AppController {
  public $name = 'Question';

  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function add($review_form_id = null) {
    // add a new question to the review form
    $form = $this->Question->ReviewForm->findById($review_form_id);
    $this->set('review_form', $form);
    $this->set('collection_title', $form['Collection']['title']);
    $this->set('collection_slug', $form['Collection']['slug']);
    $this->set('review_form_id', $review_form_id);

    if($this->request->is('get')) {
      // just viewing the page
    } else {
      // trying to add a question here
      $data = $this->request->data;
      $data['Question']['review_form_id'] = $review_form_id;
      if($question = $this->Question->save($data)) {
        $this->alertSuccess('Success!', 'Question succesfully added.', true);
        $this->redirect(array(
          'controller'=>'collections',
          'action'=>'view',
          $form['Collection']['slug'],
          '#'=>'review-form'
        ));
      } else {
        $this->alertError('Error!', 'Something went wrong. Please correct ' .
                          'all errors below and resubmit.');
      }
    }
  }

  public function addJson() {
    // add a new question via json
    $this->autoRender = false;
    if($this->request->is('post')) {
      if($question = $this->Question->save($this->request->data)) {
        echo json_encode(array('data' => $question, 'ok' => true));
      } else {
        echo json_encode(array('ok' => false));
      }
    }
  }

  public function deleteJson() {
    // delete a question via json
    $this->autoRender = false;
    if($this->request->is('post')) {
      $id = $this->request->data['Question']['id'];
      if($this->Question->delete($id)) {
        echo json_encode(array('ok'=>true));
      } else {
        echo json_encode(array('ok'=>false));
      }
    }
  }
}
?>