<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::parseExtensions('pdf');


Router::connect('/', array('controller'=>'pages', 'action'=>'display', '2012'));
Router::connect('/acs/2012', array('controller'=>'pages', 'action'=>'display', '2012'));
// Router::connect('/acs/2011', '/acs-old/');
Router::connect('/login', array('controller'=>'users', 'action'=>'login'));
Router::connect('/logout', array('controller'=>'users', 'action'=>'logout'));
Router::connect('/register', array('controller'=>'users', 'action'=>'register'));
Router::connect('/dashboard', array('controller'=>'users', 'action'=>'dashboard'));
Router::connect('/submit', array('controller'=>'submissions', 'action'=>'create'));
Router::connect('/journal/submit', array(
  'controller'=>'submissions', 'action'=>'create', 'volume-2'));
Router::connect('/conference/submit', array(
  'controller'=>'submissions', 'action'=>'create', 'acs-2012'));
Router::connect('/journal/volume-1', array(
  'controller'=>'pages', 'action'=>'display', '2012-editorial-contents'));
Router::connect('/journal/masthead', array('controller'=>'pages', 'action'=>'display', 'masthead'));
Router::connect('/journal', array('controller'=>'pages', 'action'=>'display', 'home'));
Router::connect('/conference/2012', array('controller'=>'pages', 'action'=>'display', '2012'));
Router::connect('/paper/*', array('controller'=>'submissions', 'action'=>'view'));
Router::connect('/pdf/*', array('controller'=>'submissions', 'action'=>'paper'));
Router::connect('/journal/*', array('controller'=>'collections', 'action'=>'contents'));

// named route for assigning roles in collections
Router::connect(
  '/collections/assign_role/:user/:role/:type',
  array(
    'controller'=>'collections',
    'action'=>'assign_role'
  ),
  array('pass' => array('user', 'role', 'type'))
);

// named route for removing role
Router::connect(
  '/collections/remove_role/:id',
  array(
    'controller'=>'collections',
    'action'=>'remove_role'
  ),
  array('pass'=>array('id'))
);

// catchall for controller/action
Router::connect('/:controller/:action/*');

Router::connect('/*', array('controller'=>'pages', 'action'=>'display'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
