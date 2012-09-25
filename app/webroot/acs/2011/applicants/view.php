<?

$_POST['page_title'] = 'View Applicant';
$_POST['extra_css'] = array('applicants.css');
$secret = "ae49aca2e5216f4421fefcdc65368494";

$key = $_GET['key'];

if($key != $secret)
  header('Location: ../');

include_once('../template/before2.php');
include_once('../includes/php/functions.php');
init();

$id=$_GET['uid'];

$q = "select a.*, c.name from application a, country c where a.id='$id' and c.id=a.country_id;";
$res = query($q);
$r = $res[0];

$fn = $r['first_name'];
$ln = $r['last_name'];
$email = $r['email'];
$org = $r['organization'];
$addr = $r['address'];
$city = $r['city'];
$state = $r['state'];
$post = $r['postal'];
$country = $r['name'];
$paper = $r['paper'];
$ts = $r['timestamp'];
$summary = $r['summary'];

$name = "$fn $ln";
?>
<h1><?echo $name; ?></h1>
<p style="text-align:center"><a href="mailto:<?echo $email;?>"><?echo $email;?></a></p>

<div class="info">
<h2>Organization</h2>
<p><?echo $org;?></p>
</div>

<div class="info">
<h2>Address</h2>
<p>
<?echo $addr;?><br>
<?echo $city;?>, <?echo $state;?> <?echo $post;?><br>
<?echo $country;?>
</p>
</div>

<div class="info" id="summary">
<h2>Research Summary</h2>
  <p><?echo $summary; ?></p>
</div>

<? if($paper!="../uploads/.pdf") {?>
<div class="info">
   <p><a href="<?echo $paper;?>">View Paper</a></p>
</div>
<? } ?>

<?
cleanup();
include_once('../template/after2.php');
?>