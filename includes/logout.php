<?php
/**
 * @file
 * Clears PHP sessions and redirects to the connect page.
 */
 if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}
/* Load and clear sessions */
session_start();
session_destroy();
 
/* Redirect to page with the connect to Twitter option. */
//header('Location: ./login.php');
$run->pageRedirect($run->seoURL('login', true));
