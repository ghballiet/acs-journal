<?
// general variables to be used on the page
$submission = $data['Submission'];
$paper = $data['Paper'];
$final = $data['Final'];
$coauthors = $data['Coauthor'];
$keywords = $data['Keyword'];
$previous = $data['Previous'];
$category = $data['Category'];
$collection = $data['Collection'];
$modified = $this->Time->timeAgoInWords($submission['modified']);

?>

<div class="page-header">
  <h1>
    <? echo $submission['title']; ?>
    <small>modified <? echo $modified; ?></small>
  </h1>
</div>
