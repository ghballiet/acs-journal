<?
class Role extends AppModel {
  public $name = 'Role';
  public $belongsTo = array('Collection', 'RoleType', 'User');

  public $validate = array(
    'user_id' => array(
      'rule' => 'uniquePerCollection',
      'message' => 'That user already has a role in this collection.'
    )
  );

  public function uniquePerCollection($check) {
    // try to find another record using the same user id and
    // collection id; if it exists, return false, otherwise, return
    // true 

    if(isset($this->data['Role']['skip_validation']) &&
       $this->data['Role']['skip_validation'] == true)
      return true;

    $user_id = $this->data['Role']['user_id'];
    $collection_id = $this->data['Role']['collection_id'];
    
    $record = $this->findAllByCollectionIdAndUserId($collection_id, $user_id); 
    
    return $record == null;
  }
}
?>