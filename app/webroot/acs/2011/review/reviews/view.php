<?
$_POST['page_title'] = 'View Review';
$_POST['extra_css'] = array('review.css');
$_POST['loginRequired'] = md5(true);
$_POST['adminRequired'] = md5(true);
include_once('../template/before.php');
$id = $_GET['i'];

$q = 'SELECT * FROM review WHERE ' .
  'md5(user || "-" || submission)=:id';
$r = pQuery($q, array(':id'=>$id));

$reviews = array();
$comments = array();

foreach($r as $rev) {
  $question = $rev['question'];
  $review = $rev['review'];
  $comment = $rev['comments'];
  if($review == '')
    $review = '<span class="missing">No selection given.</span>';
  if($comment == '')
    $comment = '<span class="missing">No comments given.</span>';
  $reviews[$question] = $review;
  $comments[$question] = stripslashes($comment);
}

$r = $r[0];

$q1 = 'SELECT * FROM view_submission WHERE ' .
  'id=:id';
$q2 = 'SELECT * FROM user WHERE id=:id';

$r1 = pQuery($q1, array(':id'=>$r['submission']));
$r2 = pQuery($q2, array(':id'=>$r['user']));

$r1 = $r1[0];
$r2 = $r2[0];

$title = $r1['title'];
$author = $r1['name'] . ' ' . $r1['surname'];
$user = $r2['name'] . ' ' . $r2['surname'];
$email = $r2['email'];

?>

<fieldset>
  <h1><? echo $title; ?></h1>
  <h3>Reviewed by 
    <a href="mailto:<? echo $email; ?>"><? echo $user; ?></a>
  </h3>  
  <h2><? echo $author; ?></h2>
  <ol>
    <li>
      <section class="question">
        Does the paper address issues related to aspects of human-level intelligence, complex cognition, or similar topics? Does it discuss these issues from a cognitive systems perspective?
      </section>
      <section class="review">
        <? echo $reviews['related']; ?>
      </section>
      <section class="comments">
        <? echo $comments['related']; ?>
      </section>
    </li>

    <li>
      <section class="question">
        Do the authors present a problem or approach that extends or clarifies the capabilities of cognitive systems, or increase our understanding of their operation, in substantial ways?
      </section>
      <section class="review">
        <? echo $reviews['extension']; ?>
      </section>
      <section class="comments">
        <? echo $comments['extension']; ?>
      </section>
      
    </li>
    
    <li>
      <section class="question">
        Does the paper make clear claims about the approach to cognitive systems? Such claims can take many forms, but they should be stated unambiguously in accessible language.
      </section>
      <section class="review">
        <? echo $reviews['claims']; ?>
      </section>
      <section class="comments">
        <? echo $comments['claims']; ?>
      </section>
    </li>

    <li>
      <section class="question">
        Do the authors present convincing evidence that supports their claims? Such evidence can take different forms, but it should lead a reasonable person to conclude the claims are correct or plausible.        
      </section>
      <section class="review">
        <? echo $reviews['convincing']; ?>
      </section>
      <section class="comments">
        <? echo $comments['convincing']; ?>
      </section>
    </li>
    
    <li>
      <section class="question">
        Does the paper's writing and organization present its ideas to readers effectively? Can moderately informed readers understand the main contributions and reconstruct the results if desired?
      </section>
      <section class="review">
        <? echo $reviews['effective']; ?>
      </section>
      <section class="comments">
        <? echo $comments['effective']; ?>
      </section>
    </li>
    
    <li>
      <section class="question">
        Do you have other comments that support your overall evaluation or do you have detailed suggestions for improving the paper?
      </section>
      <section class="comments">
        <? echo $comments['comment']; ?>
      </section>      
    </li>

    <li>
      <section class="question">
        Do you think the paper should be presented at the symposium as a talk, as a poster, or not at all? Both talks and posters will appear in the AAAI technical report for the meeting.
      </section>
      <section class="review">
        <? echo $reviews['meeting']; ?>
      </section>
      <section class="comments">
        <? echo $comments['meeting']; ?>
      </section>
    </li>

    <li>
      <section class="question">
        Do you think the authors should be invited to publish their paper in the journal Advances in Cognitive Systems? If you favor conditional acceptance, please itemize the changes necessary for for journal publication.
      </section>
      <section class="review">
        <? echo $reviews['journal']; ?>
      </section>
      <section class="comments">
        <? echo $comments['journal']; ?>
      </section>      
    </li>
  </ol>
</fieldset>

<?
include_once('../template/after.php');
?>