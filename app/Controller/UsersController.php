<?
class UsersController extends AppController {
  public $name = 'User';
  
  public function beforeFilter() {
    $this->Auth->allow('login', 'register', 'forgot_password',
                       'reset_password');
    $this->set('user', $this->Auth->user());
  }
  
  public function register() {
    if($this->request->is('post')) {
      $password = $this->request->data['User']['password'];
      if($user = $this->User->save($this->request->data)) {
        $this->alertSuccess('Thank you!', 'You have ' .
          'succesfully registered with ACS.', true);
        $this->User->sendWelcomeEmail(array(
          'name' => $user['User']['name'],
          'surname' => $user['User']['surname'],
          'password' => $password,
          'email' => $user['User']['email']
        ));
        
        return $this->redirect(array('action'=>'login'));
      } else {
        $this->alertError('An error has occurred.',
          'There is something wrong with your submission. Please correct ' .
          'your entries below, and submit again.');
      }
    }
  }
  
  public function login() {
    if($this->Auth->user() != null)
      $this->redirect(array('action'=>'dashboard'));
    if($this->request->is('post')) {
      if($this->Auth->login()) {
        return $this->redirect(array('action'=>'dashboard'));
      } else {
        $view = new View($this);
        $html = $view->loadHelper('Html');
        $forgot_link = $html->link('reset your password', 
                                   array('action'=>'forgot_password'));        
        $this->alertError('Login failed.',
                          sprintf('Something went wrong. If you have an account, ' .
                                  'you may wish to %s.', $forgot_link));        
      }
    }
  }
  
  public function dashboard() {
    $collections = $this->User->Role->Collection->findAllByAcceptingSubmissions(1);
    $this->set('collections', $collections);

    $submissions = $this->User->Submission->findAllByUserId($this->Auth->user('id'));
    $this->set('submissions', $submissions);
  }
  
  public function logout() {
    $this->redirect($this->Auth->logout());
  }

  public function settings() {
    
  }

  public function forgot_password() {
    if($this->request->is('post')) {
      $data = $this->request->data;
      $email = strtolower(trim($data['User']['email']));
      $name = strtolower(trim($data['User']['surname']));
      $hash = md5(sprintf('%s%s', $email, $name));
      
      $conditions = array(
        'md5(concat(lower(User.email), lower(User.surname)))' => $hash);
      
      $user = $this->User->find('first', array('conditions'=>$conditions));

      pr($user);
    }
  }
}
?>