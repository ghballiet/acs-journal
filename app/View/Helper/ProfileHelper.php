<?
App::uses('AppHelper', 'View/Helper');

class ProfileHelper extends AppHelper {
  public $helpers = array('Html');

  public function gravatar($email, $size = '40px') {
    $base_url = 'http://www.gravatar.com/avatar/%s?d=mm&s=%s&r=g';
    $hash = md5(strtolower(trim($email)));
    $url = sprintf($base_url, $hash, $size);
    return $this->Html->image($url, array('class'=>'gravatar'));
  }

  public function name($user) {
    return sprintf('%s %s', $user['name'], $user['surname']);
  }

  public function badge($user) {
    // TODO: display user profile information in a popover; display
    // more information if the currently logged in user is an
    // administrator. 
    return $this->name($user);
  }
}
?>