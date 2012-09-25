<?
$_POST['page_title'] = 'Home';
$_POST['extra_css'] = array('reviewer.css');
// removed: papers will be loaded via PHP now
// $_POST['extra_js'] = array('reviewer.js');
$_POST['loginRequired'] = md5(true);
include_once('../template/before.php');

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

?>
<fieldset id="papers">
  <h1>Papers</h1>
<?
foreach($info as $p) {
  printf('<section id="p%s" class="paper">', $p['paperID']);
  printf('<section class="title">');
  printf('<a href="../paper/?id=%s">%s</a>', $p['secretID'],
    $p['title']);
  printf('</section>');
  printf('<section class="author">%s %s</section>', $p['name'],
    $p['surname']);
  printf('</section>');
}
?>
</fieldset>
<?
include_once('../template/after.php');
?>