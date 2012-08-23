<?
App::uses('AppHelper', 'View/Helper');

class SubmissionHelper extends AppHelper {
  public $helpers = array('Html');

  public function badge($submission) {
    // builds a badge for the submission
    $sub = $submission['Submission'];
    $id = $sub['id'];
    $title = $sub['title'];

    $reviews = $submission['Review'];
    $num = count($reviews);
    $authors = array($submission['User']['full_name']);
    foreach($submission['Coauthor'] as $ca)
      $authors[] = $ca['name'];

    $str = sprintf('<div class="submission-badge" data-id="%s" data-reviews="%d">', $id, $num);

    // # reviews tag
    $str .= sprintf('<div class="num-reviews"><span>%d</span></div>', $num);

    // actual info
    $str .= '<div class="submission-info">';

    // title
    $str .= sprintf('<div class="submission-title">%s</div>', $title);

    // authors
    $str .= sprintf('<div class="submission-authors">%s</div>',
                    implode(', ', $authors));

    $str .= '</div>'; // end submission-info

    // clearfix
    $str .= '<div class="clearfix"></div>';

    $str .= '</div>'; // end submission-badge
    return $str;
  }
}

?>