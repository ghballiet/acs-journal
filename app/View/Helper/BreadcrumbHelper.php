<?
App::uses('AppHelper', 'View/Helper');

class BreadcrumbHelper extends AppHelper {
  public $helpers = array('Html');

  public function html($links, $title) {
    $html = '';
    $sep = '/';
    $divider = sprintf('<span class="divider">%s</span>', $sep);

    $html .= '<ul class="breadcrumb">';

    foreach($links as $link) {
      $html .= '<li>';
      $html .= $this->Html->link($link['text'], $link['link']);
      $html .= $divider;
      $html .= '</li>';
    }

    $html .= sprintf('<li class="active">%s</li>', $title);

    $html .= '</ul>';

    return $html;
  }
}
?>