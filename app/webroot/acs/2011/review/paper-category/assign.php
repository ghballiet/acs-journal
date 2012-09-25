<?

$_POST['page_title'] = 'Assign Papers';
$_POST['extra_js'] = array('paperCategory.js');
$_POST['extra_css'] = array('paper.css', 'review_form.css',
  'review.css', 'category.css');
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

function getPapersByCategory($cat) {
  $q = 'SELECT v.* FROM view_submission v, category c WHERE ' .
    'v.id=c.paper AND c.category=:cat';
  return pQuery($q, array(':cat'=>$cat));
}

function getUncategorized() {
  $q = 'SELECT v.* FROM view_submission v WHERE id NOT IN ' .
    '(SELECT DISTINCT paper FROM category)';
  return query($q);
}

function showCategory($papers, $title, $categories) {
  printf('<fieldset id="%s">', str_replace(' ', '_', $title));
  printf('<h1>%s</h1>', $title);
  foreach($papers as $p) {
    printf('<section class="row">');
    printf('<section class="title"><span>%s</span>', $p['id']);
    printf('<a href="../paper/?id=%s">%s</a>', md5($p['paperID']), 
      $p['title']);
    printf('</section>');
    print('<section class="author">');
    
    printf('<select>');
    printf('<option></option>');
    foreach($categories as $c) {
      printf('<option value="%s">%s</option>', $c . '%' . $p['id'],
        $c);
    }    
    printf('</select>');

    printf('</section>');
    printf('</section>');
  }
  printf('</fieldset>');
}

$papers = array();

$uncat = getUncategorized();

foreach($categories as $c) {
  $papers[$c] = getPapersByCategory($c);
}

showCategory($uncat, 'uncategorized', $categories);

foreach($papers as $k=>$v)
  showCategory($v, $k, $categories);

?>



<?
include_once('../template/after.php');
?>