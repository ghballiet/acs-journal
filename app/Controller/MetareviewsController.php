<?
class MetareviewsController extends AppController {
  public $name = 'Metareview';

  public function create() {
    if($this->Metareview->save($this->request->data)) {
      $this->alertSuccess('Success!', 'Metareview successfully saved.');
      $this->redirect(
        array(
          'controller'=>'reviews',
          'action'=>'manage'
        )
      );
    }
  }
}
?>