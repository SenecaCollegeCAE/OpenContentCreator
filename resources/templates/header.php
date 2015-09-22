<?php
	function docHeader($title, $css, $icon) {
		if(empty($_SERVER['HTTPS'])) { //change to false when uploaded to the server, need to check if it is secure
			print <<<EOF
			<!DOCTYPE html>
			<html lang="en-US">
			<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, user-scalable=no">
			<title>$title</title>
			<link rel="stylesheet" type="text/css" href="$css" />
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
            <link rel="shortcut icon" href="$icon" />
  			<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
EOF;
		}
		else {
			header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
			exit;
		}
	}
	
	function docHeaderWithJqueryLibraries($title, $css, $icon, $libraries) {
		if(empty($_SERVER['HTTPS'])) { //change to false when uploaded to the server, need to check if it is secure
			print <<<EOF
			<!DOCTYPE html>
			<html lang="en-US">
			<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, user-scalable=no">
			<title>$title</title>
			<link rel="stylesheet" type="text/css" href="$css" />
			<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
            <link rel="shortcut icon" href="$icon" />
  			<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
EOF;
			for($i = 0; $i < count($libraries); $i++) {
				echo '<script src="' . $libraries[$i] . '"></script>';
			}
		}
		else {
			header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
			exit;
		}
	}
	
?>