<?php

//define('ADMIN_DIR', $_SERVER['DOCUMENT_ROOT'].'/admin/');


if ( !defined( 'PUBLIC_DIR' ) )
{
	define( 'PUBLIC_DIR', 'public' );
}

if ( !defined( 'ADMIN_DIR' ) )
{
	define( 'ADMIN_DIR', 'admin' );
}

if ( !defined( 'INCLUDES' ) )
{
	define( 'INCLUDES', 'includes' );
}
/**
* ROOT PATH
*/

if ( !defined( 'ROOT_DIR' ) )
{
	define('ROOT_DIR', dirname( __FILE__ ) . '/');
}
/**
* ROOT PATH
*/
if ( !defined( 'ROOT_PATH' ) )
{
	define( 'ROOT_PATH', str_replace( "\\", "/", dirname( __FILE__ ) ) . '/' );
}

/**
* "PUBLIC" ROOT PATH
*/
if ( !defined( 'PUBLIC_PATH' ) )
{
	define( 'PUBLIC_PATH', ROOT_PATH . PUBLIC_DIR . "/" );
}


/**
* "ADMIN" ROOT PATH
*/
if ( !defined( 'ADMIN_PATH' ) )
{
	define( 'ADMIN_PATH', ROOT_PATH . ADMIN_DIR . "/" );
}
/**
* "CLASSES" PATH
*/
if ( !defined( 'CLASSES' ) )
{
	define( 'CLASSES', ADMIN_PATH . "classes/" );
}

//--------------------------------------------------------------------------
// ADVANCED CONFIGURATION: ERROR REPORTING
//--------------------------------------------------------------------------

error_reporting( E_STRICT | E_ERROR | E_WARNING | E_PARSE | E_RECOVERABLE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_USER_WARNING );

