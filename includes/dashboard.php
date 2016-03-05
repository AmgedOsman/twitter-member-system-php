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

$run->loadLangFile('dashboard');
/* If access tokens are not available redirect to connect page. */
if (!$run->isLoggedIn()) {
    //$run->pageRedirect(baseURL . 'logout.php');       
    $run->pageRedirect($run->seoURL('logout'), true); 
}
/*Set page Title */
$run->setTitle('Dashboard');
/* Set Page desc */
$run->setDescription('Manage your dashboard here!');

/* Get user access tokens out of the session. */
$run->accessToken = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$run->getTwitter();
/* Create a TwitterStream object with consumer/user tokens. */
//$run->getStream();

/* Some example calls */
//$run->Twitter->get('users/show', array('screen_name' => 'abraham'));
//$run->Twitter->post('statuses/update', array('status' => date(DATE_RFC822)));
//$run->Twitter->post('statuses/destroy', array('id' => 5437877770));
//$run->Twitter->post('friendships/create', array('id' => 9436992));
//$run->Twitter->post('friendships/destroy', array('id' => 9436992));

		/* Include HTML to display on the page */
		$run->headerContent();

		if (isset($run->request['withmsg']) == 1) { 
			$run->clearMessage();
		} 

		$run->addContent("
		<script type=\"text/javascript\">
			jQuery(function() {
				jQuery('#flash').addClass('bg-primary');    
			});
		</script>
		");
						 

		
		$user = $run->Twitter->get('users/show', array('user_id' => $run->member->twitter_id));
		//print_r($user);
		$run->addContent("<pre>{$run->words['hello_world']} - {$user->name}</pre>"); 
		//$run->Twitter->post('statuses/update', array('status' => $run->words['hello_world']));
		$run->footerContent();
