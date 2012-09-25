<?
session_start();
include_once('../includes/php/session.php');
loginRequired();

$d = $_POST['data'];

$user = intval($d['user']);
$submission = intval($d['submission']);
$comments = $d['comments'];
$question = $d['question'];
$review = '';

if($d['review'] != null && isset($d['review']))
  $review = $d['review'];
  
$q1 = 'SELECT * FROM review WHERE user=:user AND ' .
  'submission=:submission AND question=:question';
$r1 = pQuery($q1, array(
  ':user'=>$user,
  ':submission'=>$submission,
  ':question'=>$question
));

$len = sizeof($r1);
if($len == 0) {
  // questions has not been inserted into the database yet
  $q2 = 'INSERT INTO review VALUES (:user, :submission, :question, ' . 
    ':review, :comments)';
  $r2 = pStmt($q2, array(
    ':user'=>$user,
    ':submission'=>$submission,
    ':question'=>$question,
    ':review'=>$review,
    ':comments'=>$comments
  ));
} else {
  $q3 = 'UPDATE review SET review=:review, comments=:comments ' . 
    'WHERE user=:user AND submission=:submission AND ' .
    'question=:question';
  $r3 = pStmt($q3, array(
    ':user'=>$user,
    ':submission'=>$submission,
    ':question'=>$question,
    ':review'=>$review,
    ':comments'=>$comments
  ));
}
?>