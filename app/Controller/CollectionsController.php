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

  public function add() {
    // TODO: the whole if(post) thing, add it, make sure to use the
    // proper alert classes and such. additionally, make sure to
    // validate in the model.
  }
}
?>