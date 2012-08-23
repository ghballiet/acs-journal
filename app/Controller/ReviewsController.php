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
}
?>