<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Start session and load lib */
session_start();

require_once('config.php');

/*LoadLibrary*/
$run = new classTMS();


	//
	// Index is Loaded!
	//
	define( 'IN_SCRIPT', 1 );
	
	
	//
	// Are we forcing Login?
	//
	if( strpos( $_SERVER['REQUEST_URI'], 'setup' ) ){
		$setup = 1;
	}
	if( strpos( $_SERVER['REQUEST_URI'], 'twitter' ) ){
		$twitter = 1;
	}
	if( strpos( $_SERVER['REQUEST_URI'], 'callback' ) ){
		$callback = 1;
	}
	if ($run->settings['force_login'] && $run->isLoggedIn() === false && !$twitter and !$callback and !$setup) {
		include(ROOT_PATH . INCLUDES . '/' . 'login.php');
	} else {
		include(ROOT_PATH . INCLUDES . '/' .(isset($run->request['p']) ? basename($run->request['p'], '.php') : 'home') . '.php');
	}
  
  
exit();
