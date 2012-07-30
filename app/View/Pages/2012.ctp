<?
$this->start('css');
echo $this->Html->css('acs_2012');
$this->end();

// build the urls and links
$instructions = $this->Html->url('/instructions', true);
$submit = $this->Html->url(
array('controller'=>'submissions','action'=>'create'), true);
$review_form = $this->Html->url('/review-form', true);
?>

<div class="page-header">
  <h1>
    <span class="leading">First Annual Conference on</span>
    Advances in Cognitive Systems
    <small>December 7-9, 2012, Mountain View, California</small>
  </h1>
</div>

<h3 id="overview">Overview</h3>
<p>
  We invite submissions to the First Annual Conference on Advances in
  Cognitive Systems, which will take place in Mountain View, California,
  on December 7, 8, and 9, 2012. Like the 2011 Fall Symposium on the
  same topic, the meeting will bring together researchers with interests
  in human-level intelligence, complex cognition, integrated intelligent
  systems, cognitive architectures, and related topics. The purpose is
  to provide a venue for research on the initial goals of artificial
  intelligence and cognitive science, which aimed to explain the mind in
  computational terms and to reproduce the entire range of human
  cognitive abilities in computational artifacts. Because many
  researchers remain committed to this original vision, there is need
  for a meeting that provides a place to present recent results and pose
  new challenges for the field.
</p>

<p>
  The conference welcomes work on any topic related to the representation 
  or organization of complex mental structures, their use in multi-step
  cognition, or their acquisition from experience or instruction. Some
  functional capabilities that arise in this context include:
</p>

<ul class="columns clean">
  <li>Conceptual Inference and Reasoning</li>
  <li>Memory Storage and Retrieval</li>
  <li>Language Processing</li>
  <li>Social Cognition and Interaction</li>
  <li>High-level Execution and Control</li>
  <li>Problem Solving and Heuristic Search</li>
  <li>Metacognition and Meta-level Reasoning</li>
  <li>Structural Learning and Knowledge Capture</li>
</ul>

<p>
  Some research communities already address such issues, including those
  dealing with cognitive architectures, cognitive robotics, commonsense
  reasoning, qualitative modeling, and many others. We especially
  encourage participation from those working in these and other areas
  who are interested in complex cognition, human-level intelligence, 
  and related topics.
</p>

<h3 id="submission">Submission, Review, and Publication</h3>

<p>
  We also invite researchers to submit papers for presentation at the
  conference. Submissions should follow the instructions provided at</p>

<h4>
  <? printf('<a href="%s">%s</a>,', $instructions, $instructions); ?>
</h4>

<p>which gives detailed information about format and provides Latex and
  Word templates. Papers should be typeset in single column and should
  be no more than sixteen (16) pages in length. Any papers that diverge
  from this format or that exceed this length will be returned without
  review. All papers must be submitted electronically at</p>

<h4>
  <? printf('<a href="%s">%s</a>', $submit, $submit); ?>
</h4>

<p>In addition, each submission should state explicitly the problem or
  capability it addresses, describe its response to this problem, make
  claims about this approach, and provide evidence in support of these
  claims. Every paper should also discuss related efforts, examine
  limitations of the reported work, and outline plans for future
  research.
</p>

<p>
  Because the conference aims to encourage research toward a broader
  understanding of intelligence, its criteria for determining
  contributions will differ from those used in traditional circles. 
  Progress may take many forms, including demonstrating new 
  functionality, integrating different facets of intelligence,
  presenting a novel approach to an established problem, explaining
  complex cognition in humans, and formally analyzing a difficult new
  task. We also welcome submissions on new problems or testbeds that
  challenge existing approaches. Papers that report incremental
  variants of existing methods, minor improvements on performance
  metrics for established tasks, or mathematical analyses of component
  algorithms are not in themselves relevant to this meeting unless they
  directly aid progress toward cognitive systems with broad functionality.
</p>

