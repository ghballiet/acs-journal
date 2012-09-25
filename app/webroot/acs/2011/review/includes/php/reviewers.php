<?

function getReviewers() {
  $q = 'SELECT * FROM user WHERE isAdmin=0 ORDER BY surname, name';
  $rows = query($q);
  
  foreach($rows as $r)
    getUser($r);
}

function getUser($r) {
  printf('<section class="row">');
  printf('<section class="name">%s</section>', $r['name'] . 
    ' ' . $r['surname']);
  printf('<section class="email"><a href="mailto:%s">%s</a>' .
    '</section>', $r['email'], $r['email']);
  printf('</section>');
}

function getAdmins() {
  $q = 'SELECT * FROM user WHERE isAdmin=1 ORDER BY surname, name';
  $rows = query($q);
  
  foreach($rows as $r) {
    getUser($r);
  }
}

?>