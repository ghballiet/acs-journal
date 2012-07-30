<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><? echo $title_for_layout; ?> | ACS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
<? echo $this->Html->css('http://fonts.googleapis.com/css?family=PT+Sans:400,700'); ?>
    <? echo $this->Html->css(array('base', 'home')); ?>
    <style type="text/css">
    body { padding-top: 40px; }
    </style>
<?
echo $this->Html->css(array(
  'http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css'));
?>
    <? echo $this->fetch('css'); ?>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<? echo $this->Html->url('/conference/2012'); ?>"><? echo $this->Html->image('acs_cropped_white.png'); ?></a>
          <div class="nav-collapse">
            <ul class="nav">
              <li><? echo $this->Html->link('Contents', '/journal/volume-1'); ?></li>
              <li><? echo $this->Html->link('Masthead', '/journal/masthead'); ?></li>
              <li><? echo $this->Html->link('FAQ', '/faq'); ?></li>
              <li><? echo $this->Html->link('Instructions', '/instructions'); ?></li>
            </ul>
            <ul class="nav pull-right">
<?
// dashboard
if(isset($user)) {
  echo $this->Bootstrap->navLink(
    'Dashboard', array('controller'=>'users', 'action'=>'dashboard'));
}

// administration menu
if(isset($user) && $user['is_admin'] == '1') {
  $title = 'Administration';
  $arr = array(array(
    'text'=>'Collections',
    'link'=>array(
      'controller'=>'collections', 
      'action'=>'manage'),
    'icon'=>'book'),
  );
  echo $this->Bootstrap->dropdown($title, $arr);
}
?>
              <li class="divider-vertical"></li>
<?php
$title = null;
$links = array();

if(!isset($user) || $user == null) {
  $title = 'Account';
  $links = array(
    array('text'=>'Log In', 'link'=>'/login', 'icon'=>'signin'),
    array('text'=>'Register', 'link'=>'/register', 'icon'=>'list-alt')
  );
} else {
  $image = $this->Profile->gravatar($user['email']);
  $title = sprintf('%s %s %s', 
                   $image, $user['name'], $user['surname']);
  $settings = array(
    'text' => 'Account Settings',
    'link' => array('controller'=>'users', 'action'=>'settings'),
    'icon' => 'cog'
  );
  $logout = array(
    'text' => 'Log Out', 
    'link' => array('controller'=>'users', 'action'=>'logout'),
    'icon' => 'signout'
  );
  $links = array($settings, true, $logout);
}
              
echo $this->Bootstrap->dropdown($title, $links);
?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container main">
      <? echo $this->Session->flash(); ?>
      <? echo $this->fetch('content'); ?>

      <footer>
        <p>Copyright &copy; 2012 Cognitive Systems Foundation. All Rights Reserved.</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?
    echo $this->Html->script(array(
      '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', 'bootstrap-transition', 'bootstrap-alert', 'bootstrap-modal', 'bootstrap-dropdown',
      'bootstrap-scrollspy', 'bootstrap-tab', 'bootstrap-tooltip', 'bootstrap-popover',
      'bootstrap-button', 'bootstrap-collapse', 'bootstrap-carousel', 'bootstrap-typeahead',
      'base'
    ));
    echo $this->fetch('scripts');
    ?>   
  </body>
</html>