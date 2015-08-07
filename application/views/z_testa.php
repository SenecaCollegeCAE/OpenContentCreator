<?php
function stuff() {
	require_once("../../resources/connect.inc.php");
	$result = $dbh->prepare("INSERT INTO z_testa VALUES(:stuff, :stuff2)");
	$result->execute(array('stuff' => 'wwong21', 'stuff2' => 'wtf2'));
	
	$result2 = $dbh->prepare("SELECT * FROM activities WHERE activity_id = :aid");
	$result2->execute(array('aid' => '1'));

	while($result2Row = $result2->fetch(PDO::FETCH_ASSOC)) {
		var_dump($result2Row);
	}
}

/*
header('X-Frame-Options: GOFORIT'); 
require("../../resources/connect.inc.php");
$result = $dbh->prepare("SELECT COUNT(email) FROM users WHERE email = :email");
$result->execute(array('email' => 'wwong21@myseneca.ca'));
	
echo "This is it";
if($result->fetch(PDO::FETCH_NUM)[0])
	echo "stinks<br />";

$config['img_path'] = '/occ/public/img/users'; // Relative to domain name
$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . $config['img_path'];

echo $config['upload_path'];

$title = "Newest WEEEEEEEBQUEST";
$description =  "Describing something in here";
$image = "something.png";
$color = "#FF0000";
$learningOutcomes = "<p>This is the learning outcome</p>";
$overview = "<p>Some overview here<br />More overview</p>";
$links = array("http://www.yahoo.ca", "http://www.msn.ca");
$tasks = array("1) Sing out loud", "2) Dance on your feet");
$questions = array("1) Who am I?", "2) Don't have a cow?");
$evaluation = '<p>Image here</p><img src="http://www.metoffice.gov.uk/media/image/j/i/Cumulus_2.jpg" alt="Clouds" width="320" height="213" />';
$publishMethod = "public";
$creativeCommon = "yes";
$allowCopy = "yes";
$userId = "wwong23";

/*
$result2 = $dbh->prepare("INSERT INTO activities VALUES(:activityId, :title, :description, :image, :color, :learningOutcomes, :overview, :links, :tasks, :questions, :evaluation, :publishMethod, :creativeCommon, :allowCopy, :userId)");
$result2->execute(array(
		'activityId' => '',
		'title' => $title,
		'description' => $description,
		'image' => $image,
		'color' => $color,
		'learningOutcomes' => $learningOutcomes,
		'overview' => $overview,
		'links' => base64_encode(serialize($links)),
		'tasks' => base64_encode(serialize($tasks)),
		'questions' => base64_encode(serialize($questions)),
		'evaluation' => $evaluation,
		'publishMethod' => $publishMethod,
		'creativeCommon' => $creativeCommon,
		'allowCopy' => $allowCopy,
		'userId' => $userId
));*/
/*
$result2 = $dbh->prepare("SELECT webquest_links FROM webquest_activities WHERE webquest_id = '3'");
$result2->execute();
$linked = $result2->fetch(PDO::FETCH_NUM)[0];

var_dump($linked);

$testArray = [];

var_dump(unserialize(base64_decode($linked)));

$testArray = unserialize(base64_decode($linked));

echo $testArray[0];
echo $testArray[1];

$dbh = null;

var_dump(realpath(dirname(__FILE__)));
*/
?>
<!-- <iframe src="../../resources/library/tinymce/plugins/jbimages/dialog.htm" width="50%" height="50%" stlye="border: 0px; width: 480px; height: 385px;"><p>Browser does not support iframes</p></iframe>  -->
