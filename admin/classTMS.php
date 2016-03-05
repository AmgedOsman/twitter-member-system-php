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
//public $INFO;
    public function __construct()
	{
		
		$this->requestsMerge();
		$this->settingsInstance();
		$this->startDB();
		$this->checkSetup();
		$this->parseLangFiles();
		$this->loadCurrentMember();
		
	//	$this->forceLogin();
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
/**/
public function startDB(){

	$this->db = Database::getInstance();
	$this->mysqli = $this->db->getConnection(); 
}

/**/
public function checkSetup(){
	
    if (CONSUMER_KEY === '' || CONSUMER_SECRET === '' || CONSUMER_KEY === 'CONSUMER_KEY_HERE' || CONSUMER_SECRET === 'CONSUMER_SECRET_HERE') 
    { 
     //$this->pageRedirect(baseURL . 'setup.php');
     $this->pageRedirect($this->seoURL('setup'), true);
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
	if ($this->settings['force_login']){
		if ($this->isLoggedIn() === false){
			 //$this->pageRedirect($this->seoURL('logout'), true);
			 $this->request['p'] = 'logout';
		}
	}
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

/** 
* Compose a Tweet
*/
public function tweetComposer(){

$html = <<<HTML
<form id="scheduleForm" class="form-horizontal" role="form" action="http://localhost/ipb347/schedule/" method="post" enctype="multipart/form-data">
  <input type="hidden" name="do" value="insert" />
  <div class="form-group">
   <label for="postContent" class="col-sm-2 control-label">Tweet Text</label>
    <div class="col-sm-10">
          <textarea id="postContent" class="form-control" name="Post" rows="3" cols="auto" placeholder="Whats on your mind?"></textarea>
          
       <p class="help-block"><span class="label label-default" id="character-count">140</span> characters remaining.</p>
    </div>
  </div>
  
  
  
<!-- The fileinput-button span is used to style the file input field as button -->
<div class="form-group">
   <label for="fileupload" class="col-sm-2 control-label">Photos</label>
     <div class="col-sm-10">
          <div id="hideAfterSubmit">
            <div id="fileuploadHolder">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Select file</span>
            </div>
          </div>
          <div id="status"></div>
          <input id="photo" type="hidden" name="photo" value="" />
          <!-- The global progress bar -->
     </div>
</div>
  
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">TWEET</button>
    </div>
  </div>
</form>


HTML;
echo $html;
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
public function addContent($content=''){   
	/*Lets Tacel this later*/
	$this->output[] = $this->parseContent($content);
   print $this->parseContent($content);
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
public function parseContent($content=''){
	$something = array('{base_url}', '{imgs_url}');
	$with      = array($this->settings['base_url'], $this->settings['public_url'].'imgs/');
	$content   = str_replace($something, $with, $content);
	return $content;
}
 public function loadWordPress(){

    //------------------------------
    // Short and sweet 
    // to use wordpress functions
    // outside of wordpress
    // http://codex.wordpress.org/Integrating_WordPress_with_Your_Website#Grab_the_header
    //------------------------------
    define('WP_USE_THEMES', false);
    require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
  }
 
/***************
* We shall be using this Later
*/
public function parseEmail($content=''){
   
   $notice = <<<HTML
   
   ----
   This e-mail was sent from <a href="https://amged.me/">amged.me</a>
HTML;
   $content = $content.$notice;
   $content = nl2br($content);
   return $content;
 }

/**
 * Load a template
 */
 public function loadTemplate($tpl=''){

     include('tpls/'.$tpl.'.php');
}
  
 /* shorten text
 * @value string,num
 * @return string
 * Originally egypt_short_text
 */
public function shortenText($text, $chars = 90) {
    if (strlen($text) > $chars) { 
		$text = $text." ";
		$text = substr($text,0,$chars);
		$text = substr($text,0,strrpos($text,' '));
	    $text = $text;
		return $text;
    } else {
		return $text;
    }
}

/**
 * data array
 * return array parsed
 * used in quotes.php tempplate
 */
public function parseTweet($data){
		$pageURL = esc_url( home_url( '/' ) ) . 'quotes/';
		$imgsURL = esc_url( home_url( '/' ) ). 'cdn/images/static/quotes/';
		$imgsURL = esc_url( home_url( '/' ) ). 'cdn/images/static/quotes/';
		$imgsDir = $_SERVER["DOCUMENT_ROOT"]. '/cdn/images/static/quotes/';
		$return = array();
		//$return['img'] = file_exists($imgsDir.$data['name'].'.png') ? $imgsURL.$data['name'].'.png' : $imgsURL.$data['name'].'.jpg';
		$return['img'] = $imgsURL.$data['name'].'.'.$data['ext'];
		$return['pic'] = 'https://t.co/' . $data['name'];
		$data['intent']  = $this->shortenText($data['intent'], 92). ' ' .$pageURL;
		$data['intent']  = urlencode($data['intent']);
		$return['intent']  = str_replace('#' , '%23', $data['intent']);
		$return['url'] = 'https://twitter.com/intent/tweet?text=' . $return['intent'] . '&amp;url=' . $return['pic'];

	return $return;
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
				<strong>'. ucwords($_SESSION['msg']['type']).':</strong> '.$_SESSION['msg']['text'].'.
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

//END::CLASS
}
