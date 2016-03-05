<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
//session_start();
//require_once('config.php');
//$run = new run();
if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}


/* If the oauth_token is old redirect to the connect page. */
if (isset($run->request['oauth_token']) && $_SESSION['oauth_token'] !== $run->request['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  $run->pageRedirect($run->seoURL('logout'), true);
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$run->getTwitter('session');

/* Request access tokens from twitter */
$run->accessToken = $run->Twitter->getAccessToken($run->request['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
$_SESSION['access_token'] = $run->accessToken;

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $run->Twitter->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  
  /* add to database */
	$content = $run->Twitter->get('account/verify_credentials');
	//include DB_FILE;
	$name = $run->mysqli->real_escape_string($content->name);
	$screen_name = $run->mysqli->real_escape_string($content->screen_name);
	$profile_image_url = $run->mysqli->real_escape_string($content->profile_image_url);
	//$twitter_id = $content->id;
	//$email = $content->email;
	$time = time();
	$access_data = serialize($run->accessToken);

/* Check if we have an old returning user? */
	$checkusername = $run->mysqli->query("SELECT * FROM users WHERE twitter_id = '".$run->accessToken['user_id']."'");
	if($checkusername->num_rows == 1) {
	//update user data
	$updatequery = $run->mysqli->query("UPDATE users SET name='{$name}', profile_image_url='{$profile_image_url}', access_data='{$access_data}', updated='{$time}' WHERE  screen_name='{$screen_name}'");
		
    $text = 'User Updated';	
    $type = 'info';	
    $location = 'dashboard';					   
	} else {
	// add new user
	$registerquery = $run->mysqli->query("INSERT INTO users (name, screen_name, profile_image_url, twitter_id, access_data, created) 
								VALUES('".$name."', '".$screen_name."', 
									   '".$profile_image_url."', '".$run->accessToken['user_id']."',
									   '".$access_data."', '".$time."')");


    $text = 'User Registred';	
    $type = 'success';	
    
    $location = 'profile';
  }
  $run->setMessage($text,$type);
  $_SESSION['loggedIn'] = 1;
  //$run->pageRedirect(baseURL . $location.'.php?msg=1');
  $run->pageRedirect($run->seoURL($location, true) .'?withmsg=1');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  $run->pageRedirect($run->seoURL('logout', true));
}
