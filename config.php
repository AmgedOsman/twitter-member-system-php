<?php

/**
 * @file
 * A single location to store configuration.
 */

define('CONSUMER_KEY', 'QiUFzHXBxU6P1PNL0q59b6hdk');
define('CONSUMER_SECRET', 'BrUQfkVoqPoWFjf2zUrWT4TbZTwups1mE43wCbN9e7wy61CvmE');
define('OAUTH_CALLBACK', 'http://localhost/twitter/tms/callback');

//-------------------
// Database
//---------------------
	define( 'dbhost', 'localhost' );// this will ususally be 'localhost', but can sometimes differ
	define( 'dbname', 'twitter_login' );// the name of the database that you are going to use for this project
	define( 'dbuser', 'Sacred' );// the username that you created, or were given, to access your database
	define( 'dbpass', '1234566' );// the password that you created, or were given, to access your database


// Get constants.php if it exists - this can be used to
// override any of the constants defined in this file without
if ( is_file( dirname( __FILE__ ) . '/constants.php' ) )
{
	require_once( dirname( __FILE__ ) . '/constants.php' );/*noLibHook*/
}
//include "settings.php";
//include(ROOT_DIR  . 'settings.php');
require_once(CLASSES . 'db/Database.php');
require_once(CLASSES . 'classTMS.php');
require_once(CLASSES . 'twitter/TwitterOAuth.php');
//require_once(ROOT_DIR . CLASSES . 'twitter/cTwitterStream.php');
