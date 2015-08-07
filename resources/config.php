<?php 
	$config = array(
		"db" => array(
			"dbh" => array(
				"dbname" => "open-content-creator",
				"username" => "occreator",
				"password" => "2pFP73DehncAnTKf",
				"host" => "localhost"
			)
		),
		"urls" => array(
			"baseUrl" => "http://127.0.0.1/occ/"
		),
		"paths" => array(
			"resources" => "../resources",
			"images" => array(
				"content" => $_SERVER['DOCUMENT_ROOT'] . "/images/content",
				"layout" => $_SERVER['DOCUMENT_ROOT'] . "/images/layout"
			)
		)
	);
	
	
	defined("LIBRARY_PATH") or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
	 
	defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
	
	/*
	 Error reporting.
	*/
	ini_set("error_reporting", "true");
	error_reporting(E_ALL|E_STRCT);
?>