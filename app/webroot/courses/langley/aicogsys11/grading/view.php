<? 
$hash = $_GET['id'];
$id = shell_exec('sqlite3 grades.db "select student_id from student_hash where hash=\'' . $hash . '\';"');
if($id == '') {
   $_POST['page_title'] = 'Uh-oh.';
   include_once('../template/before.php');
   echo '<h1 class="error">Error: student not found.</h1>';
   echo '<p class="error">I couldn\'t find the student you were looking for. How did you get here, anyway?</p>';
   include_once('../template/after.php');
   die();
}
$name = shell_exec('sqlite3 grades.db "select first_name || \' \' || last_name from students where id=' . $id . ';"');

$_POST['page_title'] = 'View Grades: ' . $name;
include_once('../template/before.php');

$asurite = get_info_by_id("asurite", $id);
$email = get_info_by_id("email", $id);
$course = get_info_by_id("course", $id);
$aliases = query("select alias from student_aliases where student_id=" . $id . ";");
$aliases = get_aliases($id);

?>
<h1>Student Info</h1>
<table>
<tr><th>Name</th><th>ASURITE</th><th>Aliases</th><th>Email</th><th>Course</th></tr>
<tr>
  <td><? echo $name; ?></td>
  <td><? echo $asurite; ?></td>
  <td><? echo $aliases; ?></td>
  <td><? echo $email; ?></td>
  <td>CSE <? echo $course; ?></td>
</tr>
</table>


<h1>All Grades</h1>
<table>
<tr><th>Exercise 1</th><th>Exercise 2</th><th>Average</th></tr>
<? echo get_grades($id, array("ex1","ex2")); ?>
</table>

<h2>Exercise 1</h2>
<? $g1 = get_grade($id, 1); ?>
<table>
  <tr>
    <th>A: Execution</th>
    <th>B: Completeness</th>
    <th>B: Neatness</th>
    <th>B: Correctness</th>
    <th>Total</th>
  </tr>
  <tr>
    <td><? echo $g1['a_execute']; ?>/2</td>
    <td><? echo $g1['b_complete']; ?>/2</td>
    <td><? echo $g1['b_neat']; ?>/2</td>
    <td><? echo $g1['b_correct']; ?>/2</td>
    <td><? echo $g1['total']; ?>/8</td>
  </tr>
</table>

<h2>Exercise 2</h2>
<? $g2 = get_grade($id, 2); ?>
<table>
  <tr>
    <th>Completeness</th>
    <th>Correctness</th>
    <th>Neatness</th>
    <th>Total</th>
  </tr>
  <tr>
    <td><? echo $g2['completeness']; ?>/3</td>
    <td><? echo $g2['correctness']; ?>/3</td>
    <td><? echo $g2['neatness']; ?>/2</td>
    <td><? echo $g2['total']; ?>/8</td>
  </tr>     
</table>

<?
include_once('../template/after.php');
?>
