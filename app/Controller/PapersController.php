<?
class PapersController extends AppController {
  public $name = 'Paper';
  
  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function upload() {
    if($this->request->is('post')) {
      pr($this->request->data);
    }
  }
}
?>