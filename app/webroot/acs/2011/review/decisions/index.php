<?
$_POST['page_title'] = 'Decision Notices';
$_POST['loginRequired'] = md5(true);
$_POST['adminRequired'] = md5(true);

$_POST['extra_css'] = array('decisions.css');
include_once('../template/before.php');

function getCount($type) {
  $q = 'SELECT COUNT(*) AS num FROM category WHERE category IN (' .
    ':def, :poss)';
  $def = 'definite ' . $type;
  $poss = 'possible ' . $type;
  $r = pQuery($q, array(':def'=>$def, 'poss'=>$poss));
  $r = $r[0];
  return intval($r['num']);
}
?>

<fieldset>
  <h1>Decision Notifications</h1>
  <h2><? echo getCount('poster'); ?> posters</h2>
  <h2><? echo getCount('talk'); ?> talks</h2>
  <h2><? echo getCount('reject'); ?> rejections</h2>
  <form action="email.php" method="post">
    <input type="submit" id="sub" value="Send Notifications">
  </form>
</fieldset>

<?
include_once('../template/after.php');
?>