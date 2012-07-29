<?
App::uses('CakeEmail', 'Network/Email');

class User extends AppModel {
  public $name = 'User';
  public $hasMany = array('Submission', 'Role', 'Upload');
  
  public $validate = array(
    'email'=>array(
      'required'=>array(
        'rule'=>'notEmpty',
        'message'=>'An email address is required.'
      ),
      'email'=>array(
        'rule'=>'email',
        'message'=>'Please enter a valid email address.'
      ),
      'unique'=>array(
        'rule'=>'isUnique',
        'message'=>'That email address is already in use.'
      ),
      'email_confirm'=>array(
        'rule'=>array('valuesMatch', 'confirm_email'),
        'message'=>'The email addresses you provided do not match.'
      )
    ),
    'password'=>array(
      'required'=>array(
        'rule'=>'notEmpty',
        'message'=>'Please enter a password.'
      ),
      'password_confirm'=>array(
        'rule'=>array('valuesMatch', 'confirm_password'),
        'message'=>'The passwords you provided do not match.'
      )
    )
  );
  
  public function valuesMatch($rules = array(), $compare = null) {
    foreach($rules as $key=>$value) {
      $v1 = $value;
      $v2 = $this->data[$this->name][$compare];
      if($v1 === $v2)
        continue;
      else
        return false;
    }
    return true;
  }
  
  public function beforeSave($options = array()) {
    // sanitize the email and name data (important for password
    // retrieval)
    $this->data['User']['email'] = trim($this->data['User']['email']);
    $this->data['User']['name'] = trim($this->data['User']['name']);
    $this->data['User']['surname'] = trim($this->data['User']['surname']);

    // hash the password
    $this->data['User']['password'] = AuthComponent::password(
      $this->data['User']['password']);
    return true;
  }

  // email functions
  public function adminNewUserEmail($data) {
    $admins = $this->findAllByIsAdmin(1);
    foreach($admins as $admin) {
      $data['admin'] = $admin['User'];
      $email = new CakeEmail();
      $email->template('new_user', 'default');
      $email->emailFormat('html');
      $email->to($admin['User']['email']);
      $email->subject(sprintf('New User: %s', $data['user']['email']));
      $email->from('acs@cogsys.org');
      $email->viewVars($data);
      $email->send();
    }
  }


  public function sendWelcomeEmail($data) {
    $email = new CakeEmail();
    $email->template('welcome', 'default');
    $email->emailFormat('html');
    $email->to($data['user']['email']);
    $email->subject('Welcome!');
    $email->from('acs@cogsys.org');
    $email->viewVars($data);
    $email->send();

    $this->adminNewUserEmail($data);
  }

  public function resetPasswordEmail($data) {
    $email = new CakeEmail();
    $email->template('reset_password', 'default');
    $email->emailFormat('html');
    $email->to($data['email']);
    $email->subject('Reset Your Password');
    $email->from('acs@cogsys.org');
    $email->viewVars($data);
    $email->send();
  }
}
?>