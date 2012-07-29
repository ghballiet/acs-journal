<?
$this->start('css');
echo $this->Html->css('submission_info');
$this->end();

// links for things on the site
$format_pdf = $this->Html->url('/formats/format.pdf', true);
$formats = $this->Html->url('/formats', true);
$submit = $this->Html->url('/conference/submit', true);
$journal_submit = $this->Html->url('/journal/submit', true);
$faq = $this->Html->url('/faq', true);
$review_form = $this->Html->url('/review-form', true);
?>


<div class="page-header">
  <h1>Instructions for Authors</h1>      
</div>
<h2 id="aims">Aims and Themes</h2>
<p>We invite submissions to <i>Advances in Cognitive Systems</i>, a journal 
  that publishes contributions about human-level intelligence, complex
  cognition, integrated intelligent systems, cognitive architectures,
  and related topics. The journals aims to encourage research in the
  original spirit of artificial intelligence and cognitive science,
  which aimed to explain intelligence in computational terms and reproduce 
  the entire range of human cognitive abilities in computational artifacts.</p>

<p><i>Advances in Cognitive Systems</i> offers a venue to report work on any
  topic related to the representation or organization of complex mental
  structures, their use in multi-step cognition, or their acquisition
  from experience or instruction. Functional capabilities that arise in
  this context include:</p>

<ul>
  <li>Conceptual Inference and Reasoning</li>
  <li>Memory Storage and Retrieval</li>
  <li>Language Processing</li>
  <li>Social Cognition and Interaction</li>
  <li>High-level Execution and Control</li>
  <li>Problem Solving and Heuristic Search</li>
  <li>Metareasoning and Metacognition</li>
  <li>Structural Learning and Knowledge Capture</li>
</ul>

<p>Some research communities already address such issues, including those
  dealing with cognitive architectures, cognitive robotics, commonsense
  reasoning, and qualitative modeling, but none brings them together 
  in one place. We welcome submissions from those working on these and
  other topics who are interested in complex cognition, human-level
  intelligence, and related areas.</p>

<h2 id="format">Paper Format</h2>
<p><i>Advances in Cognitive Systems</i> will rely on electronic submission of
  papers for review and publication. Papers must not exceed sixteen
  (16) pages, including all figures, tables, and references. We will
  return to the authors any submissions that exceed this page limit or
  that diverge significantly from the format specified herein.</p>

<p>The text of the paper should be formatted in one column, with an
  overall width of 6.0 inches (15.24 cm) and length of 8.0 inches
  (20.32 cm). The left margin should be 1.25 inches (3.175 cm) and the
  top margin 1.5 inches (3.81 cm). The right and bottom margins will
  depend on whether one prints on US letter or A4 paper.</p> 

<p>The paper body should be set in 11 point type with a vertical spacing
  of 12 points. Please use Times Roman typeface throughout the text.
  Additional details about paper format are available at</p>

<h3>
<? echo $this->Html->link($format_pdf, $format_pdf, array('target'=>'_blank'));?>
</h3>

<p>We assume that authors will have access to LaTeX or Word to format their 
  documents and can use a Web browser to download style files and upload
  their papers. Electronic templates for producing the camera-ready copy
  are available for LaTeX and Microsoft Word. Templates are accessible
  on the Web at:</p>

<h3>
<? echo $this->Html->link($formats, $formats); ?>
</h3>

<p>Authors who have questions about these electronic templates should 
  send them to <a href="mailto:ACS <acs@cogsys.org>">acs@cogsys.org</a> by electronic mail.</p> 

<p>To ensure the ability to preview and print submissions, authors must
  provide their manuscripts in pdf format. Papers prepared in Word
  should be saved as pdf files and submitted in this format. To support
  the review process, each submission must be accompanied by information
  about the paper's title and abstract, as well as the authors' names
  and physical addresses. Authors must enter this information into the
  submission form at one of the URLs specified above.</p>

<p>Submissions may be accompanied by online appendices that contain 
  data, demonstrations, instructions for obtaining source code, or 
  the source code itself. We encourage authors to include such 
  appendices when they submit papers. This material will not count
  in the submission's page length. </p>

<h2 id="submission">Submission Process</h2>
<p><i>Advances in Cognitive Systems</i> will be associated with an annual
  conference with the same name, and many articles that appear in the
  journal will be submitted and reviewed under the auspices of this
  meeting. Authors who intend to submit a paper to the annual conference
  should upload their file to the submission repository at</p>

<h3>
<? echo $this->Html->link($submit, $submit); ?>
</h3>

<p>where <i>year</i> refers to the year during which the meeting will
  occur. Submission should be completed no later that 11:59 PM Pacific
  time on the conference due date, which will be stated clearly on the
  Web site. If a submission is late, it will not be considered for
  inclusion at the meeting.</p>

<p>In addition, the journal will also consider submissions that are not
  intended for presentation at the annual conference. Authors who wish
  to submit papers of this sort should upload their file to the submission 
  repository at</p>

<h3>
<? echo $this->Html->link($journal_submit, $journal_submit); ?>
</h3>

<p>Such submissions may occur at any time, unless they are related to
  special issues of the journal, which will have their own deadlines.</p>

<h2 id="originality">Originality</h2>
<p>Submissions to <i>Advances in Cognitive Systems</i> must be original. 
  The content should not have been published previously or be pending 
  publication in another journal, nor can it be under review or be 
  sent for review to another forum. Violation of this policy will 
  result in rejection of the submission and a six-month ban on further 
  submissions to the journal. </p>

<p>However, submissions to <i>Advances in Cognitive Systems</i> may contain 
  material published in one or more conference papers. Such submissions
  must contain at least 40 percent new, unpublished material that makes 
  substantial contributions, such as additional theoretical or experimental 
  results, or both. Authors must notify the Editor about previous or 
  pending conference publication at the time of submission. </p>

<h2 id="review">Review Process</h2>
<p>Because <i>Advances in Cognitive Systems</i> aims to encourage research 
  that produces a broad understanding of intelligence, its criteria for
  determining contributions will differ from those used in traditional
  publications. Progress may take many forms, including demonstrating 
  new functionality, integrating different facets of intelligence,
  presenting a novel approach to an established problem, explaining
  complex cognition in humans, and formally analyzing a difficult new
  task. We also welcome submissions on new problems or testbeds that
  challenge existing approaches.</p>

<p>Papers that report incremental variants of existing methods, minor
  improvements on performance metrics for established tasks, or
  mathematical analyses of component algorithms are not in themselves
  relevant to this meeting unless they aid progress toward cognitive
  systems with broad functionality. The frequently asked questions 
  page at </p>

<h3>
<? echo $this->Html->link($faq, $faq); ?>
</h3>

<p>provides additional information about the types of research that are 
  appropriate for submission to <i>Advances in Cognitive Systems</i>. </p>

<p>Each submission will be assigned to multiple referees who will
  evaluate the paper for its contribution to understanding cognitive
  systems, clarity of claims about this contribution, convincing
  evidence in support of those claims, and cogent presentation of its
  ideas to readers. We encourage authors to examine the review form at</p>

<h3>
<? echo $this->Html->link($review_form, $review_form); ?>
</h3>

<p>before drafting their manuscripts to ensure that their submissions
  address all of the dimensions on which reviewers will evaluate them.</p>

<p>Although some submissions will be accepted or rejected outright,
  others may be accepted conditionally. In such cases, the authors will
  receive an itemized list of changes they must make in their final
  paper. Revised papers that satisfy these conditions will be published
  in <i>Advances in Cognitive Systems</i>.</p>

