<?
$asurite = $_POST['asurite'];
$password = $_POST['password'];

// $SECRET_KEY = "8cf5c997b9c98769fa72fd2bb11d76dc";
$SECRET_KEY = "140cc342129beab66a3f3742bdd7302e";

if(md5($password) != $SECRET_KEY) {
   header('Location: ./');
   die();
}

$query = "select distinct sh.hash from student_hash sh, students s, "
   . "student_aliases sa where (s.asurite='" 
   . $asurite . "' and s.id=sh.student_id) or "
   . "(sa.alias='" . $asurite . "' and sa.student_id=sh.student_id);";

$hash = shell_exec('sqlite3 grades.db "' . $query . '"');

header('Location: view.php?id=' . $hash);
?>
