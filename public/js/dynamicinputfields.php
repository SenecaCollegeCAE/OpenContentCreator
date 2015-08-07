<?php 
	header("Content-type: application/javascript");
	
	//The maxFields will be fixed to a new number when it is in edit mode
?>
$(document).ready(function() {
	var maxFields = 10;
	var wrapper = $(".input_fields_wrap");
	var addButton = $(".add_field_button");
	var linkSpacer = $("#link_spacer");
	
	var x  = 1; //initial text box count
	var h = 303; //initial link spacing between the links and evaluation fields
	
	linkSpacer.css("height", h);
	
	$(addButton).click(function(e){
		e.preventDefault();
		
		if(x < maxFields) {
			x++;
			h += 303;
			
			linkSpacer.css("height", h);
			$(wrapper).append('<div><br /><input type="url" name="webquestLink[]" size="58" placeholder="Additional links you want the learner to see" /> <a href="#" class="remove_field">Remove</a><br /><br /><textarea name="webquestTask[]" placeholder="Additional tasks you want the learner to do"></textarea><br /><br /><textarea name="webquestQuestion[]" placeholder="Additional question(s) you want the learner to answer"></textarea></div>');
		}
		else
			alert("Max is 10 fields");
	});
	
	$(wrapper).on("click", ".remove_field", function(e){
		e.preventDefault();
		
		h -= 303;
		
		linkSpacer.css("height", h);
		$(this).parent('div').remove();
		x--;
	});
	
	<?php 
		//Triggers when user submits the form
		if(isset($_GET['clicks'])) {
			for($i = 1; $i < $_GET['clicks']; $i++) {
	?>
				$(addButton).click();	
	<?php 
			}
			
			session_start();
			$links = unserialize($_SESSION['webquestLinks']);
			$tasks = unserialize($_SESSION['webquestTasks']);
			$questions = unserialize($_SESSION['webquestQuestions']);
	?>
			var js_links = [];
			var js_tasks = [];
			var js_questions = [];
	<?php 
			for($i = 0; $i < count($links); $i++) {
//var_dump(htmlspecialchars($questions[$i]));
	?>		
				js_links[<?php echo $i; ?>] = "<?php echo $links[$i]; ?>";
				js_tasks[<?php echo $i; ?>] = "<?php echo str_ireplace("\r\n", "\\n", htmlspecialchars($tasks[$i])); ?>";
				js_questions[<?php echo $i; ?>] = "<?php echo str_ireplace("\r\n", "\\n", htmlspecialchars($questions[$i])); ?>";
	<?php 
			} //for($i = 0; $i < count($links); $i++)
	?>
				var i = 0; 
				$('input[name="webquestLink[]"]').each(function() {
					$(this).val(js_links[i]);
					i++;
				});
				
				var j = 0; 
				$('textarea[name="webquestTask[]"]').each(function() {
					$(this).val($(this).html(js_tasks[j]).val());
					j++;
				});
				
				var k = 0; 
				$('textarea[name="webquestQuestion[]"]').each(function() {
					$(this).val($(this).html(js_questions[k]).val());
					k++;
				});
				
	<?php 
		} //if(isset($_GET['clicks'])) {
	?>
});