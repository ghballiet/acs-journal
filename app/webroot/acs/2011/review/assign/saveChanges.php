<?
session_start();
include_once('../includes/php/session.php');
loginRequired();
adminRequired();

$data = $_POST['data'];
$kind = $data['kind'];
$paper = $data['paper'];
$user = $data['user'];
$q = '';

if($kind == 'insert')
  $q = 'INSERT INTO assignment VALUES (:user, :paper)';
else if($kind == 'delete')
  $q = 'DELETE FROM assignment WHERE user=:user AND paper=:paper';

$arr = array(':user'=>$user, ':paper'=>$paper);

print pStmt($q, $arr);

?>