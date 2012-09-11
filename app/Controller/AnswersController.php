<?
class AnswersController extends AppController {
  public $name = 'Answer';
  
  public function beforeFilter() {
    parent::beforeFilter();
  }
  
  public function saveJson() {
    // save data passed by json
    $this->autoRender = false;
    if($this->request->is('post')) {
      // make sure that it doesn't exist yet, since we want to only edit,
      // not add
      $data = $this->request->data['Answer'];
      $answer = $this->Answer->findByReviewIdAndUserIdAndQuestionId(
        $data['review_id'], $data['user_id'], $data['question_id']
      );
      if($answer != null) {
        // it already exists!
        $id = $answer['Answer']['id'];
        $data['id'] = $id;        
      }
      if($answer = $this->Answer->save(array('Answer'=>$data))) {
        echo json_encode(array('data'=>$answer, 'ok'=>true));
      } else {
        echo json_encode(array('ok'=>false));
      }
    }
  }
}
?>