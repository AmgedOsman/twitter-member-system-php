<?php

/**
 * @file
 * Check if consumer token is set and if so send user to get a request token.
 */

if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}
/* Set Page Title */
$run->setTitle('Login');
/* Set Page desc */
$run->setDescription('Login page for the website!');

/* Include HTML to display on the page. */
$run->headerContent();
?>


<a href="<?php echo $run->seoURL('redirect');?>" class="btn btn-lg btn-primary"><i class="fa fa-fw fa-twitter"></i> Sign in to Twitter</a>


<?php
$run->footerContent();