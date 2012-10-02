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

  public function status() {
    $coll_ids = $this->Review->User->Role->find('all', array(
      'conditions'=>array('Role.role_type_id'=>2),
      'fields'=>array('DISTINCT Role.collection_id')));
    $coll_ids = Set::extract('/Role/collection_id', $coll_ids);
    $review_form_ids = $this->Review->ReviewForm->findAllByCollectionId($coll_ids);
    $review_form_ids = Set::extract('/ReviewForm/id', $review_form_ids);
    $submission_ids = $this->Review->find('all', array(
      'conditions'=>
      array(
        'Review.review_form_id' => $review_form_ids,
        'Review.user_id' => $this->Auth->user('id')
      ),
      array(
        'fields' => array('Review.submission_id')
      )));
    $submission_ids = Set::extract('/Submission/id', $submission_ids);
    $submissions = $this->Review->Submission->find('all', array(
      'conditions'=>array('Submission.id'=>$submission_ids)));
    $reviews = $this->Review->find('all', array(
      'conditions'=>array(
        'Review.submission_id' => $submission_ids,
        'Review.user_id NOT' => $this->Auth->user('id')),
      'order'=>array('Review.id', 'Review.user_id')));
    $this->set('reviews', $reviews);    

    $papers = Set::combine($reviews, '{n}.Review.id', '{n}', '{n}.Submission.slug');
    $titles = Set::combine($reviews, '{n}.Submission.slug', '{n}.Submission.title');
    $review_form_id = Set::extract('/ReviewForm/id', $reviews);

    $questions = $this->Review->ReviewForm->Question->find('count', array(
      'conditions' => array('Question.review_form_id' => $review_form_id)));

    $authors = Set::combine($submissions, '{n}.Submission.slug', '{n}.User');
    
    $this->set('questions', $questions);   
    $this->set('papers', $papers);
    $this->set('titles', $titles);
    $this->set('authors', $authors);
  }

  public function manage() {
    // change of plans:
    // - for now, manually pick just the conference collection. 
    // - if they're an action editor, send them over to status. 

    $role = $this->Review->User->Role->find('first', array(
      'conditions' => array(
        'Role.collection_id' => 3,
        'Role.user_id' => $this->Auth->user('id'))));
    if($role['RoleType']['name'] == 'editor' || $role['RoleType']['name'] == 'admin')
      $this->redirect(array('action'=>'status'));

    $user_list = $this->Review->User->find('list', array('fields'=>array('User.id', 'User.full_name')));
    $this->set('user_list', $user_list);

    // 1. find collections where i am an editor or admin.
    // 2. find submissions in that collection which have been assigned to me.
    // 3. show links to the reviews of those submissions. 

    $coll_ids = $this->Review->User->Role->find('all', array(
      'conditions'=>array('Role.role_type_id'=>2),
      'fields'=>array('DISTINCT Role.collection_id')));
    $coll_ids = Set::extract('/Role/collection_id', $coll_ids);
    $review_form_ids = $this->Review->ReviewForm->findAllByCollectionId($coll_ids);
    $review_form_ids = Set::extract('/ReviewForm/id', $review_form_ids);
    $submission_ids = $this->Review->find('all', array(
      'conditions'=>
      array(
        'Review.review_form_id' => $review_form_ids,
        'Review.user_id' => $this->Auth->user('id')
      ),
      array(
        'fields' => array('Review.submission_id')
      )));
    $submission_ids = Set::extract('/Submission/id', $submission_ids);
    $submissions = $this->Review->Submission->find('all', array(
      'conditions'=>array('Submission.id'=>$submission_ids)));
    $reviews = $this->Review->find('all', array(
      'conditions'=>array(
        'Review.submission_id' => $submission_ids,
        'Review.user_id NOT' => $this->Auth->user('id')),
      'order'=>array('Review.id', 'Review.user_id')));
    $this->set('reviews', $reviews);
  }

  public function view($id) {
    $review = $this->Review->findById($id);
    $review_form_id = $review['ReviewForm']['id'];
    $review = $this->Review->findById($id);
    $review_form_id = $review['ReviewForm']['id'];
    $opts = array(
      'conditions' => array(
        'Question.review_form_id' => $review_form_id
      ),
      'order' => array('Question.position')
    );
    $questions = $this->Review->ReviewForm->Question->find('all', $opts);
    $question_list = $this->Review->ReviewForm->Question->find(
      'list',
      array('conditions'=>array('Question.review_form_id'=>$review_form_id)));

    $ans_opts = array(
      'conditions' => array(
        'Answer.user_id' => $review['Review']['user_id'],
        'Answer.question_id' => $question_list,
        'Answer.review_id' => $id
      )
    );
    
    $answers = $this->Review->Answer->find('all', $ans_opts);
   
    $this->set('review', $review);
    $this->set('questions', $questions);
    $this->set('answers', $answers);

    // set users
    $user_list = $this->Review->User->find('list', array(
      'fields' => array('User.id', 'User.full_name')
    ));
    $this->set('user_list', $user_list);

    $coauthors = $this->Review->Submission->Coauthor->find('list', array(
      'fields' => array(
        'Coauthor.id',
        'Coauthor.name',
        'Coauthor.submission_id',        
      )
    ));
    
    $this->set('coauthors', $coauthors);
  }
  
  public function edit($id) {
    $review = $this->Review->findById($id);
    $review_form_id = $review['ReviewForm']['id'];
    $opts = array(
      'conditions' => array('Question.review_form_id' => $review_form_id),
      'order' => array('Question.position')
    );
    $questions = $this->Review->ReviewForm->Question->find('all', $opts);
    $question_list = $this->Review->ReviewForm->Question->find('list',
      array('conditions'=>array('Question.review_form_id'=>$review_form_id)));
  
    $ans_opts = array(
      'fields' => array('Answer.choice_id', 'Answer.comments', 'Answer.question_id'),
      'conditions' => array(
        'Answer.user_id' => $this->Auth->user('id'),
        'Answer.question_id' => $question_list,
        'Answer.review_id' => $id
      )
    );
    
    $answers = $this->Review->Answer->find('list', $ans_opts);

    $this->set('review', $review);
    $this->set('questions', $questions);
    $this->set('answers', $answers);

    // set users
    $user_list = $this->Review->User->find('list', array(
      'fields' => array('User.id', 'User.full_name')
    ));
    $this->set('user_list', $user_list);

    $coauthors = $this->Review->Submission->Coauthor->find('list', array(
      'fields' => array(
        'Coauthor.id',
        'Coauthor.name',
        'Coauthor.submission_id',        
      )
    ));
    
    $this->set('coauthors', $coauthors);

    $editable = false;
    if($review['User']['id'] == $this->Auth->user('id'))
      $editable = true;

    $this->set('editable', $editable);
  }
}
?>