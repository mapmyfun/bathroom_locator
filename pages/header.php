<?php
	$asset_path = "../assets/";
	echo "<meta name='apple-mobile-web-app-capable' content='yes'>";
	echo "<link rel='apple-touch-icon' href='".$asset_path."images/appicon.png' />";
	echo "<link rel='apple-touch-startup-image' href='".$asset_path."images/appicon2.png' />";

	echo "<meta name='apple-mobile-webapp-status-bar-style' content='black'>";
	echo "<meta name='viewport' content='width=device-width, user-scalable=no' />";

	
	$javascript_path = $asset_path."/javascript/";
	echo "<link rel='stylesheet' type='text/css' href='../assets/stylesheets/styles.css'>";
	echo "<script src='".$javascript_path."util.js'></script>";
	echo "<script src='".$javascript_path."footerlinks.js'></script>";


	$jquery_path = $javascript_path."/jquery/";
	echo "<script src='".$jquery_path."jquery-1.8.2.js'></script>";
	#echo "<script src='".$jquery_path."disable_ajax.js'></script>";
	
	echo "<link rel='stylesheet' href='".$jquery_path."jquery.mobile-1.2.0.css' />";
	echo "<script src='".$jquery_path."jquery.mobile-1.2.0.js'></script>";
	echo "<script src='".$javascript_path."disable_safari.js'></script>";
		
	require_once('../config/google_maps_config.php');
?>
