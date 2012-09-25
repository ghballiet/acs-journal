<?
  $_POST['page_title'] = 'Sample Review Form';
  include_once('../template/before.php');
?>

<h1>Review Form</h1>
<p>
  Please complete this review form offline and enter into appropriate
  fields on the Conference Master form. Give reasons that support your
  answers rather than simply checking boxes.
</p>

<ol>
  <li>
    <p>
      Does the paper address issues related to aspects of human-level
      intelligence, complex cognition, or similar topics?  Does it
      discuss these issues from a cognitive systems perspective?
    </p>
    <p>
      <span>
	<input type="radio" name="related" value="highly_related"
	       id="related1"/>
	<label for="related1">Highly related</label>
      </span>
      <span>
	<input type="radio" name="related" value="somewhat_related"
	       id="related2">
	<label for="related2"/>Somewhat related</label>
      </span>
      <span>
	<input type="radio" name="related" value="not_related"
	       id="related3"/>
	<label for="related3">Not related</label>
      </span>
    </p>
  </li>
  <li>
    <p>
      Do the authors present a problem or approach that extends or
      clarifies the capabilities of cognitive systems, or increase our
      understanding of their operation, in substantial ways?
    </p>
    <p>
      <span>
	<input type="radio" name="extension" value="major_extension"
	       id="extension1"/>
	<label for="extension1">Major extension</label>
      </span>
      <span>
	<input type="radio" name="extension"
	       value="reasonable_extension"
	       id="extension2"/>
	<label for="extension2"/>Reasonable extension</label>
      </span>
      <span>
	<input type="radio" name="extension" value="minor_extension"
	       id="extension3"/>
	<label for="extension3">Minor extension</label>
      </span>
    </p>
  </li>
  <li>
    <p>
      Does the paper make clear claims about the approach to cognitive
      systems? Such claims can take many forms, but they should be
      stated unambiguously in accessible language.
    </p>
    <p>
      <span>
	<input type="radio" name="claims" value="clear_claims"
	       id="claims1"/>
	<label for="claims1">Clear claims</label>
      </span>
      <span>
	<input type="radio" name="claims" value="vague_claims"
	       id="claims2"/>
	<label for="claims2">Vague claims</label>
      </span>
      <span>
	<input type="radio" name="claims" value="no_claims"
	       id="claims3"/>
	<label for="claims3">No claims</label>
      </span>
    </p>
  </li>
  <li>
    <p>
      Do the authors present convincing evidence that supports their
      claims? Such evidence can take different forms, but it should
      lead a reasonable person to conclude the claims are correct.
    </p>
    <p>
      <span>
	<input type="radio" name="convincing" value="very_convincing"
	       id="convincing1"/>
	<label for="convincing1">Very convincing</label>
      </span>
      <span>
	<input type="radio" name="convincing"
	       value="somewhat_convincing"
	       id="convincing2"/>
	<label for="convincing2">Somewhat convincing</label>
      </span>
      <span>
	<input type="radio" name="convincing" value="not_convincing"
	       id="convincing3"/>
	<label for="convincing3">Not convincing</label>
      </span>
    </p>
  </li>
  <li>
    <p>
      Does the paper's writing and organization present its ideas to
      readers effectively? Can moderately informed readers understand
      the main contributions and reconstruct the results if desired?
    </p>
    <p>
      <span>
	<input type="radio" name="effective" value="very_effective"
	       id="effective1"/>
	<label for="effective1">Very effective</label>
      </span>
      <span>
	<input type="radio" name="effective"
	       value="somewhat_effective" id="effective2"/>
	<label for="effective2">Somewhat effective</label>
      </span>
      <span>
	<input type="radio" name="effective"
	       value="not_effective" id="effective3"/>
	<label for="effective3">Not effective</label>
      </span>
    </p>
  </li>
  <li>
    <p>
      Based on the above comments, do you think the paper should be
      accepted for publication? If you favor conditional acceptance,
      please itemize the changes necessary for publication.
    </p>
    <p>
      <span>
	<input type="radio" name="accept" value="accept_paper"
	       id="accept1"/>
	<label for="accept1">Accept paper</label>
      </span>
      <span>
	<input type="radio" name="accept" value="conditional_accept"
	       id="accept2"/>
	<label for="accept2">Conditional accept</label>
      </span>
      <span>
	<input type="radio" name="accept" value="reject_paper"
	       id="accept3"/>
	<label for="accept3">Reject paper</label>
      </span>
    </p>
  </li>
  <li>
    <p>
      Do you have other comments that support your overall evaluation
      or do you have detailed suggestions for improving the paper?
    </p>
    <p>
      <textarea id="comments"
		placeholder="Comments and Suggestions"></textarea>
    </p>
  </li>
</ol>

<?
  include_once('../template/after.php');
?>
