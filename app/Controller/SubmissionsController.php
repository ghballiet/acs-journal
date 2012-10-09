<?
class SubmissionsController extends AppController {
  public $name = 'Submission';

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('view', 'paper');
  }

  public function view($slug) {
    $submission = $this->Submission->findBySlug($slug);
    $this->set('data', $submission);
  }

  private function bytesToSize($bytes, $precision = 2) {  
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;
    $terabyte = $gigabyte * 1024;
   
    if (($bytes >= 0) && ($bytes < $kilobyte)) {
      return $bytes . ' B';
 
    } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
      return round($bytes / $kilobyte, $precision) . ' KB';
 
    } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
      return round($bytes / $megabyte, $precision) . ' MB';
 
    } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
      return round($bytes / $gigabyte, $precision) . ' GB';
 
    } elseif ($bytes >= $terabyte) {
      return round($bytes / $terabyte, $precision) . ' TB';
    } else {
      return $bytes . ' B';
    }
  }

  public function edit($slug) {
    $submission = $this->Submission->findBySlug($slug);
    $id = $submission['Submission']['id'];
    $this->Submission->id = $id;
    $this->Submission->read();
    $this->set('submission', $submission);

    if($this->request->is('get')) {
      $this->request->data = $submission;
    } else {
      if($sub = $this->Submission->save($this->request->data)) {
        $this->alertSuccess('Success!', 'Submission saved.', true);
        $this->redirect(array('action'=>'view', $sub['Submission']['slug']));
      } else {
        $this->alertError('Uh-oh.', 'Something is wrong with your submission.');
      }
    }
  }

  public function retract($slug) {
    $submission = $this->Submission->findBySlug($slug);
    $this->set('submission', $submission);
    $submission['Submission']['retracted'] = true;
    $this->Submission->save($submission);
    $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
  }

  public function paper($slug) {
    $this->autoRender = false;
    $slug = str_replace('.pdf', '', $slug);
    $submission = $this->Submission->findBySlug($slug);

    // quick fix for bhatt-freska paper
    if(trim($submission['User']['surname']) == 'Bhatt' &&
       $submission['Collection']['title'] == 'First Annual Conference on Advances in Cognitive Systems') {
      $file = sprintf('../webroot/papers/%s.pdf', $slug);
      $content = file_get_contents($file);
      $type = 'application/pdf';
      $this->response->type($type);
      $this->response->body($content);
    } else {
      $paper = $submission['Paper'];
      
      $this->response->type($paper['type']);
      $this->response->body($paper['content']);
    }
  }

	// the $id is the submission id. 
  public function reviews($id) {
		
		// a bit heavy handed but probably fine for now.
		$this->loadModel('Review');
		$this->loadModel('Role');
		$this->loadModel('User');
		$this->loadModel('Metareview');
		
		// get the submission
		$submission = $this->Submission->findById($id);
		$this->set('submission',$submission);

		// get the metareviews
		$metareviews = array();
		foreach($submission['Metareview'] as $index => $metareview){
			$metareviews[$index] = $this->Metareview->findById($metareview['id']);
		}
		$this->set('metareviews', $metareviews);
		
		// get the reviews and questions
		$reviews = $this->Review->find('all', 
			array('conditions' => array('submission_id' => $id)));
		
    $review_form_id = $reviews[0]['ReviewForm']['id'];
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
		
		foreach ($reviews as &$review){
	    
			$ans_opts = array(
	      'conditions' => array(
	        'Answer.review_id' => $review['Review']['id']
	      )
	    );
			
			$this->Review->id = $review['Review']['id'];
	    $review['Answers'] = $this->Review->Answer->find('all', $ans_opts);    
	    $review['Answers'] = Set::combine($review['Answers'], '{n}.Question.id', '{n}');
			
			$review['Role'] = $this->Role->find('first',
				array('conditions' => array('user_id' => $review['Review']['user_id'],
																		'collection_id' => $submission['Submission']['collection_id'])))['Role'];
		}	
	 
    $this->set('reviews', $reviews);
    $this->set('questions', $questions);
    //$this->set('answers', $answers);
		
    // set users
    $user_list = $this->Review->User->find('list', array(
      'fields' => array('User.id', 'User.full_name')
    ));
    $this->set('user_list', $user_list);

    $coauthors = $this->Submission->Coauthor->find('list', array(
      'fields' => array(
        'Coauthor.id',
        'Coauthor.name',
        'Coauthor.submission_id',        
      )
    ));
    
    $this->set('coauthors', $coauthors);
		
  }

  public function create($slug = null) {
    $options = array(
      'conditions'=>array('Collection.accepting_submissions' => 1),
      'fields' => array('Collection.id', 'Collection.title'),
      'order' => array('Collection.title', 'Collection.subtitle',
                       'Collection.volume')
    );

    if(!empty($slug))
      $options['conditions']['Collection.slug'] = $slug;

    $collections = $this->Submission->Collection->find('list', $options);
    $this->set('collections', $collections);

    if($this->request->is('post')) {
      $data = $this->request->data;
      $submission = $data['Submission'];
      $upload = $submission['Upload'];
      $keywords = $submission['Keyword'];
      $coauthors = $data['Coauthor'];

      // remove the upload from the submission data array
      unset($submission['Upload']);

      // first, make sure a PDF file was uploaded
      if($upload['type'] != 'application/pdf') {
        $this->alertError(
          'Error!',
          sprintf('The file you uploaded - <strong>%s</strong> - was not ' . 
                  'a PDF file. Please select a PDF and re-submit.', $upload['name']));
        return false;
      }

      // get the date
      $now = date('Y-m-d H:i:s');
      
      // build the upload data
      $upload['content'] = file_get_contents($upload['tmp_name']);
      $upload['extension'] = pathinfo($upload['tmp_name'], PATHINFO_EXTENSION);
      $upload['user_id'] = $this->Auth->user('id');
      $upload['created'] = $now;
      $upload['modified'] = $now;
      $upload = array('Paper' => $upload);

      // save the upload
      try {
        $this->Submission->Paper->create();
        $upload = $this->Submission->Paper->save($upload);
      } catch(Exception $e) {
        if(strpos($e->getMessage(), 'max_allowed_packet')) {
          $this->alertError('PDF file was too large.',
                            sprintf('The file you uploaded was %s - the max allowed file ' . 
                                    'size is currently 2 MB. We are working to resolve ' . 
                                    'this issue as soon as possible, and will notify ' .
                                    'you when it has been fixed.',
                                    $this->bytesToSize($upload['Paper']['size'])));
        } else {
          $this->alertError('Something went wrong.', $e->getMessage());
        }
        $this->redirect(array('action'=>'create'));
      }

      // build the submission data
      $submission['user_id'] = $this->Auth->user('id');
      $submission['current_version'] = $upload['Paper']['id'];
      $submission['created'] = $now;
      $submission['modified'] = $now;
      $submission['order'] = $this->Submission->nextOrder($submission['collection_id']);
      $submission = array('Submission' => $submission);

      // save the submission
      $this->Submission->create();
      $submission = $this->Submission->save($submission);

      // update the next submission
      $submission['Submission']['next_submission'] = $submission['Submission']['id'];
      $submission = $this->Submission->save($submission);


      // save the keywords
      $words = explode(',', $keywords);
      foreach($words as $word) {
        $this->Submission->Keyword->create();
        $arr = array(
          'Keyword' => array(
            'value' => trim($word),
            'created' => $now,
            'modified' => $now,
            'submission_id' => $submission['Submission']['id']));
        $this->Submission->Keyword->save($arr);                             
      }

      // build the coauthors
      $ca = array();
      foreach($coauthors as $i=>$coauthor) {
        $coauthor['submission_id'] = $submission['Submission']['id'];
        $coauthor['created'] = $now;
        $coauthor['modified'] = $now;
        if(empty($coauthor['name']) && empty($coauthor['email']) &&
           empty($coauthor['institution']))
          continue;
        $coauthor = array('Coauthor' => $coauthor);
        $this->Submission->Coauthor->create();
        $this->Submission->Coauthor->save($coauthor);
      }
      
      // success! send the email
      try {
        $view = new View($this);
        $html = $view->loadHelper('Html');
        $url = $html->url(array(
          'action'=>'view', $submission['Submission']['slug']), true);      

        $this->Submission->createEmail($submission['Submission']['id'], $url);
        $this->alertSuccess(
          'Success!', sprintf('<strong>%s</strong> was successfully submitted.',
                              $submission['Submission']['title']), true);
      } catch(Exception $e) {
      }

      $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
    }
  }

  public function revise($slug) {
    if($this->request->is('get')) {
      $submission = $this->Submission->findBySlug($slug);
      $this->set('submission', $submission);
      $this->request->data = $submission;
    } else {
      $data = $this->request->data;
      $submission = $data['Submission'];
      $upload = $submission['Upload'];
      $keywords = $submission['Keyword'];
      $coauthors = $data['Coauthor'];

      // remove the upload from the submission data array
      unset($submission['Upload']);

      // first, make sure a PDF file was uploaded
      if($upload['type'] != 'application/pdf') {
        $this->alertError(
          'Error!',
          sprintf('The file you uploaded - <strong>%s</strong> - was not ' . 
                  'a PDF file. Please select a PDF and re-submit.', $upload['name']));
        return false;
      }

      // get the date
      $now = date('Y-m-d H:i:s');
      
      // build the upload data
      $upload['content'] = file_get_contents($upload['tmp_name']);
      $upload['extension'] = pathinfo($upload['tmp_name'], PATHINFO_EXTENSION);
      $upload['user_id'] = $this->Auth->user('id');
      $upload['created'] = $now;
      $upload['modified'] = $now;
      $upload = array('Paper' => $upload);

      // save the upload
      $this->Submission->Paper->create();
      $upload = $this->Submission->Paper->save($upload);

      // build the submission data
      $submission['user_id'] = $this->Auth->user('id');
      $submission['current_version'] = $upload['Paper']['id'];
      $submission['created'] = $now;
      $submission['modified'] = $now;
      $submission['order'] = $this->Submission->nextOrder($submission['collection_id']);
      $submission = array('Submission' => $submission);

      // save the submission
      $this->Submission->create();
      $submission = $this->Submission->save($submission);

      // update the next submission
      $submission['Submission']['next_submission'] = $submission['Submission']['id'];
      $submission = $this->Submission->save($submission);

      // update the previous submission
      $prev_id = $submission['Submission']['previous_submission'];
      $prev = $this->Submission->findById($prev_id);
      $prev['Submission']['next_submission'] = $submission['Submission']['id'];
      $this->Submission->save($prev);

      // update all the reviews
      $this->Submission->updateReviews($prev_id, $submission['Submission']['id']);

      // save the keywords
      $words = explode(',', $keywords);
      foreach($words as $word) {
        $this->Submission->Keyword->create();
        $arr = array(
          'Keyword' => array(
            'value' => trim($word),
            'created' => $now,
            'modified' => $now,
            'submission_id' => $submission['Submission']['id']));
        $this->Submission->Keyword->save($arr);                             
      }

      // build the coauthors
      $ca = array();
      foreach($coauthors as $i=>$coauthor) {
        $coauthor['submission_id'] = $submission['Submission']['id'];
        $coauthor['created'] = $now;
        $coauthor['modified'] = $now;
        if(empty($coauthor['name']) && empty($coauthor['email']) &&
           empty($coauthor['institution']))
          continue;
        $coauthor = array('Coauthor' => $coauthor);
        $this->Submission->Coauthor->create();
        $this->Submission->Coauthor->save($coauthor);
      }
      
      // success! send the email
      try {
        $view = new View($this);
        $html = $view->loadHelper('Html');
        $url = $html->url(array(
          'action'=>'view', $submission['Submission']['slug']), true);

        $this->Submission->revisedEmail($submission['Submission']['id'], $url);

        $this->alertSuccess(
          'Success!', sprintf('<strong>%s</strong> was successfully revised.',
                              $submission['Submission']['title']), true);
      } catch(Exception $e) {
      }
      $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
    }
  }
}
?>