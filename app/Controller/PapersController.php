<?
class PapersController extends AppController {
  public $name = 'Paper';
  
  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }

  public function upload() {
    if($this->request->is('post')) {
      $paper = $this->request->data['Paper']['paper'];
      pr($this->request->data);

      // make sure they uploaded a pdf
      if($paper['type'] != 'application/pdf') {
        $this->alertError(
          'Uh-oh.',
          sprintf('Only PDF submissions will be accepted. It ' .
            'looks like you tried to upload a file of type <kbd>%s</kbd>.', 
            $paper['type'])
        );
        return false;
      }
    }
  }
}
?>