<?

$_POST['page_title'] = 'Confirm Submission';
$_POST['extra_css'] = array('submit.css');
$_POST['extra_js'] = array('confirm.js');
include_once('../template/before2.php');

$f = $_FILES['paperFile']['tmp_name'];

$dest = '../uploads/' . basename($f) . '.pdf';

$data = $_POST;
unset($data['extra_css']);
unset($data['extra_js']);
unset($data['page_title']);
$data['paperFile'] = $dest;

if(move_uploaded_file($f, $dest))
   $url = 'http://cogsys.org/acs/2011/uploads/' . basename($f) . '.pdf';
else
   $url = '';

function item($label, $name) {
  $s = '<section class="cell">';
  $s .= sprintf('<section>%s</section><section>%s</section>', 
   $label, $_POST[$name]);
  $s .= '</section>';
  echo $s;
}

function keywords() {
  $keywords = $_POST['paperKeywords'];
  $words = explode(', ', $keywords);
  $s = '<section class="cell">';
  $s .= '<section>Keywords</section>';
  $s .= sprintf('<section><span>%s</span></section>',
		implode('</span><span>', $words));
  $s .= '</section>';
  echo $s;
}

function coauthors() {
  $num = floor($_POST['paperNumCoauthors']);
  $s .= '<section class="cell">';
  $s .= '<section>Co-authors</section>';
  $s .= '<section>';

  $s .= '<ul>';
  for($i=1; $i<=$num; $i++) {
    $cName = $_POST['caName' . $i];
    $cEmail = $_POST['caEmail' . $i];
    $cInst = $_POST['caInstitution' . $i];
    $s .= sprintf('<li><b>%s:</b> %s, %s</li>', $cName,
		  $cEmail, $cInst);
  }
  $s .= '</ul>';

  $s .= '</section>';
  $s .= '</section>';
  echo $s;
}

function paper($url) {
  $s = '<section class="cell">';
  $s .= '<section>Preview of Uploaded Paper</section>';
  $s .= '<section>';
  if($url != '') {
    $s .= '<a target="_blank" href="' . $url . '">Click here to view your paper</a>';
  }
  $s .= '</section>';
  $s .= '</section>';
  echo $s;
}
?>

<section id="data" style="display:none"><?echo json_encode($data); ?></section>

<h1>Confirm Details</h1>
<p>Please verify the details of your submission below.</p>

<section id="confirm">
  <h2>Contact Information</h2>
  <section class="row">
    <? item('Name', 'name'); ?>
    <? item('Surname', 'surname'); ?>
    <? item('Email', 'email'); ?>
  </section>
  <section class="row">
    <? item('Address 1', 'address1'); ?>    
  </section>
  <section class="row">
    <? item('Address 2', 'address2'); ?>
  </section>
  <section class="row">
    <? item('City', 'city'); ?>
    <? item('State/Province', 'state'); ?>
  </section>
  <section class="row">
    <? item('Postal Code', 'postal'); ?>
    <? item('Country', 'countryName'); ?>
  </section>
  <section class="row">
    <? item('Primary Telephone Number', 'phone1'); ?>
    <? item('Secondary Telephone Number', 'phone2'); ?>
  </section>
  
  <h2>Submission Details</h2>
  <section class="row">
    <? item('Title', 'paperTitle'); ?>
  </section>
  <section class="row">
    <? item('Abstract', 'paperAbstract'); ?>
  </section>
  <section class="row">
    <? item('Presenter Name', 'paperPresenter'); ?>
  </section>
  <section class="row">
    <? keywords(); ?>
  </section>
  <section class="row">
  <? coauthors(); ?>
  </section>
  <section class="row">
  <? paper($url); ?>
  </section>
  <section class="row">
    <input type="button" id="edit" value="Edit Application" class="cancel">
    <input type="button" id="submit" value="Submit Application">
  </section>
</section>

<?
  include_once('../template/after2.php');
?>