<?
class CollectionsController extends AppController {
  public $name = 'Collection';
  
  public function beforeFilter() {
  }

  public function manage() {
    $collections = $this->Collection->find('all', array('order'=>
                                                       array('Collection.title')));
    $this->set('collections', $collections);
  }
}
?>