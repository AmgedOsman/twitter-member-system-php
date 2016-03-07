<?php
/**
 * classTMS.php
 *
 * Library
 *
 * @package    Twitter Mebership Bases System
 * @author     Amged Osman
 * @copyright  2016 Amged Osman
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id:$
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.2.0
 */
class classTMS {
protected $db;
public $mysqli;
public $settings;
public $request;
public $member;
public $Twitter;
public $Stream;
public $accessToken;
public $css;
public $js;
public $words;
public $langFile;
public $output;
public $renamedClasses = array('default' => 'hint', 'primary' => 'message', 'success' => 'successful', 'info' => 'information', 'warning' => 'warning', 'danger' => 'error');
//public $INFO;
    public function __construct()
	{
		
		$this->requestsMerge();
		$this->settingsInstance();
		$this->startDB();	
		$this->parseLangFiles();
		$this->loadCurrentMember();
		$this->checkSetup();

	}
public function loadCurrentMember(){

		if ( $this->isLoggedIn() ){
			$this->member = $this->loadMember(isset($_SESSION['access_token']['user_id']) ? $_SESSION['access_token']['user_id'] : 0 );
		} else {
			$this->setupGuest();
		}
	}
public function settingsInstance(){
		//$this->settings = $INFO;
		
		if ( is_file( ROOT_PATH . 'settings.php' ) )
		{
			require( ROOT_PATH . 'settings.php' );/*noLibHook*/

			if ( is_array( $INFO ) )
			{
				foreach( $INFO as $key => $val )
				{
					$this->settings[ $key ]	= str_replace( '&#092;', '\\', $val );
				}
			}
		}
		
		/**
		* baseURL
		*/
		if ( !defined( 'baseURL' ) )
		{
			define( 'baseURL', $this->settings['base_url'] );
		}

	}
public function requestsMerge(){
		$this->request = array_merge($_SERVER,$_POST,$_GET);
	}
/*
* Load our DB Class
*/
public function startDB(){

	$this->db = Database::getInstance();
	$this->mysqli = $this->db->getConnection(); 
}

/**/
public function checkSetup(){
	
    if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') 
    { 
		include(ROOT_PATH . INCLUDES . '/' . 'setup.php');
      exit();
    }
  }
/**/ 
public function isLoggedIn(){ 
	if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
	 $_SESSION['loggedIn'] = 0;
	 return false;
	} else {
		return true;
	}
}

public function forceLogin(){
	$this->pageRedirect($this->seoURL('logout',true));
}
/**
 @Here we go
 */
public function getTwitter($method='stored', $oauth_token='',$oauth_token_secret=''){
	switch ( $method )
		{
		
		case 'new':
				$this->Twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
				break;
		case 'provided':
				$this->Twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
				break;
		case 'session':
				$this->Twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
				break;			
		case 'stored':
				$this->Twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->accessToken['oauth_token'], $this->accessToken['oauth_token_secret']);
				break;		
			default:
				$this->Twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->accessToken['oauth_token'], $this->accessToken['oauth_token_secret']);
				break;		
			}
		return $this->Twitter;
	}

/**
 @Stream API (this is only here for reference, not actually using it yet!
 */
