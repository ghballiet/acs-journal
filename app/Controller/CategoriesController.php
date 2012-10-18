<?
class CategoriesController extends AppController {
  public $name = 'Category';

  public function notify($id, $collection_id) {
    $this->autoRender = false;
    $category = $this->Category->findById($id);
    $collection = $this->Category->Collection->findById($collection_id);
    echo 'In progress.';
  }
}
?>