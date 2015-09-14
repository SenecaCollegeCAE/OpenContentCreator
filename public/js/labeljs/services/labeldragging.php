<?php
	session_start();
	require_once("../../../../application/controllers/helpers/storedActivityInfo.php");
	header('Content-Type: application/javascript');
?>

app.factory("labelDraggingFactory", function($window, createReplayButtonFactory) {
	var num = <?php echo $activityObj[7]; ?>;
	var backgroundObj = new Image();
	
	function loadImages(sources, callback, scope) {
        var images = {};
        var loadedImages = 0;
        var numImages = 0;
        
        for(var src in sources) {
          numImages++;
        }
        
        for(var src in sources) {
        	images[src] = new Image();
        	images[src].onload = function() {
          		if(++loadedImages >= numImages) {
          			callback(images, scope);
            	}
          	};
        	images[src].src = sources[src];
        }
    } //function loadImages(sources, callback)
	
	function isNearOutline(icon, outline) {
    	var a = icon;
        var o = outline;
        var ax = a.getX();
        var ay = a.getY();
        
        if(ax > o.x - 20 && ax < o.x + 20 && ay > o.y - 20 && ay < o.y + 20)
          return true;
        else
          return false;
    } //function isNearOutline(icon, outline)
	
	function drawBackground(background, backgroundImg, text) {
		var context = background.getContext();

		var width = 650;
		var height = 500;
       	var ratio = 1;

       	if(backgroundImg.width > width)
	    	ratio = width / backgroundImg.width;
        else if(backgroundImg.height > height)
	        ratio = height / backgroundImg.height;

       	 w = backgroundImg.width * ratio;
	     h = backgroundImg.height * ratio;

        if(w >= 630)
			w = 610;
	    if(h >= 480)
			h = 460;
	    	
	    context.drawImage(backgroundImg, 0, 0, w, h);
	    context.setAttr('font', '20pt Calibri');
	    context.setAttr('textAlign', 'center');
	    context.setAttr('fillStyle', 'white');
	    context.fillText(text, background.getStage().getWidth() / 2, 40);
	}
	
	function initStage(images, scope) {
		var stage = new Kinetic.Stage({
			container: "container",
	        width: 650,
	        height: 500,
	        id: 'myCanvas'
		});

		var backgroundLayer = new Kinetic.Layer();
		var labelCoordsLayer = new Kinetic.Layer();
		var labelCoords = [];
		var score = 0;

		//image icons position
		var icons = {};
		var yValue = 20;
		
		<?php for($i = 1; $i < ($activityObj[7] + 2); $i++) { ?>
				icons['num' + <?php echo $i; ?>] = { x: 620, y: yValue };
				yValue += 35;
		<?php } ?>
		
		var outlines = {};
		
		<?php 
			for($i = 1; $i < ($activityObj[7] + 2); $i++) { 
				$coordString = $activityObj[8][$i - 1];
				$coordX = $coordString[0] - 25;
				$coordY = $coordString[1] - 25;
		?>
				outlines['num' + <?php echo $i; ?> + '_blank'] = { x: <?php echo $coordX; ?>, y: <?php echo $coordY; ?> };
		<?php } ?>
		
		//Create the draggable icons
		for(var key in icons) {
			(function() {
				var privateKey = key;
				var ic = icons[key];
				
				var icon = new Kinetic.Image({
					image: images[key],
					x: ic.x,
					y: ic.y,
					draggable: true,
					brightness: 0,
					blurRadius: 0
				});
				
				icon.cache();
				icon.drawHitFromCache();
				icon.filters([Kinetic.Filters.Blur, Kinetic.Filters.Brighten]);
				
				icon.on('dragstart', function() {
					this.moveToTop();
					labelCoordsLayer.draw();
				});
				
				icon.on('dragend', function() {
					var outline = outlines[privateKey + '_blank'];
					
					if(!icon.inRightPlace && isNearOutline(icon, outline)) {				              
						statusText.style.color = "black";
						statusText.innerHTML = "The label is correct.";
					    icon.setPosition({x:outline.x, y:outline.y});
					    labelCoordsLayer.draw();
					    icon.inRightPlace = true;
			
					    // disable drag and drop
					    score++;
					                
					    setTimeout(function() {
					    	icon.setDraggable(false);
					    }, 50);
			
		                if(score > num) {
			            	//console.log("you win here");
			            	statusText.style.color = "#009900";
		                	statusText.innerHTML = 'Congratulations! You have completed the label activity.&nbsp;';
							
							createReplayButtonFactory.createButton(scope);
		                }
	              	}
	              	else {
		            	statusText.style.color = "red";
				  		statusText.innerHTML = "The label's location is incorrect, please drag to the correct location.";
	              	}
				});
				
				icon.on('mouseover touchstart', function() {
					icon.blurRadius(1);
				    icon.brightness(0.3);
				    labelCoordsLayer.draw();
				    document.body.style.cursor = 'pointer';
				});
				
				icon.on('mouseout touchend', function() {
	            	icon.blurRadius(0);
	            	icon.brightness(0);
	            	labelCoordsLayer.draw();
	            	document.body.style.cursor = 'default';
				});
				
				icon.on('dragmove', function() {
					document.body.style.cursor = 'pointer';
				});
				
				 labelCoordsLayer.add(icon);
				 labelCoords.push(icon);
			})();
		}
		
		for(var key in outlines) {
          // anonymous function to induce scope
          (function() {
            var imageObj = images[key];
            var out = outlines[key];

            var outline = new Kinetic.Image({
              image: imageObj,
              x: out.x,
              y: out.y
            });

            labelCoordsLayer.add(outline);
          })();
		}
		
		stage.add(backgroundLayer);
		stage.add(labelCoordsLayer);
		drawBackground(backgroundLayer, images.bg, "");
	}
	
	var sources = {bg: '<?php echo "../" . $activityObj[5]; ?>'};
	
	for(var i = 1; i < (num + 2); i++) {
		switch(i) {
			case 1:
				sources["num" + i] = "../../../../public/img/layout/num1.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank1.png";
				break;
				
			case 2:
				sources["num" + i] = "../../../../public/img/layout/num2.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank2.png";
				break;
				
			case 3:
				sources["num" + i] = "../../../../public/img/layout/num3.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank3.png";
				break;
				
			case 4:
				sources["num" + i] = "../../../../public/img/layout/num4.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank4.png";
				break;
				
			case 5:
				sources["num" + i] = "../../../../public/img/layout/num5.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank5.png";
				break;
			
			case 6:
				sources["num" + i] = "../../../../public/img/layout/num6.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank6.png";
				break;
				
			case 7:
				sources["num" + i] = "../../../../public/img/layout/num7.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank7.png";
				break;
				
			case 8:
				sources["num" + i] = "../../../../public/img/layout/num8.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank8.png";
				break;	
				
			default:
				sources["num" + i] = "../../../../public/img/layout/num9.png";
				sources["num" + i + "_blank"] = "../../../../public/img/layout/blank9.png";
		}
	}
	
	return{
		loadLabelDragging: function(scope) {
			loadImages(sources, initStage, scope);
			return;
		}
	};
});