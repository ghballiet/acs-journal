<?
session_start();
include_once('../includes/php/session.php');
loginRequired();
adminRequired();

$cat = $_POST['cat'];

function getCoauthors($paper) {
  $q = 'SELECT * FROM coauthor WHERE paper=:id';
  $ca = pQuery($q, array(':id'=>$paper));
  
  $authors = array();
  
  foreach($ca as $c) {
    $email = trim($c['email']);
    
    $name = $c['name'];
    $name = trim($name);
    $name = str_replace('\\', '', $name);
    
    if($email != '') {
      $authors[] = $name . ' <' . $email . '>';
    }
  }
  
  return $authors;
}

function sendMessage($id, $category) {
  // $id - the submission id
  // $category - the category (talk, poster, reject)
  
  $from = 'Pat Langley <langley@asu.edu>';
  $subject = 'ACS 2011 Submission Decision';
  
  $coauthors = getCoauthors($id);
  
  $q = 'SELECT * FROM view_submission WHERE id=:id';
  $r = pQuery($q, array(':id'=>$id));
  
  $r = $r[0];
  $title = $r['title'];
  $title = str_replace("\\", '', $title);
  
  $email = $r['email'];
  $name = $r['name'];
  $surname = $r['surname'];
  
  $to = $name . ' ' . $surname . ' <' . $email . '>';
  
  foreach($coauthors as $c) {
    $to .= ', ' . $c;    
  }
  
  $file = $category . '.txt';
  $contents = file_get_contents($file);
  
  $body = sprintf($contents, $title);

  $q2 = 'SELECT DISTINCT user FROM review WHERE submission=:id';
  $rev = pQuery($q2, array(':id'=>$id));
  
  $num = 1;

  foreach($rev as $rw) {
    $body .= getReview($rw['user'], $id, $num);
    $num++;
  }
  
  $headers = 'From: ' . $from . "\r\n";
  $headers .= "X-Mailer: php\r\n";
  $headers .= "Reply-To: " . $from . "\r\n";
  $headers .= "Return-Path: " . $from . "\r\n";
  $headers .= "Bcc: Glen Hunt <glenrhunt@asu.edu>\r\n";
  $headers .= "Content-Type: text/html\r\n";
  
  echo $to . "\n";
  
  mail($to, $subject, $body, $headers);
}

function getReview($user, $paper, $num) {
  // returns the HTML for a review in the email

  $q1 = "Does the paper address issues related to aspects of
  human-level intelligence, complex cognition, or similar topics? Does
  it discuss these issues from a cognitive systems perspective?";
  
   $q2 = "Do the authors present a problem or approach that extends or
  clarifies the capabilities of cognitive systems, or increase our
  understanding of their operation, in substantial ways?";
  
   $q3 = "Does the paper make clear claims about the approach to
  cognitive systems? Such claims can take many forms, but they should
  be stated unambiguously in accessible language.";
  
   $q4 = "Do the authors present convincing evidence that supports
  their claims? Such evidence can take different forms, but it should
  lead a reasonable person to conclude the claims are correct or
  plausible.";
  
   $q5 = "Does the paper's writing and organization present its ideas
  to readers effectively? Can moderately informed readers understand
  the main contributions and reconstruct the results if desired?";
  
   $q6 = "Do you have other comments that support your overall
  evaluation or do you have detailed suggestions for improving the
  paper?";
  
   $q7 = "Do you think the paper should be presented at the symposium
  as a talk, as a poster, or not at all? Both talks and posters will
  appear in the AAAI technical report for the meeting.";
  
   $q8 = 'Do you think the authors should be invited to publish their
  paper in the journal Advances in Cognitive Systems? If you favor
  conditional acceptance, please itemize the changes necessary for for
  journal publication.';
  
   $txt = '<div class="review">'; $txt .= '<h1>Review ' . $num .
  '</h1>'; $txt .= '<ol>';

  $txt .= '<li><p class="question">' . $q1 . '</p>';
  $txt .= boxes(array('Highly', 'Somewhat', 'Not'), $user, $paper, 
    'related'); 
  $txt .= '</li>';
  
  $txt .= '<li><p class="question">' . $q2 . '</p>';
  $txt .= boxes(array('Substantial', 'Reasonable', 'Insubstantial'), 
    $user, $paper, 'extension');
  $txt .= '</li>';
  
  $txt .= '<li><p class="question">' . $q3 . '</p>';
  $txt .= boxes(array('Vague', 'Clear', 'No'), $user, $paper, 
    'claims');
  $txt .= '</li>';
  
  $txt .= '<li><p class="question">' . $q4 . '</p>';
  $txt .= boxes(array('Very', 'Somewhat', 'Not'), $user, $paper, 
    'convincing');
  $txt .= '</li>';
  
  $txt .= '<li><p class="question">' . $q5 . '</p>';
  $txt .= boxes(array('Very', 'Somewhat', 'Not'), $user, $paper, 
    'effective');
  $txt .= '</li>';
  
  $txt .= '<li><p class="question">' . $q6 . '</p>';
  $txt .= boxes(array(), $user, $paper, 'comment');
  $txt .= '</li>';
  
  $txt .= '<li><p class="question">' . $q7 . '</p>';
  $txt .= boxes2(array('Accept as talk', 'Accept as poster', 
    'Reject paper'), $user, $paper, 'meeting');
  $txt .= '</li>';
  
  $txt .= '<li><p class="question">' . $q8 . '</p>';
  $txt .= boxes2(array('Accept paper', 'Accept conditionally', 
    'Reject paper'), $user, $paper, 'journal');
  $txt .= '</li>';

  $txt .= '</ol>';
  $txt .= '</div>';
  return $txt;
}

