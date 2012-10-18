<?
class CategoriesController extends AppController {
  public $name = 'Category';

  public function notify($id, $collection_id) {
    $this->autoRender = false;
    $category = $this->Category->findById($id);
    $collection = $this->Category->Collection->findById($collection_id);

    // build the list of people to notify
    $notifications = array();
    $mapping = array(
      '1' => 'talk',
      '2' => 'condition',
      '3' => 'poster',
      '4' => 'major',
      '5' => 'reject'
    );
       
    $submissions = Set::combine($category['Submission'], '{n}.id', '{n}', '{n}.collection_id');
    $submissions = $submissions[$collection_id];

    $view = new View($this);
    $html = $view->loadHelper('Html');

    foreach($submissions as $submission) {
      $emails = array();
      $coauthors = $this->Category->Submission->Coauthor->findAllBySubmissionId($submission['id']);      
      $ca_emails = Set::extract('{n}.Coauthor.email', $coauthors);
      if(count($ca_emails) > 0)
        $emails = array_unique($ca_emails);
      $user = $this->Category->Submission->User->findById($submission['user_id']);
      $emails[] = $user['User']['email'];

      $id = substr(md5($submission['id']),0,7);
      $url = $html->url(array(
        'controller'=>'submissions',
        'action'=>'reviews',
        $id
        ), true
      );
      $arr = array(
        'title' => $submission['title'],
        'url' => $url,
        'emails' => $emails,
        'layout' => $mapping[$submission['category_id']]
      );
      $notifications[] = $arr;
    }

    foreach($notifications as $n)
      $this->Category->notify($n);

    $this->alertSuccess('Email sent!', 'Notification letters have been sent.');
    $this->redirect(array(
      'controller'=>'collections',
      'action'=>'view',
      $collection['Collection']['slug'],
      '#'=>'categorize-papers'
      ));
  }
}
?>