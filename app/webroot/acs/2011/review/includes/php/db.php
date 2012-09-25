<?

$GLOBALS['db_path'] = realpath('../../includes/db/main.db');
$GLOBALS['db'] = null;

function init() {
  $GLOBALS['db'] = new PDO('sqlite:' . $GLOBALS['db_path']);
  $GLOBALS['db']->sqliteCreateFunction('md5','md5');
}

function close() {
  $GLOBALS['db'] = null;
}

function query($q) {
  $r = $GLOBALS['db']->query($q);
  return $r->fetchAll();
}

function pQuery($q, $a) {
  $stmt = $GLOBALS['db']->prepare($q);
  
  $stmt->execute($a);
  
  return $stmt->fetchAll();
}

function pStmt($q, $a) {
  $stmt = $GLOBALS['db']->prepare($q);
  
  return $stmt->execute($a);
}

?>