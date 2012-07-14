<?
class PapersController extends AppController {
  public $name = 'Paper';
  
  public function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }
  
  public function delete($id = null) {
    $this->Paper->id = $id;
    if($this->Paper->delete($id)) {
      $this->alertSuccess('Success!', 'Paper successfully deleted.', true);
      $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
    } else {
      $this->alertError('Uh-oh.', 'Something went wrong. Please submit your request again.');
    }
  }

  public function upload() {
    if($this->request->is('post')) {
      $data = $this->request->data;

      // make sure they uploaded a pdf
      if($data['Paper']['paper']['type'] != 'application/pdf') {
        $this->alertError('Uh-oh.',
          'Papers must be uploaded as PDF files.'
        );
        return false;
      }

      // save the user id
      $data['Paper']['user_id'] = $this->Auth->user('id');

      // read the pdf, and store the contents in the database
      $tmp_name = $data['Paper']['paper']['tmp_name'];
      $contents = file_get_contents($tmp_name);
      $data['Paper']['paper'] = $contents;

      if($paper = $this->Paper->save($data)) {
        // delete the temporary file :)
        unset($tmp_file);
        
        $this->alertSuccess('Success!', 'Your paper was uploaded successfully.', true);
        $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
      }
    }
  }
}
?>