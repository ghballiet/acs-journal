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
}
?>