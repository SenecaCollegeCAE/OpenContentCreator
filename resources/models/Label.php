<?php
	require_once("Activity.php");
	
	class Label extends Activity{
		private $_activityImage; //use for hidden labelImageTarget
		private $_labels; //Max of 9 labels //used for hidden labeLabelArray
		private $_currentLabel;
		private $_numOfTimesCreateWasClicked;
		private $_coordinates; //used for hidden labelCoordsArray
		
		function __construct() {
			$this->_labels = [];
		}
		
		//This temporary submits and save the working image to the user's image folder. Used for postbacks, incase there are form errors, you still want to display the working image
		public function temporarySubmittedActivityImage($file, $fileTemp, $userName) { 
			$targetDirectory = "../../../public/img/users/" . $userName ."/";
			$tempString = explode(".", $file);
			$extension = end($tempString);
			$pictureName = reset($tempString);
			
			$this->_activityImage = $targetDirectory . "TEMP" . basename($pictureName) . "." . $extension;
			
			move_uploaded_file($fileTemp, $this->_activityImage); 
			
			return $this->_activityImage;
		} //function temporarySubmittedActivityImage
		
		public function deleteAllTemporaryFiles($stringExp, $userName) {
			$targetDirectory = "../../../public/img/users/" . $userName ."/";
			$images = glob($targetDirectory . "TEMP*");
			
			foreach($images as $image) {
				unlink($image);
			}
			
		} //function deleteAllTemporaryFiles
	}
?>