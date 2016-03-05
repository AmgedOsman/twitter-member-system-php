# Twitter Member System PHP
PHP Membership System using Twitter Login only
The system is based and using @Abraham's [TwitterAOuth](https://github.com/abraham/twitteroauth) 
The System can be up and running in no time, very easy to install and to use.

[demo here](http://amged.me/tms/)


I've created it around a single registery class called `$run->functionExample();` (more on this later)
##Creating Twitter Application
For this system to work you need to create [Twitter Application](https://apps.twitter.com)
Make sure to setup the callback URL to the `callback.php` file in `includes` folder
Once the app is created you will be provided with 
* CONSUMER_KEY
* CONSUMER_SECRET


##Getting Started
Open the `config.php`and add the provided `CONSUMER_KEY` & `CONSUMER_SECRET` as well as your callback URL (The script won't work without it).

##Setup Database
Now create a new table in your database and import the below table inside it
This table is for users
```
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `twitter_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(65) NOT NULL,
  `screen_name` varchar(65) NOT NULL,
  `access_data` tinytext NOT NULL,
  `password` varchar(32) NOT NULL,
  `profile_image_url` varchar(250) NOT NULL,
  `created` int(10) NOT NULL,
  `updated` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Europe/London',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;
```
Again, in your `config.php` file fill in the database connection info
```
//-------------------
// Database
//---------------------
	define( 'dbhost', 'localhost' );// this will ususally be 'localhost', but can sometimes differ
	define( 'dbname', 'database_name' );// the name of the database that you are going to use for this project
	define( 'dbuser', 'user' );// the username that you created, or were given, to access your database
	define( 'dbpass', 'password' );// the password that you created, or were given, to access your database
```

##Customization and Setup
Now open `settings.php` and fill in the right configuration for your script

Most important one is the (the rest are all optional)

`$INFO['base_url'] = 'URL_TO_SCRIPT';`

##SEO Frindly with HTACCESS
Once that is done open the file `.htaccess` and again, put the correct url for the script to the error document (optional)
`ErrorDocument 404 /tms/404.php`
where `tms` is a subdirectory (you can remove it if your script runs on the root folder of the website


##Explaing Some Functions
To make things easier, i've created couple of functions that calls directly to certain actions
###$run
Basically, my main class `libsClass` can be called using `$run->` anywhere on any page!
for example to get current user Twitter Name you can do
`$run->member->name` displays `Amged`

###$run->Twitter
I've created a simple function to call directly for Abraham's class
`$run->Twitter->get();`
or
`$run->Twitter->post();`

Basically, any function that exists on TwitterAOuth can be accessed directly with 
`$run->Twitter->functionName();`


##Creating New Pages
You might want to create new pages for you website
with only 3 lines of codes you can have a new page ready!
Simply create new file in `includes` folder, for example call it `myfile.php`

Then add the below content inside it
```
<?php
if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}

//
// Set Page Title
//
	$run->setTitle('My Title');

//
// Set Page desc
//
	$run->setDescription('Page description!');

//
// Load page
//
	$run->buildContent( 'Output Content' );

```
That's it! 
I've also created another way of outputting content for more customization

so instead of `$run->buildContent('string here');`
you can use
```
//Print Header
$run->headerContent();
//Send output
$run->addContent( $run->words['setup_text'] );
//Send more content
$run->addContent( 'string' );
//print footer
$run->footerContent();
```

Enjoy the script and let me know if you run into any bugs
