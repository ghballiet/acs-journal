<?
$_POST['page_title'] = 'Attendance Confirmation';
$_POST['extra_css'] = array('applicants.css');
$secret = "ae49aca2e5216f4421fefcdc65368494";

$key = $_GET['key'];

if($key != $secret)
  header('Location: ../');

include_once('../template/before2.php');
include_once('../includes/php/functions.php');
init();
?>

<h1>Confirmed Attendance</h1>

<?
$q1 = 'SELECT COUNT(*) AS subs, SUM(num_papers) AS papers FROM ' .
  'attendance';
$q2 = 'SELECT COUNT(*) AS num, attending FROM attendance GROUP BY ' . 
  'attending ORDER BY attending';
$r = query($q1);
$r2 = query($q2);

$yes = $r2[2];
$no = $r2[1];
$na = $r2[0];

$row = $r[0];
?>

<ul>
  <li><b><?echo $row['subs'];?></b> have responded.</li>
  <li>There are <b><?echo $row['papers']?></b> papers in total.</li>
  <li><b><?echo $yes['num']?></b> say there is at least an 80% chance 
  they will attend.</li>
  <li><b><? echo $no['num']?></b> say there is a less than 80% chance
  they will attend.</li>
  <li><b><? echo $na['num']?></b> say they do not plan to submit a
  paper for which they will be first author.</li>
</ul>


<?
$q = 'SELECT * FROM attendance ORDER BY num_papers DESC,last_name, first_name, timestamp;';
$r = query($q);
?>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Attending</th>
      <th>Number of Papers</th>
      <th>Titles</th>
    </tr>
  </thead>
  <tbody>
<?
foreach($r as $row) {
  $fn = $row['first_name'];
  $ln = $row['last_name'];
  $attend = $row['attending'];
  $num = $row['num_papers'];
  $titles = $row['titles'];
  $titles = str_replace('^','<br>',stripslashes($titles));
  $name = $fn . ' ' . $ln;

?>
  <tr>
    <td><?echo $name;?></td>
    <td><?echo $attend;?></td>
    <td><?echo $num;?></td>
    <td><?echo $titles;?></td>
  </tr>
<?
}
?>
  </tbody>
</table>

<?
include_once('../template/after2.php');
?>
