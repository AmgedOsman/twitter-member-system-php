<?php
/* Simply add link to root folder of the script */
$INFO['base_url'] = 'http://amged.me/tms/';
/*Some customizations */
$INFO['title']    = 'Twitter Membership Based System';
$INFO['desc']     = "Simple Twitter Website based on abrahams TwitterAOuth and Bootstrap.";
/*Website Language*/
$INFO['default_lang']    = 'en'; 
/*bootswatch bootstrap themes can be found here*/
$INFO['theme']    = 'cosmo'; //https://www.bootstrapcdn.com/bootswatch/
/* Force MEmber Login */
$INFO['force_login'] = 0;
/*SocialProfiles*/
$INFO['social'] = array(
							'github'   => 'https://github.com/amgedosman',
							'twitter'  => 'https://twitter.com/Amged',
							'facebook' => 'https://www.facebook.com/amgedosman',
							'medium'   => 'https://medium.com/@Amged',
);
//make it 0 to use query_urls index.php?page=example
$INFO['seo_urls'] = 1; 
/**
 No need to change anything after here!
 */
$INFO['index_url']  = $INFO['base_url'].'index.php';
$INFO['public_url'] = $INFO['base_url'].'public/';
$INFO['upload_url'] = $INFO['base_url'].'uploads/';
$INFO['upload_dir'] = PUBLIC_PATH.'uploads/';

