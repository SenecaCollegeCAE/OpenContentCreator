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
	
	//*************************************** RUNS AFTER A POSTBACK /SUBMITTED (default running, not inside a function) *************************************
	//USED FOR, if any form errors during the submit, the image and the labels will still be there
	if($('#labelImageTarget').val() != "") {
		var canvasCopy = $('<canvas></canvas>')[0]; //document.createElement('canvas')
		var contextCopy = canvasCopy.getContext('2d');
			
		var flag = false;
		var width = 650;
		var height = 500;
		var imageObj = new Image();
	
		imageObj.onload = function() {
			
			//Load the picture back into the canvas first
			var ratio = 1;			
			if(imageObj.width > width)
				ratio = width / imageObj.width;
			else if(imageObj.height > height)
				ratio = height / imageObj.height;
			
			canvasCopy.width = imageObj.width;
			canvasCopy.height = imageObj.height;
			contextCopy.drawImage(imageObj, 0, 0);
			
			w = Math.floor(imageObj.width * ratio);
			h = Math.floor(imageObj.height * ratio);
			
			if(w >= 630)
				w = 610;
		    if(h >= 480)
		    	h = 460;

		    context.drawImage(canvasCopy, 20, 20, w, h);
		    canvasPush(); //the original canvas with the picture and no marker is clicked yet
		    
		    //Load the click locations back second
		    var refreshedNumOfClicks = $('#labelNumOfTimesCreateWasClicked').val();
		    var rightNowCoordsArray = JSON.parse($('#labelCoordsArray').val());
		    
		    for(var i = 0; i < rightNowCoordsArray.length; i++) {
		    	points.push(rightNowCoordsArray[i]);
		    }
		    
		    for(var i = 0; i < (refreshedNumOfClicks + 1); i++) {
		    	
		    	if(i <= refreshedNumOfClicks && points.length != 0) {
		    		context.fillStyle = "#000000";
					context.fillRect(points[i][0], points[i][1], 20, 20);
					
					context.strokeStyle = "#FF0000";
					context.lineWidth = 2;
					context.strokeRect(points[i][0], points[i][1], 20, 20);
					
					//**Need to write a number within the "dot" where the user clicks
					context.fillStyle = "#FFFFFF";
					context.font = "bold 10pt Arial";
					context.fillText((i + 1).toString(), parseInt(points[i][0]) + 6, parseInt(points[i][1]) + 15);
					
					canvasPush();
					flag = true;
		    	}
		    }

		    if(!flag) { canvasPush(); }
		    
		    //Load the label elements third
		    
		    canvasClicks = parseInt($('#labelCurrentLabel').val());
		    curentLabel = parseInt(refreshedNumOfClicks) + 2;
		    
		    //if(!flag) { canvasPush(); }
		    
		    for(var i = 0; i < (points.length - 1); i++) {
		    	$('#CreateLabel').click();
		    }
		};
		imageObj.src = $('#labelImageTarget').val();
	}
	//*************************************** END of RUNS AFTER A POSTBACK /SUBMITTED (default running, not inside a function) *************************************	
	
	//******************************* Create Label Element ****************************************************************************************************
	$('#CreateLabel').click(function(e) {
		var value = [];
		
		//Runs during postback
		if($('#labelImageTarget').val() != "") {
			value = JSON.parse($('#labelLabelArray').val());
			$('#labelLabel1').val(value[0]);
		} //End of running during postback
		
		if(currentLabel < 10) { //Max of 9 labels
			var pElement = $('<p></p>').attr({'class': 'labelNumber'}).html(currentLabel + '. '); //childElement[0]
			var inputElement = $('<input>').attr({type: 'text', name: 'labelLabel' + currentLabel, id: 'labelLabel' + currentLabel, maxlength: '90', size: '25', placeholder: 'Label ' + currentLabel, value: value[numOfTimesCreateWasClicked + 1]}); //childElement[1]			
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
	
	//******************************* Form Submit Element ****************************************************************************************************
	$('#labelForm').submit(function(e) { //Store values entered in hidden fields, when submitted the $_POST hidden fields can be used to refill the javascript input textboxes
		var coordsArray = [];
		var labelArray = [];
		
		$('#labelPostback').val("1"); //it is a postback/edit when set to 1(true), default is 0(false)
		$('#labelCurrentLabel').val(currentLabel);
		$('#labelNumOfTimesCreateWasClicked').val(numOfTimesCreateWasClicked);
		
		for(var i = 1; i < parseInt(numOfTimesCreateWasClicked + 2); i++) {
			var ext = i.toString();
			labelArray.push($('#labelLabel' + ext).val());
		}
		
		var jsonSerializedLabels = JSON.stringify(labelArray); 
		$('#labelLabelArray').val(jsonSerializedLabels); //parse and save the label values as an array into the hidden input field
		
		for(var i = 0; i < points.length; i++) {
			var tempArray = [];
			tempArray.push(points[i][0]);
			tempArray.push(points[i][1]);
			coordsArray.push(tempArray);
		}
		
		var jsonSerializedCoords = JSON.stringify(coordsArray);
		$('#labelCoordsArray').val(jsonSerializedCoords); //parse and save the coord values as an array(2d array) into the hidden input field
		
	}); //******************************* END of Form Submit Element ****************************************************************************************************
	
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