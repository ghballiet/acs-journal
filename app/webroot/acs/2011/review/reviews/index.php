<?
$_POST['page_title'] = 'Reviews';
$_POST['extra_css'] = array('review.css');
$_POST['loginRequired'] = md5(true);
$_POST['adminRequired'] = md5(true);
include_once('../template/before.php');

function getReviews() {
  $reviews = array();
  $q1 = 'SELECT DISTINCT user, submission FROM review';
  $r1 = query($q1);
  
  foreach($r1 as $r) {
    $u = $r['user'];
    $s = $r['submission'];
    
    $qUser = 'SELECT * FROM user WHERE id=:id';
    $qSub = 'SELECT * FROM view_submission WHERE id=:id';
    $qReview = 'SELECT * FROM review WHERE user=:user AND ' .
      'submission=:sub';
    
    $user = pQuery($qUser, array(':id'=>$u));
    $sub = pQuery($qSub, array(':id'=>$s));
    $rev = pQuery($qReview, array(':user'=>$u, ':sub'=>$s));
    
    $name = $sub['name'] . ' ' . $sub['surname'];
    
    if($name == $_SESSION['userName'])
      continue;
    
    $row = array();
    $row['user'] = $user;
    $row['submission'] = $sub;
    $row['review'] = $rev;
    
    $reviews[] = $row;
  }
  
  return $reviews;
}

$rev = getReviews();

?>

<fieldset>
  <h1>Reviews</h1>
  <section class="row header">
    <section class="title">Title</section>
    <section class="author">Author</section>
    <section class="user">Reviewer</section>
  </section>
<?
foreach($rev as $r) {
  $user = $r['user'][0];
  $sub = $r['submission'][0];
  $review = $r['review'][0];
  $link = md5($user['id'] . '-' . $sub['id']);

  printf('<section class="row">');
  printf('<section class="title">');
  printf('<a href="view.php?i=%s" target="_blank">%s</a>', 
    $link, $sub['title']);
  printf('</section>');
  printf('<section class="author">%s %s</section>', 
    $sub['name'], $sub['surname']);
  printf('<section class="user">%s %s</section>', 
    $user['name'], $user['surname']);
  printf('</section>');
}
?>
</fieldset>

<?
include_once('../template/after.php');
?>