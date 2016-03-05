<?php

if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}

$run->getTwitter('new');


 
/* Get temporary credentials. */
$request_token = $run->Twitter->getRequestToken(OAUTH_CALLBACK);

/* Save temporary credentials to session. */
$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
 
/* If last connection failed don't display authorization link. */
switch ($run->Twitter->http_code) {
  case 200:
    /* Build authorize URL and redirect user to Twitter. */
    $url = $run->Twitter->getAuthorizeURL($token);
    header('Location: ' . $url); 
    break;
  default:
    /* Show notification if something went wrong. */
    echo 'Could not connect to Twitter. Refresh the page or try again later.';
}