function boxes($opts, $user, $paper, $question) {
  $q = 'SELECT * FROM review WHERE user=:user AND submission=:paper' .
    ' AND question=:question';
  $res = pQuery($q, array(':user'=>$user, ':paper'=>$paper, 
    ':question'=>$question));
  $res = $res[0];
  $review = $res['review'];
  
  $s = '';
  foreach($opts as $o) {
    $s .= '<div>';
    $s .= '<input type="radio" disabled';    
    
    if(($o . ' ' . $question) == $review)
      $s .= ' checked';
    $s .= '>&nbsp;' . $o . ' ' . $question;
    $s .= '</div>';
  }
  $s .= '<p class="comments">';
  
  $comments = $res['comments'];
  $comments = str_replace("\\'", "'", $comments);
  $comments = str_replace('\\"', '"', $comments);
  
  $s .= $comments;
  $s .= '</p>';
  
  return $s;
}

function boxes2($opts, $user, $paper, $question) {
  $q = 'SELECT * FROM review WHERE user=:user AND submission=:paper' .
    ' AND question=:question';
  $res = pQuery($q, array(':user'=>$user, ':paper'=>$paper, 
    ':question'=>$question));
  $res = $res[0];
  $review = $res['review'];
  
  $s = '';
  foreach($opts as $o) {
    $s .= '<div>';
    $s .= '<input type="radio" disabled';    
    
    if(($o) == $review)
      $s .= ' checked';
    $s .= '>&nbsp;' . $o;
    $s .= '</div>';
  }
  $s .= '<p class="comments">';
  
  $comments = $res['comments'];
  $comments = str_replace("\\'", "'", $comments);
  $comments = str_replace('\\"', '"', $comments);
  
  $s .= $comments;
  $s .= '</p>';
  
  return $s;
}

function doCategory($cat) {
  printf('<pre style="font-family: monaco; font-size: 12px;' . 
    'overflow:hidden; margin-bottom: 4em;">');

  // actually do some stuff here.
  $q1 = 'SELECT v.* from view_submission v, category c WHERE ' .
    'c.paper=v.id AND c.category LIKE "%' . $cat . '%"';
  $talks = query($q1);
  // print sizeof($talks) . " " . $cat . "s.\n";

  foreach($talks as $t) {
    $title = $t['title'];
    $title = str_replace("\\", "", $title);
    $title = str_replace("–", "&mdash;", $title);
    $title = trim($title);
    $author = $t['name'] . ' ' . $t['surname'];
    $email = $t['email'];
    $name = $author . ' <' . $email . '>';
    // printf("  %-50s%s\n", $author, $title);
    sendMessage($t['id'], $cat);
  }

  print('</pre>'); 
}

// sendMessage(15, 'poster');

doCategory('talk');
doCategory('poster');
doCategory('reject');
?>