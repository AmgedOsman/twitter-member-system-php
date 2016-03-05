<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}


//$query = "SELECT * FROM users WHERE twitter_id=2315174695";
//	if ($result = $run->mysqli->query($query)) {
//		 while ($obj = $result->fetch_object()) {
//			$name = $obj->screen_name;
//		}
//	}

/* Output HTML to display on the page */
//$run->buildContent( $run->member->name . ', hello and welcome to our site!');
$run->buildContent( sprintf($run->words['welcome'], $run->member->name));
	//$run->headerContent();
	//$run->addContent( sprintf($run->words['welcome'], $run->member->name) );
	//$run->footerContent();


?>