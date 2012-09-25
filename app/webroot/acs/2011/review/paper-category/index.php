<?
$_POST['page_title'] = 'Paper Categorization';

$_POST['extra_css'] = array('paper.css', 'review_form.css',
  'review.css');
$_POST['loginRequired'] = md5(true);
include_once('../template/before.php');

$categories = array(
  'definite talk',
  'possible talk',
  'definite poster',
  'possible poster',
  'definite reject',
  'major conflict'
);

function getReviews() {
  if(!isMember())
    return false;
  
  $q1 = 'SELECT DISTINCT submission FROM review ORDER BY submission';
  $q2 = 'SELECT * FROM review WHERE submission=:id AND ' .
    'question="meeting"';
  $reviews = array();
  $reviews['definite talk'] = array();
  $reviews['possible talk'] = array();
  $reviews['definite poster'] = array();
  $reviews['possible poster'] = array();
  $reviews['definite reject'] = array();
  // $reviews['single review'] = array();
  
  $papers = query($q1);
  foreach($papers as $p) {
    $id = $p['submission'];
    $revs = pQuery($q2, array(':id'=>$id));

    // if(sizeof($revs) == 1) {
    //   $reviews['single review'][] = $id;
    //   continue;
    // }
      
    $r1 = $revs[0];
    $r2 = $revs[1];
    
    $m1 = $r1['review'];
    $m2 = $r2['review'];
    
    if($m1 == $m2) {
      if($m1 == 'Accept as talk')
        $reviews['definite talk'][] = $id;
      else if($m1 == 'Accept as poster')
        $reviews['definite poster'][] = $id;
      else if($m1 == 'Reject paper')
        $reviews['definite reject'][] = $id;
    } else {
      // this means they don't agree
      
      // 1: accept as talk
      if($m1 == 'Accept as talk') {
        if($m2 == 'Accept as poster')
          $reviews['possible talk'][] = $id;
        else if($m2 == 'Reject paper')
          $reviews['major conflict'][] = $id;
      }
      
      // 1: accept as poster
      if($m1 == 'Accept as poster') {
        if($m2 == 'Accept as talk')
          $reviews['possible talk'][] = $id;
        else if($m2 == 'Reject paper')
          $reviews['possible poster'][] = $id;
      }
      
      // 1: reject paper
      if($m1 == 'Reject paper') {
        if($m2 == 'Accept as talk')
          $reviews['major conflict'][] = $id;
        else if($m2 == 'Accept as poster')
          $reviews['possible poster'][] = $id;
      }
    }
  }
  
  return $reviews;
}

function getCategory($paper) {
  $q = 'SELECT category FROM category WHERE paper=:id';
  $r = pQuery($q, array(':id'=>$paper));
  $r = $r[0];
  
  return $r['category'];
}

function saveCategory($paper, $cat) {
  $categ = getCategory($paper);
  
  if($categ == '') {
    $q = 'INSERT INTO category VALUES (:paper, :cat)';
    pStmt($q, array(':paper'=>$paper, ':cat'=>$cat));
  }
}

function getInfo($id) {
  $q = 'SELECT * FROM view_submission WHERE paperId=:id';
  return pQuery($q, array(':id'=>$id));
}

$rev = getReviews();
foreach($rev as $c=>$v) {
  printf('<fieldset>');
  printf('<h1>%s<span>%d</span></h1>', $c, sizeof($v));
  foreach($v as $r) {
    saveCategory($r, $c);
    
    $info = getInfo($r);
    $info = $info[0];
    
    if($info['title'] == '') {
      printf('<section class="row">%s</section>', $r);
      continue;
    }
      
    printf('<section class="row">');      
    
    $title = $info['title'];
    $author = $info['name'] . ' ' . $info['surname'];
    
    printf('<section class="title">');
    printf('<span>%s</span><a href="../paper/?id=%s">%s</a>', $r, md5($r), $title);
    printf('</section>');
    
    printf('<section class="author">%s</section>', $author);
    printf('</section>');
  }
  printf('</fieldset>');
}

include_once('../template/after.php');
?>