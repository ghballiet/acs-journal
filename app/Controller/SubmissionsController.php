<?
class SubmissionsController extends AppController {
  public $name = 'Submission';

  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }
}
?>