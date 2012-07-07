<?
class PapersController extends AppController {
  public $name = 'Paper';
  
  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function upload() {
    
  }
}
?>