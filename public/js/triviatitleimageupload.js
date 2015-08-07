$("#triviaTitleImage").on('change', function() {
	var imgPath = $(this)[0].value;
	var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
	
	var uploadPreview = $("#uploadPreview"); 
	uploadPreview.empty();
	
	if(extn == "gif" || extn =="jpg" || extn == "png" || extn == "jpeg") {
		if(typeof (FileReader) != "undefined") {
			var reader = new FileReader();
			reader.onload = function(e) {
				$("<img />", {
					"src": e.target.result,
					"class": "thumb-image",
				}).appendTo(uploadPreview);
			};
			uploadPreview.show();
			reader.readAsDataURL($(this)[0].files[0]);
		}
	}
});

$("#removeImage").click(function(e) {
	e.preventDefault();
	
	if($('#uploadPreview').children().length > 0) {
		var uploadButton = $("#triviaTitleImage");
		
		$(".thumb-image").remove();
		$("#triviaTitleImageHidden").val("");
		uploadButton.replaceWith(uploadButton = uploadButton.clone(true));
	}
});

//Edit mode
if($('#activityNumber').val() != "") {
	var uploadPreview = $("#uploadPreview"); 
	uploadPreview.empty();
	
	$("<img src='" + $('#triviaTitleImageHidden').val() +"' class='thumb-image' />").appendTo(uploadPreview);

	uploadPreview.show();		
}