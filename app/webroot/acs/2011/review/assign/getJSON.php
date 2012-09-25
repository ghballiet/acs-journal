<?
session_start();
include_once('../includes/php/session.php');
loginRequired();

function getReviewers() {
  $q = 'SELECT * FROM user ORDER BY surname, name';
  return query($q);
}

function getAssignments($id) {
  $q = 'SELECT * FROM view_submission WHERE paperID IN (' .
    'SELECT paper FROM assignment WHERE user=:id) ' . 
    'ORDER BY id ASC';
  return pQuery($q, array(':id'=>$id));
}

function getReviewerInfo() {
  $review = getReviewers();
  $info = array();
  
  foreach($review as $r) {
    $arr = array();
    $arr['reviewer'] = $r;
    $assn = array();
    $assign = getAssignments($r['id']);
    foreach($assign as $a) {
      $assn[] = $a['paperID'];
    }
    $arr['assignments'] = $assn;
    $info[] = $arr;
  }
  
  return $info;
}

$type = $_GET['q'];

switch($type) {
  case 'reviewers':
    print json_encode(getReviewerInfo());  
    break;
}

?>