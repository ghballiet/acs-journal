<?
class UsersController extends AppController {
  public $name = 'User';
  
  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('login', 'register', 'forgot_password',
                       'reset_password');
  }
  
  public function register() {
    if($this->request->is('post')) {
      $password = $this->request->data['User']['password'];
      if($user = $this->User->save($this->request->data)) {
        $this->alertSuccess('Thank you!', 'You have ' .
          'succesfully registered with ACS.', true);
        
        $this->User->sendWelcomeEmail(array(
          // 'name' => $user['User']['name'],
          // 'surname' => $user['User']['surname'],
          // 'password' => $password,
          // 'email' => $user['User']['email'],
          'user' => $user['User']
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

    $submissions = $this->User->Submission->getCurrent(array(
      'Submission.user_id'=>$this->Auth->user('id')));
    $this->set('submissions', $submissions);
  }
  
  public function logout() {
    $this->redirect($this->Auth->logout());
  }

  public function settings() {
    
  }

  public function reset_password($hash) {
    $options = array(
      'conditions' => array(
        'md5(concat(User.id, User.name, " ", User.surname, User.email))' => $hash
      )
    );

    $user = $this->User->find('first', $options);

    if($user != null) {
      $this->set('reset_for', $user);
    } else {
      $this->alertError('Error!', 'Invalid password reset request.');
      $this->redirect(array('controller'=>'users', 'action'=>'login'));
    }

    if($this->request->is('post')) {
      $data = $this->request->data;
      $data = $data['User'];
      if(strtolower(trim($data['email'])) == strtolower(trim($user['User']['email']))) {
        $arr = array(
          'User' => array(
            'id' => $data['id'],
            'password' => $data['password'],
            'confirm_password' => $data['confirm_password'],
            'name'=>$user['User']['name'],
            'surname'=>$user['User']['surname'],
            'email'=>$user['User']['email'],
            'confirm_email' => $user['User']['email']
          )
        );
        if($this->User->save($arr)) {
          $this->alertSuccess('Success!', 'Your password has been reset.', true);
          $this->redirect(array('controller'=>'users', 'action'=>'login'));
        } else {
          $this->alertError('Error!', 'Passwords do not match.');
        }
      } else {
        $this->alertError('Error!', 'Invalid password reset request.');
        $this->redirect(array('controller'=>'users', 'action'=>'login'));
      }
    }
  }

  public function forgot_password() {
    if($this->request->is('post')) {
      $data = $this->request->data;
      $email = strtolower(trim($data['User']['email']));
      $surname = strtolower(trim($data['User']['surname']));
      
      $conditions = array(
        'lower(User.email)' => $email,
        'lower(User.surname)' => $surname
      );
        
      
      $user = $this->User->find('first', array('conditions'=>$conditions));

      if($user == null) {
        // we probably want to let them know that it didn't work out,
        // so that they can double check for spelling errors and the
        // like. 
        $title = 'No users found.';
        $msg = 'There are no registered users with that email and last name. ' .
          'Please double-check your entries below and try again.';
        $this->alertError($title, $msg);
      } else {
        // they're in the system, so we need to send them a link to
        // reset their password, and then take them back to the login
        // page. 
        $view = new View($this);
        $html = $view->loadHelper('Html');

        $id = $user['User']['id'];
        $name = sprintf('%s %s', $user['User']['name'], $user['User']['surname']);
        $email = $user['User']['email'];


        $hash = md5(sprintf('%s%s%s', $id, $name, $email));
        $url = $html->url(array('action'=>'reset_password', $hash), true);

        $arr = array(
          'email' => $email,
          'id' => $id,
          'name' => $name,
          'url' => $url
        );

        // actually send the message
        $this->User->resetPasswordEmail($arr);
        
        $msg = 'An email has been sent to you with a link to ' . 
          'reset your password.';

        $this->alertSuccess('Success!', $msg, true);
        $this->redirect(array('action'=>'login'));
      }
    }
  }
}
?>