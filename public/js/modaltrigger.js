$(function(){
	  $('#changepasswordbtn').click(function(e){
		  
		  var post_data = {	  
				'userId': $('#chgUserId').val(),
				'userName': $('#chgUserName').val(),
				'cryptPass': $('#chgCryptPassword').val(),
				'oldPass': $('#chgOldPassword').val(),
		  		'newPass': $('#chgNewPassword').val(),
		  		'repeatPass': $('#chgRepeatPassword').val()
		  };
		  
		  //clear the input fields after submit, and reset all the spacing
		  $('#oldPasswordError1').html('');
		  $('#oldPasswordError2').html('');
		  $('#newPasswordError1').html('');
		  $('#newPasswordError2').html('');
		  $('#repeatPasswordError1').html('');
		  $('.forgotpassworderrormsg2').removeAttr("style");
		  $('.forgotpassworderrormsg3').removeAttr("style");
		  $('.forgotpassworderrormsg4').removeAttr("style");
		  
		  //Ajax post data to server
		  $.post('../../controllers/helpers/changePasswordValidation.php', post_data, function(response) {
			  var validationValues = jQuery.parseJSON(response);		 
			 
			 if(Object.keys(validationValues).length == 0) {
				 
				 $('#passwordChangeMessage').html("Password has been changed. This will close automatically.");
				 
				 //clear input fields if everything is correct
				 $('#changepasswordmodal input[name=chgOldPassword]').val('');
				 $('#changepasswordmodal input[name=chgNewPassword]').val('');
				 $('#changepasswordmodal input[name=chgRepeatPassword]').val('');
			 
				 //close the modal in 2.5 seconds when everything is correct
				 setTimeout(function() {
					 $('#passwordChangeMessage').html("");
					 $('#lean_overlay').trigger("click");
				 }, 2200);
			 }
			 else {
				 if(typeof validationValues.oldPassError1 !== 'undefined') { //true
					 $('#oldPasswordError1').html('*Old password must at lease have 7 characters');
					 $('.forgotpassworderrormsg2').css("padding-bottom", "7px");
				 }
				 else {
					 if(typeof validationValues.oldPassError2 !== 'undefined') { //true
						 $('#oldPasswordError2').html('*Old password does not match the one in database');
						 $('.forgotpassworderrormsg2').css("padding-bottom", "7px");
					 }
				 }
				 
				 if(typeof validationValues.newPassError1 !== 'undefined') { //true
					 $('#newPasswordError1').html('*New password must at lease have 7 characters');
					 $('.forgotpassworderrormsg3').css("padding-bottom", "7px");
				 }
				 else {
					 if(typeof validationValues.newPassError2 !== 'undefined') { //true
						 $('#newPasswordError2').html('*New / repeat password does not match each other');
						 $('.forgotpassworderrormsg3').css("padding-bottom", "7px");
					 }
				 }
				 
				 if(typeof validationValues.repeatPassError1 !== 'undefined') {
					 $('#repeatPasswordError1').html('*Repeat password must at lease have 7 characters');
					 $('.forgotpassworderrormsg4').css("padding-bottom", "7px");
				 }
			 }
		  });
		  
		  //return false;
	  });

	  $('a[rel*=triggerModal]').leanModal({ top: 110, overlay: 0.45, closeButton: ".hide_modal" });
});