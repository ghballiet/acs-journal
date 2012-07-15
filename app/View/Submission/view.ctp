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
  'name' => $this->Profile->name($author),
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
  <div class="span3 left">
    <div class="authors">
      <h3>Authors</h3>
      <ul class="nav nav-pills nav-stacked">
<?
// TODO: add user badges (using the profile helper)
foreach($authors as $a) {
  printf('<li><a href="mailto:%s">%s</a></li>', 
         $a['email'], $a['name']);
}
?>
      </ul>
    </div>
  </div>
  <div class="span9 right">
    <div class="abstract">
      <h3>Abstract</h3>
      <? echo $submission['abstract']; ?>
    </div>
  </div>
</div>
