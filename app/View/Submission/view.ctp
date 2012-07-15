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
$authors[] = array(
  'name' => $this->Profile->name($author);
  'email' => $author['email'],
  'institution' => $author['institution']
);
foreach($data['Coauthor'] as $coauthor)
  $authors[] = $coauthor;
?>

<div class="page-header">
  <h1><? echo $submission['title']; ?></h1>
</div>

<div class="row">
  <div class="span4 left">
    <div class="authors">
<?

?>
    </div>
  </div>
  <div class="span8 right">
    <div class="abstract">
      <h3>Abstract</h3>
      <? echo $submission['abstract']; ?>
    </div>
  </div>
</div>
