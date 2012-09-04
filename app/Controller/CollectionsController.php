<?
class CollectionsController extends AppController {
  public $name = 'Collection';
  
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow(array('contents'));
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

      // create the review form
      $review_form = array('ReviewForm'=>array(
        'collection_id' => $collection['Collection']['id'],
        'modified' => $collection['Collection']['modified']
      ));
      $this->Collection->ReviewForm->create();
      $this->Collection->ReviewForm->save($review_form);

      $this->alertSuccess('Success!', sprintf('Succesfully created <strong>%s</strong>.', 
                                              $title), true);
      $this->redirect(array('controller'=>'collections', 'action'=>'manage'));
    } else if($this->request->is('post')) {
      $this->alertError('Uh-oh.', 'Something went wrong. Please correct ' . 
                        'any errors below, and try again.');
    }
  }

  public function edit($slug = null) {
    $collection = $this->Collection->findBySlug($slug);
    $id = $collection['Collection']['id'];
    $this->Collection->id = $id;
    $this->Collection->read();
    $this->set('collection', $collection);

    if($this->request->is('get')) {
      $this->request->data = $collection;
    } else {
      $this->request->data['Collection']['modified'] = 
        date('Y-m-d H:i:s');
      if($coll = $this->Collection->save($this->request->data)) {
        $this->alertSuccess('Success!',
                            sprintf('Collection <strong>%s</strong> ' . 
                                    'successfully updated.',
                                    $coll['Collection']['title']), 
                            true);
        $this->redirect(array('action'=>'manage'));
      } else {
        $this->alertError('Uh-oh.', 'Something went wrong - please ' .
                          'try again.');
      }
    }
  }

  public function delete($slug = null) {
    $collection = $this->Collection->findBySlug($slug);
    $id = $collection['Collection']['id'];
    $this->Collection->delete($id);
    $title = $collection['Collection']['title'];
    $this->alertSuccess('Success!', sprintf('Succesfully deleted <strong>%s</strong>.',
                                            $title), true);
    $this->redirect(array('controller'=>'collections', 'action'=>'manage'));
  }

  public function view($slug = null) {
    if($slug == null)
      $this->redirect(array('controller'=>'collections', 'action'=>'manage'));
    
    $collection = $this->Collection->findBySlug($slug);
    $id = $collection['Collection']['id'];
    $this->set('collection', $collection);


    $submissions = $this->Collection->Submission->getCurrent(array(
      'collection_id'=>$id));
    $this->set('submissions', $submissions);

    $roles = $this->Collection->Role->findAllByCollectionId($id);
    $this->set('roles', $roles);

    $role_types = $this->Collection->Role->RoleType->find('all', 'RoleType.name');
    $this->set('role_types', $role_types);
    
    $role_type_list = $this->Collection->Role->RoleType->find('list', 'RoleType.name');
    $this->set('role_type_list', $role_type_list);

    $get_id = function($user) {
      return $user['Role']['user_id'];
    };
    
    $user_ids = array_map($get_id, $roles);

    $options = array(
      'conditions' => array(
        'NOT' => array('User.id' => $user_ids)
      ),
      'fields' => array('User.name_email'),
      'order' => array('User.name_email')
    );
    $users = $this->Collection->Role->User->find('list', $options);
    $this->set('users', $users);

    pr($users);

    $review_form = $this->Collection->ReviewForm->findByCollectionId($id);    
    $this->set('review_form', $review_form);

    $questions = $this->Collection->ReviewForm->Question->findAllByReviewFormId(
      $review_form['ReviewForm']['id'], array('Question.position', 'Question.text'));
    $this->set('questions', $questions);

    // get a list of review form ids for this collection
    $review_form_opts = array(
      'conditions' => array('ReviewForm.collection_id' => $id),
      'fields' => array('ReviewForm.id')
    );
    $review_form_ids = $this->Collection->ReviewForm->find('list', $review_form_opts);   
    
    // grab the number of reviews per user
    $review_options = array(
      'conditions' => array('Review.review_form_id' => $review_form_ids),
      'fields' => array('Review.id', 'Review.submission_id', 'Review.user_id'),
    );
    $reviews = $this->Collection->ReviewForm->Review->find('list', $review_options);
    $this->set('review_counts', $reviews);

    // grab the number of reviewers per submission
    $opts = array(
      'conditions' => array('Review.review_form_id' => $review_form_ids),
      'fields' => array('Review.id', 'Review.user_id', 'Review.submission_id'),
    );
    $submission_reviews = $this->Collection->ReviewForm->Review->find('list', $opts);
    $this->set('submission_reviews', $submission_reviews);
  }

  public function contents($slug = null) {
    if($slug == null)
      $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));

    $collection = $this->Collection->findBySlug($slug);
    $id = $collection['Collection']['id'];
    $this->set('collection', $collection);

    $order = array(
      'Submission.order',
      'Submission.id'
    );
    
    $submissions = $this->Collection->Submission->findAllByCollectionIdAndRetracted(
      $id, 0, array(), $order);
    $this->set('submissions', $submissions);
  }

  public function assign_role($user = null, $role = null, $type = null, $max_reviews = null) {
    $this->autoRender = false;
    if($this->request->is('post')) {
      $data = $this->request->data['Collection'];
      $max_reviews = $data['max_reviews'];
      $user = $this->Collection->Role->User->findByNameEmail($data['user']);
      $collection = $this->Collection->findById($data['collection_id']);
      $slug = $collection['Collection']['slug'];
      $user_id = $user['User']['id'];
      $collection_id = $collection['Collection']['id'];
      $role_type_id = $data['role_type'];
      
      $arr = array(
        'user_id' => $user_id,
        'collection_id' => $collection_id,
        'role_type_id' => $role_type_id,
        'max_reviews' => $max_reviews
      );
      $arr = array('Role' => $arr);

      $this->Collection->Role->create();
      if($role = $this->Collection->Role->save($arr)) {
        $this->alertSuccess('Success!', 'Role successfully added.', true);
        $this->redirect(array('action'=>'view', $slug, '#'=>'roles'));
      } else {
        $this->alertError('Error!',
                          'Could not add role. Please correct any errors below and resubmit.');
        $this->redirect(array('action'=>'view', $slug, '#'=>'roles'));
      }
    } else {
      $user = $this->Collection->Role->User->findById($user);
      $role = $this->Collection->Role->findById($role);
      $type = $this->Collection->Role->RoleType->findById($type);
      $arr = array(
        'id' => $role['Role']['id'],
        'user_id' => $user['User']['id'],
        'role_type_id' => $type['RoleType']['id'],
        'collection_id' => $role['Role']['collection_id'],
        'max_reviews' => $max_reviews,
        'skip_validation' => true
      );
      $arr = array('Role' => $arr);
      if($saved = $this->Collection->Role->save($arr)) {
        $this->alertSuccess('Success!', 'Role successfully updated.', true);
        $this->redirect(array('action'=>'view', $role['Collection']['slug'], '#'=>'roles'));
      }         
    }
  }

  public function remove_role($id = null) {
    $this->autoRender = false;
    $role = $this->Collection->Role->findById($id);
    $collection_id = $role['Collection']['id'];
    $slug = $role['Collection']['slug'];
    if($this->Collection->Role->delete($id)) {
      $this->alertSuccess('Success!', 'Succesfully deleted role.', true);
      $this->redirect(array('action'=>'view', $slug, '#'=>'roles'));      
    } else {
      $this->alertError('Error!', 'Something went wrong, and that role could ' .
                        'not be deleted. Please try again.');
      $this->redirect(array('action'=>'view', $slug, '#'=>'roles'));
    }
  }
}
?>