<?
function checkboxes($name, $opts) {
  printf('<section class="options">');
  $num = 1;
  
  foreach($opts as $o) {
    printf('<section class="opt">');
    printf('<input type="radio" name="%s" id="%s" value="%s">',
      $name, $name . $num, $o);
    printf('<label for="%s">%s</label></section>',
      $name . $num, $o);
    $num++;
  }
  printf('</section>');
  printf('<section class="options">');
  printf('<textarea id="%sComments" name="%sComments" ' . 
    'placeholder="Comments"></textarea>', $name, $name);
  printf('</section>');
}

?>

<fieldset id="review_form">
  <input type="hidden" name="user"
    value="<? echo $_SESSION['userID']; ?>">
  <input type="hidden" name="paper"
    value="<? echo $subId; ?>">
  <h1>Review Form</h1>
  <ol>
    <li>
      <p>Does the paper address issues related to aspects of human-level intelligence, complex cognition, or similar topics? Does it discuss these issues from a cognitive systems perspective?</p>
<? checkboxes('related', array('Highly related', 'Somewhat related',
  'Not related'));?>
    </li>
    <li>
      <p>Do the authors present a problem or approach that extends or clarifies the capabilities of cognitive systems, or increase our understanding of their operation, in substantial ways?</p>
<?
checkboxes('extension', array('Substantial extension',
  'Reasonable extension', 'Insubstantial extension'));
?>      
    </li>
    <li>
      <p>Does the paper make clear claims about the approach to cognitive systems? Such claims can take many forms, but they should be stated unambiguously in accessible language.</p>
<?
checkboxes('claims', array('Clear claims', 'Vague claims',
  'No claims'));
?>  
    </li>
    <li>
      <p>Do the authors present convincing evidence that supports their claims? Such evidence can take different forms, but it should lead a reasonable person to conclude the claims are correct or plausible.</p>
<?
checkboxes('convincing', array('Very convincing', 
  'Somewhat convincing', 'Not convincing'));
?>
    </li>
    <li>
      <p>Does the paper's writing and organization present its ideas to readers effectively? Can moderately informed readers understand the main contributions and reconstruct the results if desired?</p>
<?
checkboxes('effective', array('Very effective', 'Somewhat effective', 
  'Not effective'));
?>      
    </li>
    <li>
      <p>Do you have other comments that support your overall evaluation or do you have detailed suggestions for improving the paper?</p>
      <section class="options">
        <textarea id="commentComments" name="commentComments"
        placeholder="Comments and Suggestions"></textarea>
      </section>
    </li>
    <li>
      <p>Do you think the paper should be presented at the symposium as a talk, as a poster, or not at all? Both talks and posters will appear in the AAAI technical report for the meeting.</p>
<?
checkboxes('meeting', array('Accept as talk', 'Accept as poster',
'Reject paper'));
?>
    </li>
    <li>
      <p>Do you think the authors should be invited to publish their paper in the journal Advances in Cognitive Systems? If you favor conditional acceptance, please itemize the changes necessary for for journal publication.</p>
<?
checkboxes('journal', array('Accept paper', 'Accept conditionally',
'Reject paper'));
?>
    </li>
  </ol>
  <span id="btn">Save Review</span>
</fieldset>