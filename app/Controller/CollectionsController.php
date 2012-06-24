<?
class CollectionsController extends AppController {
  public $name = 'Collection';
  
  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function manage() {
    $collections = $this->Collection->find('all', array('order'=>
                                                       array('Collection.title')));
    $this->set('collections', $collections);
  }

  public function add() {
    if($this->request->is('post') &&
       $collection = $this->Collection->save($this->request->data)) {
      $title = $collection['Collection']['title'];
      $this->alertSuccess('Success!', sprintf('Succesfully created <strong>%s</strong>.', 
                                              $title), true);
      $this->redirect(array('controller'=>'collections', 'action'=>'manage'));
    }
  }
}
?>