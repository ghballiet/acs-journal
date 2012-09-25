<?
session_start();
include_once('../includes/php/session.php');
loginRequired();

function checkPasswords($id, $old, $p1, $p2) {
  if(trim($old)=='' || trim($p1)=='' || trim($p2)=='')
    return 3;
    
  if($p1 != $p2)
    return 2;
    
  $q = 'SELECT * FROM user WHERE md5(id)=:id AND password=:password';
  $arr = array(':id'=>$id, ':password'=>md5($old));
  $r = pQuery($q, $arr);
  
  if(sizeof($r)==0)
    return 1;
  else
    return 0;
}

function changePassword($id, $pass) {
  $q = 'UPDATE user SET password=:password WHERE md5(id)=:id';
  $arr = array(':id'=>$id, ':password'=>md5($pass));
  pStmt($q, $arr);
  
  $q = 'DELETE FROM reset_password WHERE md5(user)=:id';
  $arr = array(':id'=>$id);
  pStmt($q, $arr);
}

$p = checkPasswords($_POST['userID'], $_POST['oldPass'],
  $_POST['pass1'], $_POST['pass2']);
  
if($p > 0) {
  header('Location: ../reset/?error=' . $p);
} else{ 
  changePassword($_POST['userID'], $_POST['pass1']);
  goHome();
}

?>