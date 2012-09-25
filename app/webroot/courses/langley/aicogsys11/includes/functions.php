<?php
include_once('markdown.php');

function mark_file($file) {
  $contents = file_get_contents($file);
  return Markdown($contents);
}

function query($query) {
  return trim(shell_exec('sqlite3 ../grading/grades.db "'
			 . $query . '"'));
}

function query_opts($options, $query) {
  return trim(shell_exec('sqlite3 ' . $options . ' ../grading/grades.db "'
			 . $query . '"'));
}

function get_info_by_id($info, $id) {
  return query("select $info from students where id=$id;");
}

function get_aliases($id) {
  $aliases = query("select alias from student_aliases where student_id=$id;");
  return str_replace("\n", "<br/>", $aliases);
}

function get_grades($id, $assn) {
  $exercises = implode(", ", $assn);
  return query_opts("-html", "select $exercises, avg from view_grades where id=$id;");
}

function get_grade($id, $ex) {
  $grades=query_opts("-separator ',' -header",
		     "select * from view_ex$ex where student_id=$id");
  $arr = explode("\n",$grades);
  unset($arr[2]);
  $headers = explode(",", $arr[0]);
  $values = explode(",", $arr[1]);
  $results = array();

  for($i = 0; $i < sizeof($headers); $i++) {
    $results[$headers[$i]] = $values[$i];
  }

  unset($results['student_id']);
  unset($results['course']);
  unset($results['first_name']);
  unset($results['last_name']);		    

  return $results;
}

function get_hash($id) {
  return query("select hash from student_hash where student_id=$id;");
}
?>
