<?
$_POST['page_title'] = 'View Applicants';
$_POST['extra_css'] = array('applicants.css');
$secret = "ae49aca2e5216f4421fefcdc65368494";

$key = $_GET['key'];

if($key != $secret)
  header('Location: ../');

include_once('../template/before2.php');
include_once('../includes/php/functions.php');
init();
?>

<h1>Applicants</h1>
<?
$q = "select a.*, c.name from application a, country c where a.country_id=c.id order by timestamp, a.last_name, a.first_name;";
$r = query($q);
?>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Organization</th>
      <th>Country</th>
      <th>Paper</th>
    </tr>
  </thead>
  <tbody>
<?
foreach($r as $row) {
  $fn = $row['first_name'];
  $ln = $row['last_name'];
  $em = $row['email'];
  $org = $row['organization'];
  $paper = $row['paper'];
  $id = $row['id'];
  $country = $row['name'];
  
  echo '<tr>';
  echo "<td><a href=\"view.php?uid=$id&key=$key\">$fn $ln</a></td>";
  echo "<td><a href=\"mailto:$em\">$em</a></td>";
  echo "<td>$org</td>";
  echo "<td>$country</td>";
  if($paper!="../uploads/.pdf")
    echo "<td><a target=\"_blank\" href=\"$paper\">View Paper</a></td>";
  else
    echo "<td>N/A</td>";
  echo '</tr>';
}
?>
  </tbody>
</table>

<?
cleanup();
include_once('../template/after2.php');
?>
