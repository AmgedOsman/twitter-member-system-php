<?php

/**
 * @file
 * A single location to store configuration.
 */

define('CONSUMER_KEY', '');
define('CONSUMER_SECRET', '');
define('OAUTH_CALLBACK', 'http://domain.com/includes/callback.php');

//-------------------
// Database
//---------------------
	define( 'dbhost', 'localhost' );// this will ususally be 'localhost', but can sometimes differ
	define( 'dbname', 'dabase_name' );// the name of the database that you are going to use for this project
	define( 'dbuser', 'user' );// the username that you created, or were given, to access your database
	define( 'dbpass', 'pass' );// the password that you created, or were given, to access your database


// Get constants.php if it exists - this can be used to
// override any of the constants defined in this file without
if ( is_file( dirname( __FILE__ ) . '/constants.php' ) )
{
	require_once( dirname( __FILE__ ) . '/constants.php' );/*noLibHook*/
}
//include "settings.php";
//include(ROOT_DIR  . 'settings.php');
require_once(ROOT_DIR . ADMIN_DIR . '/Database.php');
require_once(ROOT_DIR . ADMIN_DIR . '/classTMS.php');

require_once(ROOT_DIR . ADMIN_DIR . '/TwitterOAuth.php');
require_once(ROOT_DIR . ADMIN_DIR . '/cTwitterStream.php');
