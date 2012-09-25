<?
$key = $_GET['key'];

$secret = 'ae49aca2e5216f4421fefcdc65368494';

if($key != $secret)
  header('Location: ../');
  
$_POST['page_title'] = 'View Submissions';
$_POST['extra_css'] = array('applicants.css');
include_once('../template/before2.php');
include_once('../includes/php/functions.php');
init();

$q = 'SELECT * FROM view_submission';
$res = query($q);

echo '<table>';
echo '<tr><th>Name</th><th>Email</th><th>Paper</th></tr>';

foreach($res as $r) {
  printf('<tr><td>%s %s</td><td><a href="mailto:%s">%s</a></td><td><a target="_blank" href="%s">%s</a></td></tr>',
    $r['name'], $r['surname'], $r['email'], $r['email'], $r['url'], $r['title']);
}

echo '</table>';

cleanup();
include_once('../template/after2.php');

?>