<?
session_start();
include_once('../includes/php/session.php');
loginRequired();

$user = $_POST['user'];
$submission = $_POST['submission'];

$q = 'SELECT * FROM review WHERE user=:user AND ' .
  'submission=:submission';
$r = pQuery($q, array(':user'=>$user,
  ':submission'=>$submission));
print json_encode($r);
?>