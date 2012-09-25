<?
session_start();
include_once('../includes/php/session.php');
loginRequired();

$id = $_SESSION['userID'];

$q = 'SELECT * FROM assignment WHERE user=:id';
$papers = pQuery($q, array(':id'=>$id));

$info = array();

foreach($papers as $p) {
  $q = 'SELECT * FROM view_submission WHERE paperID=:id';
  $res = pQuery($q, array(':id'=>$p['paper']));
  $res[0]['secretID'] = md5($res[0]['id']);
  $info[] = $res[0];
}

print json_encode($info);

?>