public function getStream($method='stored', $oauth_token='',$oauth_token_secret=''){
	$this->Stream = new ctwitter_stream();
	switch ( $method )
		{
		case 'provided':
				$this->Stream = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
				break;
		case 'session':
				$this->Stream->login(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
				break;			
		case 'stored':
				$this->Stream->login(CONSUMER_KEY, CONSUMER_SECRET, $this->accessToken['oauth_token'], $this->accessToken['oauth_token_secret']);
				break;		
			default:
				$this->Stream->login(CONSUMER_KEY, CONSUMER_SECRET, $this->accessToken['oauth_token'], $this->accessToken['oauth_token_secret']);
				break;		
			}
		
}	
public function testTweet($status='', $reply_id_str=0){

		//http://codereview.stackexchange.com/questions/23253/function-that-loads-a-random-image-from-an-array
		$preDefinedStatuses = array("Hello World", "Hey People", "Random Status", "What you guys doing!", "الحمد لله");
		$randomNumber = rand(0, (count($preDefinedStatuses) - 1));
		$data = array();
		$data['status'] = $status ? $status : $preDefinedStatuses[$randomNumber] . ' ' . $randomNumber;
		$data['in_reply_to_status_id'] = $reply_id_str ? $reply_id_str : '';
		$doPost = $this->Twitter->post('statuses/update', $data);
		$this->addContent("<pre>");
		print_r( $doPost );
		$this->addContent("</pre>");
}

/**/
public function seoURL($file='', $return=false){
			if ($this->settings['seo_urls']) 
			{
			 $link = $this->settings['base_url'].$file;
			}
			else
			{
			 $link = $this->settings['index_url'].'?p='.$file;
			}
				if ($return)
				{
					return $link;
				}
		echo $link;
}

public function originUrl( $s, $use_forwarded_host = false )
{
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

public function paramUrl( $use_forwarded_host = false )
{
    return $this->originUrl( $this->request, $use_forwarded_host ) . $this->request['REQUEST_URI'];
}

/**/
public function loadMember($id=0){ 
	//include DB_FILE;
	$query = "SELECT * FROM users WHERE twitter_id=$id";
	if ($result = $this->mysqli->query($query)) {
		 while ($obj = $result->fetch_object()) {
			return $obj;
		}
	} else {
		$this->setupGuest();
	}
	 return false;
}
public function setupGuest(){
	$guest = array('name' => 'Guest', 'twitter_id' => 0, 'screen_name' => '*Guest*');
	$_SESSION['access_token']['user_id'] = 0;
	$_SESSION['loggedIn'] = 0;
	
//	$guest = (object) $guest;
 $this->member = (object) $guest;
}

/** 
 * Member's TimeZone
 */
 public function buildTimeZoneDropDown(){
		$this->addContent("<select name='timezone'>");
		$this->addContent("<option value='{$this->member->timezone}'>{$this->member->timezone} (Current)</option>");
		$timezone_offsets = array();
		foreach(timezone_identifiers_list() as $timezone_identifier)
		{
			$date_time_zone = new DateTimeZone($timezone_identifier);
			$date_time = new DateTime('now', $date_time_zone);
			$timezone_offsets[$timezone_identifier] = $date_time_zone->getOffset($date_time);
			$this->addContent("<option value='{$timezone_identifier}'>{$timezone_identifier}</option>");
		}
		$this->addContent("</select>");
 
 }

/*(*/
public function loadLangFile($file=''){
		if($file){
			$this->langFile[] =  $file;
		}
}

public function parseLangFiles(){
$this->langFile[] =  'global';
$this->langFile[] =  'errors';
$this->langFile[] =  $this->request['p'];
		if(count($this->langFile) > 0){
			foreach ($this->langFile as $file){
				if ( is_file( PUBLIC_PATH . 'lang/' . $this->settings['default_lang'] . '/' . $file .'.php' ) )
				{
					require_once( PUBLIC_PATH . 'lang/' . $this->settings['default_lang'] . '/' . $file .'.php' );/*noLibHook*/
					/*Convert it to Object*/
					//$LANG = (object) $LANG;
					if ( is_array( $LANG ) )
					{
						foreach( $LANG as $key => $val )
						{
							$this->words[ $key ]	= str_replace( '&#092;', '\\', $val );
						}
					}
				}
			}
		}
}
/***************
* addToHeader
* @link link to file
* @type js/css
* @id file id
*/
public function addJS($link='',$beforejq=false){

			$this->js[] = '<script src="'.$link.'"></script>';
		
}
public function parseJS(){
		if(count($this->js) > 0){
			foreach($this->js as $js){
				echo $js ."\n";
			}
		}
}
public function addCSS($link='',$id='',$media='all'){
		//if (is_file($link)){
			$this->css[] =  "<link rel='stylesheet' href='".$link."' id='".$id."' media='".$media."' />";
		//}
}
public function parseCSS(){
		if(count($this->css) > 0){
			foreach ($this->css as $css){
				echo $css ."\n";
			}
		}
}
/***************
* addContent
* echos content like a boos!
*/
public function addContent($content='', $class=''){   
	/*Lets Tacel this later*/
	$this->output[] = $this->parseContent($content);
   print $this->parseContent($content,$class);
 }	
 
public function headerContent(){
	include(ROOT_PATH . INCLUDES . '/' . 'header.php');
}
public function footerContent(){
	include(ROOT_PATH . INCLUDES . '/' . 'footer.php');
	exit();
}	
public function buildContent($html=''){
	$this->headerContent();
	$this->addContent($html);
	$this->footerContent();
}
public function parseContent($content='', $class=''){
	$something = array('{base_url}', '{imgs_url}');
	$with      = array($this->settings['base_url'], $this->settings['public_url'].'imgs/');
	$content   = str_replace($something, $with, $content);
	if ( $class ){
	
	$content = '<div class="alert alert-'.$class.'">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>'. ucwords($this->renamedClasses[$class]).':</strong> '.$content.'.
				</div>';
	}
	return $content;
}

/**
 * data array
 * return array parsed
 * used in quotes.php tempplate
 */
 public function parseTweet($tweet=''){
 $date = date_create($tweet->created_at);
 $date = date_format($date,"M d");
 echo 				'<div class="media">
							<div class="media-left">
								<a href="'.$tweet->user->screen_name.'">
									<img class="media-object" src="'.$tweet->user->profile_image_url.'" alt="'.$tweet->user->screen_name.' Profile Picture">
								</a>
							</div>
							<div class="media-body">
								<h4 class="media-heading"><a href="'.$tweet->user->screen_name.'">'.$tweet->user->screen_name.'</a> <small>	<a class="pull-right" href="https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id_str.'">'.$date.'</small></a></h4>
								'.$tweet->text.'
							</div>
					</div>';
}					

/************
 * setTitle
 */
 public function setTitle($title=''){
		
		if ($title)
		{
			 $this->settings['title2'] = $title;
		}
	}
/************
 * getTitle()
 */
 public function getTitle($title=''){
		
		$title = $this->settings['title'];
		if ($this->settings['title2'])
		{
			 $title = $this->settings['title2']. ' - ' . $this->settings['title'];
		}
		echo   $title;
	}
/************
 * setTitle
 */
 public function setDescription($desc=''){
		
		if ($desc)
		{
			 $this->settings['desc'] = $desc;
		}
		return  $this->settings['desc'];
	}
/**
 * After submit lets redirect
 * http://stackoverflow.com/questions/768431/how-to-make-a-redirect-in-php
 */
public function pageRedirect($url, $permanent = false) {
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

/*********************************
 * This is how we handle messages 
 * Like Bosses!
 */
public function getMessage() {
		if (isset($_SESSION['msg']) and count($_SESSION['msg']) ) { 
		$message = '
				<div class="alert alert-'.$_SESSION['msg']['type'].'">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>'. ucwords($this->renamedClasses[$_SESSION['msg']['type']]).':</strong> '.$_SESSION['msg']['text'].'.
				</div>';
		}
		echo $message;
	}
public function setMessage($text='',$type='') {
		$message = array('text' => $text, 'type' => $type);
		$_SESSION['msg'] = $message;
	} 
public function clearMessage() {
		$_SESSION['msg']['text'] = '';
		$_SESSION['msg']['type'] = '';
		unset($_SESSION['msg']);
	}  


/**********************
 * This is to count Views
 * Useless, really!
 */
public function pageviewPlusOne(){

		$file=fopen(PUBLIC_PATH ."pageview-counter.txt","r+");
		$result=fread($file,filesize(PUBLIC_PATH ."pageview-counter.txt"));
		fclose($file);
		$result += 1;
		$file=fopen(PUBLIC_PATH . "pageview-counter.txt","w+");
		fputs($file,$result);
		fclose($file);
	}
public function pageviewCount(){
		$counter=fopen(PUBLIC_PATH."pageview-counter.txt","r+");
		$results=fread($counter,filesize(PUBLIC_PATH."pageview-counter.txt"));
		fclose($counter);
		return $results;
    }
	/*
	* Output easy-to-read numbers
	* by james at bandit.co.nz
	*/
public function make_niceNumbers($n) {
		// first strip any formatting;
		$n = (0+str_replace(",","",$n));

		// is this a number?
		if(!is_numeric($n)) return false;

		// now filter it;
		if($n>1000000000000) return round(($n/1000000000000),1).'t';
		else if($n>1000000000) return round(($n/1000000000),1).'b';
		else if($n>1000000) return round(($n/1000000),1).'m';
		else if($n>1000) return round(($n/1000),1).'k';

		return number_format($n);
	}


public function loadClass($className='', $directory='') {
		
		$directory = $directory ? $directory . '/' : '';
		require_once(CLASSES . $directory . $className.'.php');
		$this->$className = new $className();
		return $this->$className;
}
	
//END::CLASS
}