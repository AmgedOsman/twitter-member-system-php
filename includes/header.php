<?php
/**/
if ( ! defined( 'IN_SCRIPT' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
 <link rel="icon" href="<?php echo $this->settings['base_url'];?>favicon.ico">
<title><?php $this->getTitle();?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/<?php echo $this->settings['theme'];?>/bootstrap.min.css">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="<?php echo $this->settings['public_url'];?>css/ie10surface.css" rel="stylesheet">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $this->settings['public_url'];?>css/style.css">
 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php $this->parseCSS();?>
<meta property="fb:app_id" content=""/>
<meta property="fb:admins" content=""/>
<meta property="og:locale" content="en_US"/>
<meta property="og:site_name" content="Site Name"/>
<meta property="og:title" content="<?php $this->getTitle();?>"/>
<meta itemprop="name" content="<?php $this->getTitle();?>"/>
<meta property="og:url" content="<?php echo $this->paramUrl();?>"/>

<link rel="canonical" href="<?php echo $this->paramUrl();?>"/>
<meta property="og:type" content="website"/>
<meta property="article:publisher" content="https://www.facebook.com/AmgedO"/>
<link rel="publisher" href="https://plus.google.com/+AmgedOsmanGP"/>

<meta property="article:author" content="https://www.facebook.com/amged.osman"/>
<meta name="author" content="Amged Osman"/>
<link rel="author" href="https://plus.google.com/+AmgedOsmanGP"/>

<meta property="og:description" content="<?php echo $this->settings['description'];?>"/>
<meta name="description" content="<?php echo $this->settings['description'];?>"/>
<meta itemprop="description" content="<?php echo $this->settings['description'];?>"/>

<meta property="og:image" content="<?php echo $this->settings['public_url'];?>imgs/meta.png"/>
<meta itemprop="image" content="<?php echo $this->settings['public_url'];?>imgs/meta.png"/>


<meta name="twitter:site" content="@Amged"/>
<meta name="twitter:creator" content="@Amged"/>
<meta name="twitter:domain" content="amged.me"/>
<meta name="twitter:title" content="<?php $this->getTitle();?>" />
<meta name="twitter:description" content="<?php echo $this->settings['description'];?>" />
<meta name="twitter:url" content="<?php echo $this->paramUrl();?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image:src" content="<?php echo $this->settings['public_url'];?>imgs/meta.png" />

<!-- Latest compiled and minified JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?php
$this->parseJS();
?>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo $this->settings['public_url'];?>js/ie10surface.js"></script>    

</head>
<body>
<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo baseURL;?>">
			<img alt="Brand" src="<?php echo $this->settings['base_url'];?>public/imgs/ame.png" alt="Visit Amged.me" />
		  </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo $this->settings['base_url'];?>"><?php echo $this->settings['title'];?></a></li>
            
          </ul>
          
       <ul class="nav navbar-nav navbar-right">
       <?php if ($this->isLoggedIn()) { ?>
            
            <?php 
          //  $m = $this->loadMember($_SESSION['access_token']['user_id']);
            ?>
            
            <li><a href="<?php $this->seoURL('profile');?>"><i class="fa fa-fw fa-user"></i> <?php echo $this->words['profile'];?></a></li>
            <li><a href="https://twitter.com/<?php echo $this->member->screen_name;?>"><img src="<?php echo $this->member->profile_image_url;?>" alt='img' height="20px" width="20px"/> <?php echo $this->member->screen_name;?></a></li>
           
            
            <li class="right"><a href="<?php  $this->seoURL('logout');?>"><i class="fa fa-fw fa-sign-out"></i> <?php echo $this->words['logout'];?></a></li>
            <?php } else { ?>
            <li class="right"><a href="<?php  $this->seoURL('redirect');?>"><i class="fa fa-fw fa-twitter"></i> <?php echo $this->words['login'];?></a></li>
             <?php }?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-cog"></i> <?php //echo $this->words['account'];?>Links <span class="caret"></span></a>
          <ul class="dropdown-menu">
           <?php if ($this->isLoggedIn()) { ?>
            <li class="right"><a href="<?php $this->seoURL('dashboard');?>"><i class="fa fa-fw fa-dashboard"></i> <?php echo $this->words['dashboard'];?></a></li>
            
            <?php } ?>
            <li role="separator" class="divider"></li>
            <li><a href="http://amged.me/blog/"><i class="fa fa-fw fa-external-link-square"></i> My Blog</a></li>
            <li><a href="http://amged.me/"><i class="fa fa-fw fa-external-link-square"></i> Amged.me</a></li>
          </ul>
        </li>
      </ul>
      
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<div class="container-fluid pad-section">
	<div class="container">
	<div class="blog-header">
		<h1 class="blog-title"><?php  echo  $this->settings['title2'] ? $this->settings['title2'] : $this->settings['title'];?></h1>
		<p class="lead blog-description"><?php echo $this->settings['desc'];?>
		</p>
	</div>

	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-8 blog-main">
<?php 
	$this->getMessage();
?>
  <p class="help-block" id="debug"></p>
