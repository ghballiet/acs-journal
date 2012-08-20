<?
App::uses('AppHelper', 'View/Helper');

class ProfileHelper extends AppHelper {
  public $helpers = array('Html');

  public function gravatar($email, $size = '40px') {
    $base_url = 'http://www.gravatar.com/avatar/%s?d=identicon&s=%s&r=g';
    $hash = md5(strtolower(trim($email)));
    $url = sprintf($base_url, $hash, $size);
    return $this->Html->image($url, array('class'=>'gravatar'));
  }

  public function name($user) {
    return sprintf('%s %s', $user['name'], $user['surname']);
  }

  public function badge($user, $tag = null) {
    // TODO: display user profile information in a popover; display
    // more information if the currently logged in user is an
    // administrator.
    $name = $user['full_name'];
    $id = $user['id'];
    $email = $user['email'];
    $img = $this->gravatar($email);

    $str = sprintf('<div class="user-badge" data-id="%d"', $id);

    if($tag != null)
      $str .= sprintf(' data-tag="%s"', $tag);
    
    $str .= '>';
   
    
    // profile image
    $str .= sprintf('<div class="image-wrapper">%s</div>', $img);

    // actual badge info
    $str .= '<div class="user-info">';

    // tag, if it is set
    if($tag != null)
      $str .= sprintf('<div class="user-tag"><span>%s</span></div>', $tag);

    // basic info
    $str .= sprintf('<div class="user-name">%s</div>', $name);
    $str .= '<div class="user-email"><i class="icon-envelope"></i>';
    $str .= sprintf('<a href="mailto:%s">%s</a>', $email, $email);
    $str .= '</div>'; // end of user-email

    $str .= '</div>'; // end of user-info

    $str .= '<div class="clearfix"></div>'; // you can never be too careful
    $str .= '</div>'; // end of badge

    return $str;
  }
}
?>