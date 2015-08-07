<?php
	require("/config.php"); //call the database data
	$mysql_username = $config['db']['dbh']['username'];
	$mysql_hostname = $config['db']['dbh']['host'];
	$mysql_password = $config['db']['dbh']['password'];
	$mysql_database = $config['db']['dbh']['dbname'];
		
	try {
		$dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_database", $mysql_username, $mysql_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
?>