<p>
  Each submission will be assigned to multiple referees who will
  evaluate the paper for its contribution to understanding cognitive
  systems, clarity of claims about this contribution, convincing
  evidence in support of those claims, and cogent presentation of its
  ideas to readers. We encourage authors to examine the <a
                                                           href="<? echo $review_form; ?>">review form</a> before
  drafting their manuscripts to ensure that their submissions address
  all of the dimensions on which reviewers will evaluate them. Accepted
  papers will appear in <i>Advances in Cognitive Systems</i>, an
  electronic journal associated with the conference.
</p>

<p>
  Although we expect most submissions to be accepted or rejected
  outright, some papers may be accepted conditionally. In such cases,
  the authors will receive an itemized list of changes they must make in
  their final paper. Revised papers that satisfy these conditions will
  be included in the journal. To improve overall quality of these
  publications, some submissions may be accepted on a conditional
  basis. We may accept some submissions for poster presentation at 
  the meeting.
</p>

<h3 id="info">Location, Dates, and Other Information</h3>

<p>
  The First Annual Conference on Advances in Cognitive Systems will run from
  Friday, December 7, through Sunday, December 9, 2012, in Mountain
  View, California. The meeting will include extended technical
  presentations, leisurely breaks to encourage discussions, and 
  receptions to foster additional interactions. 
</p>

<p>
  The conference aims to be as inclusive as possible while still
  fostering innovative research on the computational nature of
  intelligence. The conference FAQ page attempts to clarify the scope 
  of the event. Authors who have questions about whether their research 
  is appropriate for the meeting should contact the Program Chair, Pat
  Langley (<a href="mailto:Pat Langley <patrick.w.langley@gmail.com>">patrick.w.langley@gmail.com</a>),
  for additional information.
</p>

<h3>Important Dates</h3>
<ul class="columns clean">
  <li><b>September 1, 2012</b> Deadline for paper submission</li>
  <li><b>October 12, 2012</b> Decisions about paper acceptance</li>
  <li><b>November 9, 2012</b> Deadline for final papers</li>
  <li><b>December 7-9, 2012</b> Conference</li>
</ul>

<h3 id="organizing_committee">Organizing Committee</h3>
<ul class="columns clean">
  <li><b>Paul Bello</b> Office of Naval Research</li>
  <li><b>Kenneth Forbus</b> Northwestern University</li>
  <li><b>John Laird</b> University of Michigan, Ann Arbor</li>
  <li><b>Pat Langley</b> Arizona State University / University of Auckland</li>
  <li><b>Patrick Winston</b> Massachusetts Institute of 
    Technology</li>
</ul>

<h3 id="program_committee">Program Committee</h3>
<ul class="columns clean">
  <li><b>David Aha</b> Naval Research Laboratory</li>
  <li><b>Mike Barley</b> University of Auckland</li>
  <li><b>Balakrishnan Chandrasekaran</b> Ohio State University</li>
  <li><b>Gautam Biswas</b> Vanderbilt University</li>
  <li><b>Jim Blythe</b> University of Southern California</li>
  <li><b>Mark Burstein</b> Smart Information Flow Technologies</li>
  <li><b>Ron Brachman</b> Yahoo!</li>
  <li><b>Michael Cox</b> University of Maryland</li>
  <li><b>Randall Davis</b> Massachusetts Institute of Technology</li>
  <li><b>Susan Epstein</b> City University of New York</li>
  <li><b>Scott Fahlman</b> Carnegie Mellon University</li>
  <li><b>Ashok Goel</b> Georgia Institute of Technology</li>
  <li><b>Nick Hawes</b> University of Birmingham</li>
  <li><b>Randolph Jones</b> Soar Technology</li>
  <li><b>David McDonald</b> Smart Information Flow Technologies</li>
  <li><b>Karen Myers</b> SRI International</li>
  <li><b>Sergei Nirenburg</b> University of Maryland, Baltimore County</li>
  <li><b>Paul Rosenbloom</b> University of Southern California</li>
  <li><b>Claude Sammut</b> University of New South Wales</li>
  <li><b>Candy Sidner</b> Worcester Polytechnic Institute</li>
  <li><b>Bill Swartout</b> University of Southern California</li>
  <li><b>R. Michael Young</b> North Carolina State University</li>
</ul>
