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
//echo $run->settings['base_url'];


//ipsController::run();


  #remove the directory path we don't want
/*  $request  = str_replace("/envato/pretty/php/", "", $_SERVER['REQUEST_URI']);
 
  #split the path by '/'
  $params     = split("/", $request);*/
  define( 'IN_SCRIPT', 1 );
  
  if( strpos( $_SERVER['REQUEST_URI'], 'redirect' ) ){
		$redirect = 1;
	}
	if( strpos( $_SERVER['REQUEST_URI'], 'callback' ) ){
		$callback = 1;
	}
  if ($run->settings['force_login'] && $run->isLoggedIn() === false && !$redirect and !$callback) {
		include(ROOT_PATH . INCLUDES . '/' . 'login.php');
  } else {
		include(ROOT_PATH . INCLUDES . '/' .(isset($run->request['p']) ? basename($run->request['p'], '.php') : 'home') . '.php');
  }
  
  
exit();
//define( 'WEB_ROOT', rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' ) );
//define( 'INCLUDES_ROOT', 'includes/' );

// examples of rewrite rules ( $key = action, $value = regular expression )
//$rules = array( 
//    'pages' => "/(?'page'dashboard|about|login|signup)",   // e.g. '/about'
//    'gallery' => "/(?'username'[\w\-]+)/gallery",   // e.g. '/some-user/gallery'
//    'album' => "/(?'username'[\w\-]+)/(?'album'[\w\-]+)",   // e.g. '/some-user/some-album'
//    'picture' => "/(?'username'[\w\-]+)/(?'album'[\w\-]+)/(?'picture'[\w\-]+)",     // e.g. '/some-user/some-album/some-picture'
//    'home' => "/"   // e.g. '/'
//    );

// get uri
//$uri = '/' . trim( str_replace( WEB_ROOT, '', $_SERVER['REQUEST_URI'] ), '/' );

// test uri
//foreach ( $rules as $action => $rule ) {
//    $pattern = '/^'.str_replace( '/', '\/', $rule ).'$/';

//    if ( preg_match( $pattern, $uri, $params ) ) {
//        /* now you know the action and parameters so you can 
//         * include appropriate template file ( or proceed in some other way )
//         * NOTE: variable $params vill be visible in template ( use print_r( $params ) to see result )
//         */
//        include( INCLUDES_ROOT . $action . '.php' );
        // exit to avoid the 404 message 
//        exit();
//    }
//}

// nothing is found so handle 404 error
//include( INCLUDES_ROOT . '404.php' );
