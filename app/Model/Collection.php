<?
class Collection extends AppModel {
  public $name = 'Collection';
  public $hasMany = array('Submission', 'Category', 'Role');

  // validation rules
  public $validate = array(
    'title' => array(
      'rule' => 'isUnique',
      'required' => 'true',
      'message' => 'This title is already in use.'
    )
  );

  public function afterSave($created) {
    if(!$created)
      return true;

    // create the slug
    $id = $this->data['Collection']['id'];
    $title = $this->data['Collection']['title'];
    $title = strtolower(trim($title));
    $slug = preg_replace('/\W+/', '', $title);
    
    pr($slug);
    die('');

    $slug = str_replace(' ', '-', $slug);
    $slug = sprintf('%d-%s', $id, $title);
    $this->data['Collection']['slug'] = $slug;
    
    return $this->save($this->data);
  }
}
?>