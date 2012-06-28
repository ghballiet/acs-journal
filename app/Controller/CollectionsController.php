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

      // make this user an administrator of the collection.
      $admin_role_type = $this->Collection->Role->RoleType->findByName('admin');
      $role = array('Role'=>array(
        'role_type_id' => $admin_role_type['RoleType']['id'],
        'user_id' => $this->Auth->user('id'),
        'collection_id' => $collection['Collection']['id'],
        'modified' => $collection['Collection']['modified']
      ));
      $this->Collection->Role->create();
      $this->Collection->Role->save($role);

      $this->alertSuccess('Success!', sprintf('Succesfully created <strong>%s</strong>.', 
                                              $title), true);
      $this->redirect(array('controller'=>'collections', 'action'=>'manage'));
    } else if($this->request->is('post')) {
      $this->alertError('Uh-oh.', 'Something went wrong. Please correct any errors below, and ' .
                        'try again.');
    }
  }

  public function edit($id = null) {
    $this->Collection->id = $id;
    $collection = $this->Collection->read();
  }

  public function delete($id = null) {
    $this->Collection->id = $id;
    $collection = $this->Collection->read();
    $this->Collection->delete($id);
    $title = $collection['Collection']['title'];
    $this->alertSuccess('Success!', sprintf('Succesfully deleted <strong>%s</strong>.',
                                            $title), true);
    $this->redirect(array('controller'=>'collections', 'action'=>'manage'));
  }

  public function view($id = null) {
    if($id == null)
      $this->redirect(array('controller'=>'collections', 'action'=>'manage'));
    
    $this->Collection->id = $id;
    $collection = $this->Collection->find('threaded',
                                          array('conditions'=>
                                                array('Collection.id'=>$id)));
    $this->set('collection', $collection);
  }
}
?>