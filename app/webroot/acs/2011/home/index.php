<?
$_POST['page_title'] = 'Home';
include_once('../template/before2.php');
include_once('../includes/php/functions.php');
?>

<? mark_file('home.txt'); ?>

<?
include_once('../template/after2.php');
?>

<script type="text/javascript">
$(document).ready(function() {
  $('#content h1:last + div ul').addClass('simple').addClass('columns');
  $('#content h1:last + div ul li strong').css('display','inline-block');
  $('#content h1:last + div ul li strong').css('width','150px');
  $('#content h1:last').prev().find('ul').addClass('simple').addClass('columns');
  $('#content h1:last').prev().find('ul li strong').css('display','inline-block');
  $('#content h1:last').prev().find('ul li strong').css('width','115px');

  $('#content h2 + ul').addClass('simple');
  $('#content h2 + ul li strong').css('display','inline-block');
  $('#content h2 + ul li strong').css('width','150px');
  $('#content h1:first + div ul').addClass('columns');
});
</script>
