<?
class ChoicesController extends AppController {
  public $name = 'Choice';
  
  public function addJson() {
    $this->autoRender = false;
    if($this->request->is('post')) {
      if($choice = $this->Choice->save($this->request->data)) {
        echo json_encode(array('data'=>$choice, 'ok'=>true));
      } else {
        echo json_encode(array('ok'=>false));
      }
    }
  }

  public function deleteJson() {
    $this->autoRender = false;
    if($this->request->is('post')) {
      $id = $this->request->data['Choice']['id'];
      if($this->Choice->delete($id)) {
        echo json_encode(array('ok'=>true));        
      } else {
        echo json_encode(array('ok'=>false));
      }
    }
  }
}
?>