<?
$_POST['page_title'] = 'Paper Details';
$_POST['extra_css'] = array('paper.css', 'review_form.css');
$_POST['extra_js'] = array('review_form.js');
$_POST['loginRequired'] = md5(true);
include_once('../template/before.php');

$id = $_GET['id'];
$q = 'SELECT * FROM view_submission WHERE md5(paperID)=:id';
$data = pQuery($q, array(':id'=>$id));
$d = $data[0];

$q2 = 'SELECT * FROM coauthor WHERE paper=:id';
$coauthors = pQuery($q2, array(':id'=>$d['paperID']));

$q3 = 'SELECT word FROM keyword WHERE paper=:id';
$keywords = pQuery($q3, array(':id'=>$d['paperID']));

$title = $d['title'];
$author = $d['name'] . ' ' . $d['surname'];
$author = trim($author);
$abstract = $d['abstract'];
$presenter = $d['presenter'];
$subId = $d['id'];

if($presenter == '')
  $presenter = 'Unspecified';

$url = $d['url'];
$url = 'http://cogsys.org/acs/2011/uploads/' . $url;

function getReviewers($id) {
  $q = 'SELECT DISTINCT user FROM review WHERE submission=:id';
  $rev = pQuery($q, array(':id'=>$id));
  return $rev;
}

function getReview($user, $id, $question) {
  $q = 'SELECT review, comments FROM review WHERE user=:user AND ' .
   'submission=:id AND question=:question';
  $r = pQuery($q, array(':user'=>$user, ':id'=>$id, 
    ':question'=>$question));
  $r = $r[0];
  return $r;
}
?>

<fieldset>
  <h1><? echo $title ?></h1>
  <section class="row" id="author">
    <section class="title">Authors</section>
    <section class="content"><span><? echo $author ?></span><?
foreach($coauthors as $ca) {
  printf(', %s', $ca['name']);
}
?>
    </section>
  </section>
  
  <section class="row">
    <section class="title">Presenter</section>
    <section class="content"><? echo $presenter ?></section>
  </section>
  
  <section class="row" id="keywords">
    <section class="title">Keywords</section>
    <section class="content">
<?
foreach($keywords as $k) {
  printf('<span>%s</span>', $k[0]);
}
?>      
    </section>
  </section>
  
  <section class="row">
    <section class="title">Abstract</section>
    <section class="content"><? echo $abstract ?></section>
  </section>

  <section class="row">
    <section class="title">URL</section>
    <section class="content">
      <a target="_blank" href="<? echo $url; ?>">
        Click here to view paper</a>
    </section>
  </section>
</fieldset>

<?

function printReview($r, $title, $num) {
  $rev = $r['review'];
  $com = $r['comments'];
  $com = str_replace('\\','', $com);
  
  printf('<section class="row">');
  printf('<section class="title">%d. %s</section>', $num, $title);
  printf('<section class="content">');
  printf('<p style="font-weight:bold;">%s</p>', $rev);
  printf('<p style="white-space:pre-wrap">%s</p>', $com);
  printf('</section>');
  printf('</section>');
}

if(isMember()) {
  // show reviews
  $reviewers = getReviewers($subId);
  $num = 1;

  foreach($reviewers as $user) {
    $user = $user[0];
    
    $q = 'SELECT * FROM user WHERE id=:id';
    $r = pQuery($q, array(':id'=>$user));
    $r = $r[0];
    $name = $r['name'] . ' ' . $r['surname'];
    
    $related = getReview($user, $subId, 'related');
    $extension = getReview($user, $subId, 'extension');
    $claims = getReview($user, $subId, 'claims');
    $convincing = getReview($user, $subId, 'convincing');
    $effective = getReview($user, $subId, 'effective');
    $comment = getReview($user, $subId, 'comment');
    $meeting = getReview($user, $subId, 'meeting');
    $journal = getReview($user, $subId, 'journal');
  
    printf('<fieldset>');
    printf('<h1>Review %d <span>%s</span></h1>', $num, $name);
    
    printReview($related, 'Related', 1);
    printReview($extension, 'Extension', 2);
    printReview($claims, 'Claims', 3);
    printReview($convincing, 'Convincing', 4);
    printReview($effective, 'Effective', 5);
    printReview($comment, 'Comments', 6);
    printReview($meeting, 'Symposium', 7);
    printReview($journal, 'Journal', 8);

    printf('</fieldset>');
  
    $num++;
  }
}
?>

<?
// don't do this any more
// if(isReviewer()) {
//   printf('<input type="hidden" name="userId" value="%d">',
//     $_SESSION['userID']);
//   printf('<input type="hidden" name="subId" value="%d">', 
//     $subId);
//   include_once('form.php');
// }
?>

<?
include_once('../template/after.php');
?>