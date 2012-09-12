<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  public $components = array('Session', 'Auth' => array(
    'authenticate'=>array('Form'=>array('fields'=>
      array('username' => 'email')))));
  public $helpers = array('Html', 'Form', 'Session', 'BootstrapForm', 
                          'Bootstrap', 'Time', 'Profile', 'Breadcrumb',
                          'Submission');

  public function beforeFilter() {   
    $this->set('user', $this->Auth->user());
    $this->getReviews();
    $this->getRoles();
  }
  
  private function alert($title, $msg, $class, $closable = false) {
    $str = sprintf('<strong>%s</strong> %s', $title, $msg);
    if($closable)
      $str = sprintf('<a class="close" data-dismiss="alert" href="#">&times;</a>%s', $str);
    $class = sprintf('alert alert-%s fade in', $class);
    $this->Session->setFlash($str, 'default', array('class'=>$class));
  }
  
  public function alertError($title, $msg, $closable = false) {
    $this->alert($title, $msg, 'error', $closable);
  }
  
  public function alertSuccess($title, $msg, $closable = false) {
    $this->alert($title, $msg, 'success', $closable);
  }
  
  public function alertInfo($title, $msg, $closable = false) {
    $this->alert($title, $msg, 'info', $closable);
  }

  public function getReviews() {
    if($this->Auth->user() == null)
      return false;

    $this->loadModel('Review');
    $user_id = $this->Auth->user('id');
    $reviews = $this->Review->findAllByUserId($user_id);
    $this->set('user_reviews', $reviews);
    return $reviews;
  }

  public function getRoles() {
    // get the roles (if any) that are assigned to this user
    if($this->Auth->user() == null)
      return false;

    $this->loadModel('Role');
    $user_id = $this->Auth->user('id');
    $roles = $this->Role->find('all', array(
      'conditions' => array(
        'Role.user_id' => $user_id,
        'NOT' => array('Role.role_type_id' => 3)
      )
    ));
    $this->set('user_roles', $roles);
  }

  public function getCollections() {
    // return collections for the currently logged in user
    if($this->Auth->user() == null)
      return false;

    $this->loadModel('Role');
    $this->loadModel('Collection');
    $roles = $this->Role->findAllByUserId($this->Auth->user('id'));
    $coll_ids = array();
    foreach($roles as $role) {
      if($role['RoleType']['name'] == 'admin' || $role['RoleType']['name'] == 'editor')
        $coll_ids[] = $role['Collection']['id'];
    }

    $collections = $this->Collection->findAllById($coll_ids);
    return $collections;
  }
}
