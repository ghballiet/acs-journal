<?
class QuestionsController extends AppController {
  public $name = 'Question';

  public function add($review_form_id = null) {
    // add a new question to the review form
    $form = $this->Question->ReviewForm->findById($review_form_id);
    $this->set('review_form', $form);
    $this->set('review_form_id', $review_form_id);

    if($this->request->is('get')) {
      // just viewing the page
    } else {
      // trying to add a question here
    }
  }
}
?>