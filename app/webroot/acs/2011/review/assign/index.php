<?
$_POST['page_title'] = 'Assign Papers';
$_POST['extra_css'] = array('assign.css', 'reviewers.css');
$_POST['extra_js'] = array('assign.js');
$_POST['loginRequired'] = md5(true);
$_POST['adminRequired'] = md5(true);
include_once('../template/before.php');

function getAvailablePapers() {
  $q = 'SELECT * FROM view_submission';
  return query($q);
}

function getCoauthors($id) {
  $q = 'SELECT * FROM coauthor WHERE paper=:id ORDER BY name';
  return pQuery($q, array(':id'=>$id));
}

function getReviewers() {
  $q = 'SELECT * FROM user WHERE isAdmin=0 ORDER BY surname, name';
  return query($q);
}

function getAssignments($id) {
  $q = 'SELECT * FROM view_submission WHERE paperID IN (' .
    'SELECT paper FROM assignment WHERE user=:id)';
  return pQuery($q, array(':id'=>$id));
}

function getAssignmentArray($papers) {
  $q = 'SELECT DISTINCT u.id AS uid, s.paperID AS pid FROM user u,' . 
    'view_submission s, assignment a WHERE a.user=u.id AND ' . 
    'a.paper=s.paperID';
  $rows = query($q);
  $arr = array();
  
  foreach($papers as $p) {
    $i = $p['paperID'];
    $arr[$i] = array();
  }
  
  foreach($rows as $r) {
    $pID = $r['pid'];
    $uID = $r['uid'];
    $arr[$pID][] = $uID;
  }
  
  return $arr;
}

$papers = getAvailablePapers();
$reviewers = getReviewers();
$assignments = getAssignmentArray($papers);
?>

<fieldset id="availablePapers">
  <h1>Papers</h1>
<?
foreach($papers as $p) {
  $id = $p['id'];
  $url = $p['url'];
  $title = $p['title'];
  $name = $p['name'];
  $surname = $p['surname'];

  printf('<section id="p%d" class="paper">', $id);
  printf('<section class="id">%d</section>', $id);
  printf('<section class="title"><a href="%s" target="_blank">' . 
    '%s</a></section>', '../paper/?id=' . md5($id), $title);
  printf('<section class="by">by</section>');
  printf('<section class="author">%s %s', $name, $surname);
  foreach(getCoauthors($id) as $c) {
    printf('<br><span>%s</span>', $c['name']);
  }
  printf('</section>');
  printf('<section class="assigned"><span>%d</span> ' .
    'reviewers</section>', sizeof($assignments[$id]));
  printf('<section class="btn"><span>Assign ' . 
    'Reviewers</span></section>');
  printf('</section>');
}
?>
</fieldset>

<?
include_once('../template/after.php');
?>