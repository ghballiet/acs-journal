<?
class Category extends AppModel {
  public $name = 'Category';
  public $belongsTo = array('Collection');
  public $hasMany = array('Submission', 'Metareview');

  public function notify($data) {
    foreach($data['emails'] as $addr) {
      $email = new CakeEmail();
      $email->template($data['layout'], 'default');
      $email->emailFormat('text');
      $email->to($addr);
      $email->subject('Advances in Cognitive Systems 2012 Decision');
      $email->from('acs@cogsys.org');
      $email->viewVars(array(
        'title'=>$data['title'],
        'url' => $data['url']
      ));
      $email->send();
    }
  }
}
?>