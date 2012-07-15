<?
// general variables to be used on the page
$submission = $data['Submission'];
$paper = $data['Paper'];
$final = $data['Final'];
$previous = $data['Previous'];
$category = $data['Category'];
$collection = $data['Collection'];
$author = $data['User'];
$modified = $this->Time->timeAgoInWords($submission['modified']);

$authors = array();
$authors[] = array($author['email'] => $this->Profile->name($author));
foreach($data['Coauthor'] as $coauthor)
  $authors[] = array($coauthor['email'] => $coauthor['name']);
?>

<div class="page-header">
  <h1>
    <? echo $submission['title']; ?>
    <small>modified <? echo $modified; ?></small>
  </h1>
</div>

<div class="row">
  <div class="span4">
    <div class="well">
      <h2>Abstract</h2>
      <div class="abstract"><? echo $abstract; ?></div>
    </div>
  </div>
  <div class="span8">
    <table class="table">
<?
pr($authors);
$rows = array(

);
?>      
    </table>
  </div>
</div>
