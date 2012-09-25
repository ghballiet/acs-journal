<?
session_start();
include_once('../includes/php/session.php');
loginRequired();

$data = $_POST['data'];

$old = $data['old'];
$new = $data['new'];
$id = $data['id'];

$q = '';

if($old == 'uncategorized') {
  $q = 'INSERT INTO category VALUES (:id, :cat)';
} else {
  $q = 'UPDATE category SET category=:cat WHERE paper=:id';
}

$arr = array(':id'=>$id, ':cat'=>$new);

print pStmt($q, $arr);

?>