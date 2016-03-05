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

/* If access tokens are not available redirect to connect page. */
if (!$run->isLoggedIn()) {
    $run->pageRedirect($run->seoURL('logout',true));
}
/* Set Page Title*/
$run->setTitle('Profile');
/* Set Page desc */
$run->setDescription('Manage your Profile here!');

/* update Email*/
if ($run->request['do'] === 'updateprofile'){
	$email = trim($run->request["email"]);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  $error = 1;
		  $msg = "Invalid Email Format";
		  $type = "danger";
		  $run->member->email = '';
	} elseif ($run->member->email === $email) {
		$error = 0;
	} else {
		$query = "update users set email='$email' where twitter_id={$_SESSION['access_token']['user_id']}";
		$run->mysqli->query($query);
		$error = 0;
		$run->member->email = $email;
		$msg = "Email Updated";
		$type = "info";
	}
	 $run->setMessage($msg,$type);
}
/* update TimeZone*/
$tz = trim($run->request["timezone"]);
if ($tz !== $run->member->timezone && !empty($tz) && !$error){

		$query = "update users set timezone='$tz' where twitter_id={$_SESSION['access_token']['user_id']}";
		$run->mysqli->query($query);
		$error = 0;
		$run->member->timezone = $tz;
		$msg .= " + Time Zone Updated";
		$type = "info";
	 $run->setMessage($msg,$type);
}

//Add extraJS or extraCSS
//$run->addToHeader('https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js', 'js');

/* Include HTML to display on the page */
$run->headerContent();
$text = 'Now all we need is an email?';
if ($run->member->email){
    //$run->pageRedirect(baseURL . 'dashboard.php');   
    $text = 'You can update your email here';
    $button = '<a href="'.  $run->seoURL('dashboard',true) .'?withmsg=1' .'" class="btn btn-success">Dashboard</a>';
}

if (isset($run->request['withmsg']) == 1) { 
	$run->clearMessage();
} 
?>
<div class="center-block h3"><?php echo $text ;?></div>
<form class="form-horizontal" role="form" id="contactForm" method="post" action="<?php echo $run->seoURL('profile');?>">
<input type="hidden" name="do" value="updateprofile" />
<input type="hidden" name="withmsg" value="1" />
  <div class="form-group">
    <label for="contactName" class="col-sm-4 control-label">Name</label>
    <div class="col-sm-6">
		<?php echo $run->member->name;	?>
    </div>
  </div>

  <div class="form-group form-sm">
    <label for="contactEmail" class="col-sm-4 control-label">Email</label>
    <div class="col-sm-6">    
      <div class="input-group">
       <div class="input-group-addon">@</div>
       <input class="form-control" type="email" id="contactEmail" name="email" value="<?php echo $run->member->email;?>" placeholder="Enter email" required>
      </div>
    </div>
  </div>
 
  <div class="form-group">
    <label for="timezone" class="col-sm-4 control-label">Time Zone</label>
    <div class="col-sm-6">
		<?php  $run->buildTimeZoneDropDown();	?>
    </div>
  </div>
  
  <div class="form-group">
    <label for="screen_name" class="col-sm-4 control-label">Handle</label>
    <div class="col-sm-6">
		@<?php echo $run->member->screen_name;	?>
    </div>
  </div>
  <div class="form-group">
    <label for="Twitter" class="col-sm-4 control-label">Twitter Id</label>
    <div class="col-sm-6">
		<?php echo $run->member->twitter_id;	?>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-6">
     
      <button type="submit" class="btn btn-primary">SUBMIT</button>
      <?php echo  $button;?>
    </div>
  </div>
</form>
<?php
$run->footerContent();
?>