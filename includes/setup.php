 <?php

//
// Set Page Title
//
	$run->setTitle('Setup');

//
// Set Page desc
//
	$run->setDescription('Install page for the script!');

//
// Load page
//
	$run->buildContent( $run->words['setup_text'] );
	//$run->headerContent();
	//$run->addContent( $run->words['setup_text'] );
	//$run->footerContent();