<?

include_once('../includes/php/markdown.php');

$GLOBALS['db_filename'] = realpath('../includes/db/main.db');
$GLOBALS['db'] = null;

function mark_file($file) {
  echo Markdown(file_get_contents($file));
}

function init() {
  $db = new PDO('sqlite:' . $GLOBALS['db_filename']);
  $GLOBALS['db'] = $db;
}

function cleanup() {
  $GLOBALS['db'] = NULL;
}

function query($query) {
  $results = array();
  $qresults = $GLOBALS['db']->query($query);

  $results = $qresults->fetchAll();

  return $results;
}

function pQuery($q, $a) {
  $stmt = $GLOBALS['db']->prepare($q);
  
  $stmt->execute($a);
  
  return $stmt->fetchAll();
}


function insert($query) {
  $count = NULL;
  $count = $GLOBALS['db']->exec($query);
  
  return $count;
}

function state() {
  $states = query('select * from state order by name');  

  echo '<select id="state" name="state">';
  echo '<option></option>';
  foreach($states as $s) {
    echo '<option value="' . $s['id'] . '" id="st' . $s['id'] . '">';
    echo $s['name']; 
    echo '</option>';
  }
  echo "</select>\n";
}

function country() {
  
  $countries = query('select * from country order by name');

  echo '<select id="country" name="country">';
  echo '<option></option>';

  foreach($countries as $c) {
    echo '<option value="' . $c['id'] . ' "';
    echo 'id="ct' . $c['id'] . '">';
    echo $c['name'];
    echo '</option>';
  }

  echo "</select>\n";
}

?>