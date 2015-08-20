$(document).ready(function() {
	var currentLabel = 2;
	var numOfTimesCreateWasClicked = 0; //the default number of clicks allowed in the picture
	var canvasClicks = 1;
	var canvasStatesArray = []; //an array to hold all the canvas states saved
	var canvasSteps = -1;
	var points = [];
	var xy = [];
	var pictureW = 0;
	var pictureH = 0;
	var w = 0;
	var h = 0;
	
	var canvas = $('#myCanvas')[0];
	var context = canvas.getContext('2d');
	
	//******************************* Create Label Element ****************************************************************************************************
	$('#CreateLabel').click(function(e) {
		if(currentLabel < 10) { //Max of 9 labels
			var pElement = $('<p></p>').attr({'class': 'labelNumber'}).html(currentLabel + '. '); //childElement[0]
			var inputElement = $('<input>').attr({type: 'text', name: 'labelLabel' + currentLabel, id: 'labelLabel' + currentLabel, maxlength: '90', size: '25', placeholder: 'Label ' + currentLabel}); //childElement[1]
			var spaceElement = $('<div></div>').attr({'class': "labelSpacer"}); //childElement[2]
			
			$('#parentElement').append(pElement, inputElement, spaceElement);
			
			currentLabel++;
			numOfTimesCreateWasClicked++;
		}
	}); //******************************* END OF Create Label Element *****************************************************************************************
	
	//******************************* Undo Label Element ****************************************************************************************************
	$('#UndoLabel').click(function(e) {
		//Go to previous canvas state first
		if(canvasSteps > 0) {
			canvasSteps--; //Remove a step
			
			var canvasPic = new Image();
			canvasPic.src = canvasStatesArray[canvasSteps]; //Get the previous canvas state
			canvasPic.onload = function() {
				context.clearRect(0, 0, canvas.width, canvas.height); //clear the current canvas
				context.drawImage(canvasPic, 0, 0); //draw and use the previous canvas state
			};
		}
		
		points.pop();
		if(canvasClicks > 1) {
			if(canvasClicks == 2)
				currentLabel = 2;
			else if(canvasClicks > 2)
				currentLabel--;
			
			canvasClicks--;
		}
		else {
			currentLabel = 2;
			canvasClicks = 1;
		}
		
		//Then remove a label element second
		if($('#parentElement').children().length != 0) {
			if(numOfTimesCreateWasClicked > - 1) {
				$('#parentElement .labelSpacer').last().remove();
				$('#parentElement input').last().remove();
				$('#parentElement .labelNumber').last().remove();
			}
		}
		
		numOfTimesCreateWasClicked > 0 ? numOfTimesCreateWasClicked-- : numOfTimesCreateWasClicked = 0;
		
	}); //******************************* END OF Undo Label Element *****************************************************************************************
	
	$('#console').click(function(e) {
		console.log("currentLabel", currentLabel);
		console.log("numOfTimes..", numOfTimesCreateWasClicked);
		console.log("canvasClicks", canvasClicks);
		console.log("canvasStatesArray", canvasStatesArray);
		console.log("canvasSteps", canvasSteps);
		console.log("points", points);
		console.log("xy", xy);
		console.log("picW", pictureW);
		console.log("picH", pictureH);
		console.log("w", w);
		console.log("h", h);
	});
	
	/* This works on the canvas area
	 * Below are functions that work within the canvas
	 * Eg: Clicking on the canvas, clearing the canvas, ...etc
	 * 
	 */
		
	function clearCanvas() { //Runs anytime the choose file button is pressed
		context.clearRect(0, 0, canvas.width, canvas.height);
		canvas.width = 650;
		canvas.height = 500;
		currentLabel = 2;
		numOfTimesCreateWasClicked = 0;
		canvasStatesArray = [];
		points = [];
		xy = [];
		pictureW = 0;
		pictureH = 0;
		
		$('#parentElement').empty();		
	} //function clearCanvas()
	
	function readImage(input) {
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function(e) {
				var canvasCopy = $('<canvas></canvas>');
				var contextCopy = canvasCopy[0].getContext('2d');
				
				var width = 650;
				var height = 500;
				var imageObj = new Image();
				
				imageObj.onload = function(e) {
					var ratio = 1;
					
					if(imageObj.width > width)
						ratio = width / imageObj.width;
			        else if(imageObj.height > height)
			            ratio = height / imageObj.height;
					
					canvasCopy.attr({ width: imageObj.width, height: imageObj.height});
					contextCopy.drawImage(imageObj, 0, 0);
					
					w = Math.floor(imageObj.width * ratio);
			        h = Math.floor(imageObj.height * ratio);

			        if(w >= 630)
				        w = 610;
			        if(h >= 480)
				        h = 460;

			        context.drawImage(canvasCopy[0], 20, 20, w, h);
			        canvasPush();
				};
				imageObj.src = e.target.result;
			};
			reader.readAsDataURL(input.files[0]);
		}
	} //function readImage(input)
	
	function storeSession() { //Store values entered in hidden fields, when submitted the $_POST hidden fields can be used to refill the javascript input textboxes
		
	} //function storeSession()
	
	function canvasPush() { //runs anytime the canvas make a change, it will store that canvas session
		canvasSteps++;
		if(canvasSteps < canvasStatesArray.length) 
			canvasStatesArray.length = canvasSteps;
		
		canvasStatesArray.push(canvas.toDataURL());
	} //function canvasPush()
	
	//******************************* Clicking on the Canvas ****************************************************************************************************
	$('#myCanvas').click(function(e) {
		var mouseX, mouseY;
		
		if(e.offsetX) {
			mouseX = e.offsetX;
			mouseY = e.offsetY;
		}
		else if(e.layerX) {
			mouseX = e.layerX - 253;
			mouseY = e.layerY - 263;
		}
		
		if(canvasClicks < currentLabel) {
			//20px border around the picture
			pictureW = 20 + w;
			pictureH = 20 + h;
			
			if((mouseX >= 20 && mouseX <= pictureW) && (mouseY >= 20 && mouseY <= pictureH)) { //check if mouse clicks are within the photo coordinates
				context.fillStyle = "#000000";
				context.fillRect(mouseX-10, mouseY-10, 20, 20);
				
				context.strokeStyle = "#FF0000";
				context.lineWidth = 2;
				context.strokeRect(mouseX-10, mouseY-10, 20, 20);
				
				//**Need to write a number within the "dot" where the user clicks
				context.fillStyle = "#FFFFFF";
				context.font = "bold 10pt Arial";
				context.fillText(canvasClicks.toString(), mouseX-3, mouseY+4);
				
				canvasPush();
				
				xy.push(mouseX-8);
				xy.push(mouseY-8);
				points.push(xy);
				xy = [];
				canvasClicks++;
			}
		}
	}); //******************************* End of Clicking on the Canvas ****************************************************************************************************
	
	$('#labelActivityImage').on('change', function() {
		clearCanvas();
		readImage(this);
	});
});