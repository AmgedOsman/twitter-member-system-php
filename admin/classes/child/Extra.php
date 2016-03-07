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
class Extra extends classTMS {


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

public function parseTweetOld($data){
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

//END::CLASS
}