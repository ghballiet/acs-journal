<?
include_once('../includes/php/functions.php');
init();

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$addr1 = $_POST['address1'];
$addr2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$postal = $_POST['postal'];
$country = intval($_POST['country']);
$phone1 = $_POST['phone1'];
$phone2 = $_POST['phone2'];
$numCoauthors = intval($_POST['paperNumCoauthors']);
$countryName = $_POST['countryName'];
unset($_POST['country']);

$paperTitle = $_POST['paperTitle'];
$paperAbstract = $_POST['paperAbstract'];
$paperPresenter = $_POST['paperPresenter'];
$paperURL = $_POST['paperFile'];

$keywords = explode(', ', $_POST['paperKeywords']);

$q1 = 'INSERT INTO paper VALUES (NULL,?,?,?)';
$s1 = $db->prepare($q1);
$s1->bindParam(1, $paperTitle);
$s1->bindParam(2, $paperAbstract);
$s1->bindParam(3, $paperURL);
$ok1 = $s1->execute();

$q2 = 'SELECT * FROM paper WHERE url=?';
$s2 = $db->prepare($q2);
$s2->bindParam(1, $paperURL);
$s2->execute();
$r2 = $s2->fetchAll();

$id = intval($r2[0]['id']);

$q3 = 'INSERT INTO submission VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,"",?)';
$s3 = $db->prepare($q3);
$s3->bindParam(1, $name);
$s3->bindParam(2, $surname);
$s3->bindParam(3, $email);
$s3->bindParam(4, $addr1);
$s3->bindParam(5, $addr2);
$s3->bindParam(6, $city);
$s3->bindParam(7, $state);
$s3->bindParam(8, $postal);
$s3->bindParam(9, $country);
$s3->bindParam(10, $phone1);
$s3->bindParam(11, $phone2);
$s3->bindParam(12, $id);
$s3->bindParam(13, $paperPresenter);
$ok2 = $s3->execute();

for($i=1; $i<=$numCoauthors; $i++) {
  $q = 'INSERT INTO coauthor VALUES (NULL, ?,?,?,?)';
  $s = $db->prepare($q);
  $s->bindParam(1, $_POST['caName' . $i]);
  $s->bindParam(2, $_POST['caEmail' . $i]);
  $s->bindParam(3, $_POST['caInstitution' . $i]);
  $s->bindParam(4, $id);
  $ok = $s->execute();
}

for($i=0; $i<sizeof($keywords);$i++) {
  $q = 'INSERT INTO keyword VALUES (?,?)';
  $s = $db->prepare($q);
  $s->bindParam(1, $id);
  $s->bindParam(2, $keywords[$i]);
  $ok = $s->execute();
}

include_once('success.php');

sendConfirmationEmail($_POST);

cleanup();
?>