<?
class ReviewsController extends AppController {
  public $name = 'Review';

  public function beforeFilter() {
    parent::beforeFilter();
  }

  public function createJson() {
    $this->autoRender = false;
    if($this->request->is('post')) {
      if($review = $this->Review->save($this->request->data)) {
        $id = $review['Review']['id'];
        $review = $this->Review->findById($id);
        echo json_encode(array('data'=>$review, 'ok'=>true));
      } else {
        echo json_encode(array('ok'=>false));
      }
    }
  }

  public function deleteJson() {
    $this->autoRender = false;
    if($this->request->is('post')) {
      $user_id = $this->request->data['Review']['user_id'];
      $submission_id = $this->request->data['Review']['submission_id'];
      $review = $this->Review->findByUserIdAndSubmissionId($user_id, $submission_id);
      $review_id = $review['Review']['id'];
      if($this->Review->delete($review_id)) {
        echo json_encode(array('ok'=>true));
      } else {
        echo json_encode(array('ok'=>false));
      }
    }
  }

  public function manage() {
    
  }
  
  public function edit($id) {
    $review = $this->Review->findById($id);
    $review_form_id = $review['ReviewForm']['id'];
    $opts = array(
      'conditions' => array('Question.review_form_id' => $review_form_id),
      'order' => array('Question.position')
    );
    $questions = $this->Review->ReviewForm->Question->find('all', $opts);
    $question_list = $this->Review->ReviewForm->Question->find('list',
      array('conditions'=>array('Question.review_form_id'=>$review_form_id)));
  
    $ans_opts = array(
      'fields' => array('Answer.choice_id', 'Answer.comments', 'Answer.question_id'),
      'conditions' => array(
        'Answer.user_id' => $this->Auth->user('id'),
        'Answer.question_id' => $question_list,
        'Answer.review_id' => $id
      )
    );
    
    $answers = $this->Review->Answer->find('list', $ans_opts);

    $this->set('review', $review);
    $this->set('questions', $questions);
    $this->set('answers', $answers);
  }
}
?>