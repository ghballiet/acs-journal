<?

$_POST['page_title'] = 'Paper Submission';
$_POST['extra_css'] = array('submit.css');
$_POST['extra_js'] = array('submit.js');
include_once('../template/before2.php');
include_once('../includes/php/functions.php');
init();

function item($name, $label, $kind) {
  $s = sprintf('<section id="s%s" class="cell">', $name);
  $s .= sprintf('<label for="%s">%s</label>', $name, $label);

  if($kind == 'textarea')
    $s .= sprintf('<textarea id="%s" name="%s"' . 
      'placeholder="%s">%s</textarea>',
		  $name, $name, $label, $_POST[$name]);
  else
    $s .= sprintf('<input type="%s" id="%s" name="%s"' .
		  'placeholder="%s" value="%s" required>', 
		  $kind, $name, $name, $label, $_POST[$name]);
  $s .= '</section>';
  echo $s;
}

function num($name, $label, $min, $max) {
  $s = sprintf('<section id="s%s" class="cell">', $name);
  $s .= sprintf('<label for="%s">%s</label>', $name, $label);
  $s .= sprintf('<select id="%s" name="%s">', $name, $name);
  for($i=$min; $i<=$max; $i++) {
    $s .= sprintf('<option value="%s">%s</option>', $i, $i);
  }
  $s .= '</select>';
  $s .= '</section>';
  echo $s;
}

?>

<? mark_file('submit.txt'); ?>

<form method="post" action="confirm.php"
      enctype="multipart/form-data">
  <h2>Contact Information</h2>
  <section class="row">
    <? item('name', 'Name', 'text'); ?>
    <? item('surname', 'Surname', 'text'); ?>
  </section>

  <section class="row">
    <? item('email', 'Electronic Mail', 'email'); ?>
    <? item('emailConfirm', 'Confirm Electronic Mail', 'email'); ?>
  </section>
  
  <section class="row">
    <? item('address1', 'Address', 'text'); ?>
  </section>

  <section class="row">
    <? item('address2', 'Address (Continued)', 'text'); ?>
  </section>

  <section class="row">
    <? item('city', 'City', 'text'); ?>
    <? item('state', 'State/Province', 'text'); ?>
  </section>

  <section class="row">
    <? item('postal', 'Postal Code', 'text'); ?>
    <section id="sCountry" class="cell">
      <label for="country">Country</label>
      <? country(); ?>
      <input type="hidden" id="countryName" name="countryName">
    </section>
  </section>

  <section class="row">
    <? item('phone1', 'Primary Telephone Number', 'tel'); ?>
    <? item('phone2', 'Secondary Telephone Number (Optional)', 'tel'); ?>
  </section>

  <h2>Submission Information</h2>

  <section class="row">
    <? item('paperTitle', 'Paper Title', 'text'); ?>
  </section>

  <section class="row">
    <? item('paperAbstract', 'Abstract', 'textarea'); ?>
  </section>
  
  <section class="row">
    <? item('paperPresenter', 'Presenter Name', 'text'); ?>
  </section>
  
  <section class="row">
    <? item('paperKeywords', 'Keywords', 'text'); ?>
    <? num('paperNumCoauthors', 'Number of Co-authors', 0, 10); ?>
  </section>
  
  <section id="coauthors">
  </section>

  <section class="row">
    <? item('paperFile', 'Paper Submission (PDF Only)', 'file'); ?>
  </section>

  <input type="button" id="submitApp" value="Confirm Submission">
</form>

<?
include_once('../template/after2.php');
?>
