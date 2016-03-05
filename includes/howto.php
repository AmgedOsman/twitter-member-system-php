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



$run->setTitle('How To Use');
$run->setDescription('How To Use Twitter Membership Based System');

/* Output HTML to display on the page */
//$run->buildContent( $run->member->name . ', hello and welcome to our site!');

$HTML = " 
<h2>How To Use Twitter Membership Based System</h2>
Hi {$run->member->name},
<br />
<br />
You 1st Must setup all you config.php file (You won;t be seeing this anyway if you haven't configured it already)
<code>
<br />
define('CONSUMER_KEY', '');<br />
define('CONSUMER_SECRET', '');<br />
define('OAUTH_CALLBACK', 'http://domain.com/subfolder/callback');<br />

//-------------------<br />
// Database<br />
//---------------------<br />
	define( 'dbhost', 'localhost' );// this will ususally be 'localhost', but can sometimes differ<br />
	define( 'dbname', 'twitter_login' );// the name of the database that you are going to use for this project<br />
	define( 'dbuser', 'user' );// the username that you created, or were given, to access your database<br />
	define( 'dbpass', 'pass' );// the password that you created, or were given, to access your database
</code>
<br />
<br />
<h3>Creating a new Page</h3>
Simple create new file and called whatever, for example myfile.php and then add it to <code>includes</code> folder<br />
Then add the below content inside it and that should be it
<br />
<br />
<code>
//<br />
// Set Page Title<br />
//<br />
	&dollar;run->setTitle('My Title');<br />
<br />
//<br />
// Set Page desc<br />
//<br />
	&dollar;run->setDescription('My Page Description!');<br />

//<br />
// Load page<br />
//<br />
	&dollar;run->buildContent( &dollar;run->words['file_text'] );<br />
	//Or customise it before printing?
	<br />
	//&dollar;run->headerContent();<br />
	//&dollar;run->addContent( &dollar;run->words['file_text'] );<br />
	//&dollar;run->footerContent();
</code>
<br />
You can then access the file from yourdomain.com/myfile or yourdomain.com/index.php?p=myfile <br />
<br />
<br />
<h3>Language Files</h3>
<br />
By default the system searches for Language files to be loaded that has the same name as your file.<br />
so you can simply add new file called <code>myfile.php</code> and upload it to <code>public_html/public/lang/#lang_name#/myfile.php</code><br />
All language files must start with an array
<br />
<code>
&dollar;LANG = array();<br />
&dollar;LANG['some_text'] = \"Really Formated Text\";
</code>
<br />
<br />
<h3>Using Twitter Codes</h3>
<br />
<code>&dollar;user = &dollar;run->Twitter->get('users/show', array('user_id' => &dollar;run->member->twitter_id));<br />
//print_r(&dollar;user);<br />
&dollar;run->buildContent(\"&lt;pre&gt;{&dollar;user->name}&lt;/pre&gt;\");
</code>
<br />
<br />
Twitter Library is Object Oriented so you can simple use <code>&dollar;run->Twitter->get('users/show', array('user_id' => &dollar;run->member->twitter_id))->name;</code>
<br />
Will output Amged
<br />
<br />
";
$run->buildContent( $HTML);

?>