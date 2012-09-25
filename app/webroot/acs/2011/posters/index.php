<?
$_POST['page_title'] = 'Posters';
$_POST['extra_css'] = array('posters.css');
$_POST['extra_js'] = array('viewAbstract.js');
include_once('../template/before2.php');
include_once('../includes/php/functions.php');
init();
$papers = query("SELECT DISTINCT id, name, surname, title, abstract
FROM view_submission WHERE id IN (SELECT paper FROM category WHERE
category LIKE '%poster%') ORDER BY surname, name, title");
?>

<h1>Posters</h1>

<table>
  <thead>
    <tr>
      <th>Authors</th>
      <th>Title</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
<?
foreach($papers as $p) {
  echo '<tr>';
  $q2 = 'SELECT DISTINCT name FROM coauthor WHERE paper=:id';
  $coauthors = pQuery($q2, array(':id'=>$p['id']));
  print '<td>';
  printf('%s %s', $p['name'], $p['surname']);
  if(sizeof($coauthors) > 0) {
    foreach($coauthors as $ca)
      print ', ' . $ca['name'];
  }
  print '</td>';
  $title = stripslashes($p['title']);
  $title = str_replace('–', '&mdash;', $title);
  $title = str_replace('\\', '', $title);
  printf('<td>%s</td>', $title);
  $abstract = stripslashes($p['abstract']);
  $abstract = str_replace('\\', '', $abstract);
  $abstract = str_replace('’', '\'', $abstract);
  $abstract = str_replace('"', '\'', $abstract);
  $abstract = str_replace('”', '\'', $abstract);
  if($abstract == 'null')
    $abstract = '<i>No abstract was provided for this poster.</i>';
  print '<td>';
  print '<a href="#" class="show_abstract">View Abstract</a>';
  printf('<input type="hidden" class="title" value="%s"/>', $title);
  printf('<input type="hidden" class="abstract" value="%s"/>', $abstract);
  print '</td>';
  echo '</tr>';
}
?>
  </tbody>
</table>

<div id="modal" class="reveal-modal">
  <h1></h1>
  <p></p>
  <a class="close-reveal-modal">&#215;</a>
</div>

<?
cleanup();
include_once('../template/after2.php');
?>