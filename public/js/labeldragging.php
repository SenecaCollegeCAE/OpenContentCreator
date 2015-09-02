<?php
	session_start();
	require_once("../../application/controllers/helpers/storedActivityInfo.php"); 
	header('Content-Type: application/javascript');
?>
$(document).ready(function() {
	var num = <?php echo $activityObj[7]; ?>;
	var backgroundObj = new Image();
	var sources = {bg: '<?php echo $activityObj[5]; ?>'};
	
	for(var i = 1; i < (num + 1); i++) {
		switch(i) {
			case 1:
				sources["num" + i] = "../img/layout/num1.png";
				sources["num" + i + "_blank"] = "../img/layout/blank1.png";
				break;
				
			case 2:
				sources["num" + i] = "../img/layout/num2.png";
				sources["num" + i + "_blank"] = "../img/layout/blank2.png";
				break;
				
			case 3:
				sources["num" + i] = "../img/layout/num3.png";
				sources["num" + i + "_blank"] = "../img/layout/blank3.png";
				break;
				
			case 4:
				sources["num" + i] = "../img/layout/num4.png";
				sources["num" + i + "_blank"] = "../img/layout/blank4.png";
				break;
				
			case 5:
				sources["num" + i] = "../img/layout/num5.png";
				sources["num" + i + "_blank"] = "../img/layout/blank5.png";
				break;
			
			case 6:
				sources["num" + i] = "../img/layout/num6.png";
				sources["num" + i + "_blank"] = "../img/layout/blank6.png";
				break;
				
			case 7:
				sources["num" + i] = "../img/layout/num7.png";
				sources["num" + i + "_blank"] = "../img/layout/blank7.png";
				break;
				
			case 8:
				sources["num" + i] = "../img/layout/num8.png";
				sources["num" + i + "_blank"] = "../img/layout/blank8.png";
				break;	
				
			default:
				sources["num" + i] = "../img/layout/num9.png";
				sources["num" + i + "_blank"] = "../img/layout/blank9.png";
		}
	}
	
	function loadImages(sources, callback) {
	
	}
	
	function isNearOutline(icon, outline) {
	
	}
	
	function drawBackround(background, backgroundImg, text) {
	
	}
	
	function initStage(images) {
	
	}
	
	loadImages(sources, initStage);
	
});