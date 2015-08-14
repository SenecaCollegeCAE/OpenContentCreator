$(document).ready(function() {

	var current = 1;	
	var stepsWidth = 0;
	var widths = [];

	$('.steps .input_step_wrap').each(function(i) {
		var step = $(this);
		widths[i] = stepsWidth;

		stepsWidth += step.width(); 
	});
	$('.steps').width(stepsWidth);
	//console.log(widths);
	
	$('#questionlist a').click(function(e) {
		e.preventDefault();
		
		var thisLink = $(this); //get the link tag and id
		var questionNumber = parseInt((thisLink.attr('id')).match(/\d+/)[0], 10); //get the question number from the link tag and id
				
		$('.smallbox1').removeClass('smallbox1'); //remove the previous class that has class name "smallbox1"
		thisLink.parent().addClass('smallbox1'); //then assign the clicked link as the new class for "smallbox1" 
		
		current = thisLink.parent().index() + 1;
		
		$('.steps').stop().animate({
			marginLeft: '-' + widths[current - 1] + 'px'
		}, 750);
		
		//check if the question number is 6 and above	
		if(questionNumber > 5) {
			switch(questionNumber) {
			case 6:
				if($('#triviaQuestion5').val() != "" && $('#triviaCorrectAnswer5').val() != "" && $('#triviaWrongAnswer1_5').val() != "" && $('#triviaWrongAnswer2_5').val() != "" && $('#triviaWrongAnswer3_5').val() != "") {
					$('#triviaDifficulty6').prop('disabled', false);
					$('#triviaQuestion6').prop('disabled', false);
					$('#triviaCorrectAnswer6').prop('disabled', false);
					$('#triviaWrongAnswer1_6').prop('disabled', false);
					$('#triviaWrongAnswer2_6').prop('disabled', false);
					$('#triviaWrongAnswer3_6').prop('disabled', false);
					$('#triviaHint6').prop('disabled', false);
				}
				break;
			
			case 7:
				if($('#triviaQuestion6').val() != "" && $('#triviaCorrectAnswer6').val() != "" && $('#triviaWrongAnswer1_6').val() != "" && $('#triviaWrongAnswer2_6').val() != "" && $('#triviaWrongAnswer3_6').val() != "") {
					$('#triviaDifficulty7').prop('disabled', false);
					$('#triviaQuestion7').prop('disabled', false);
					$('#triviaCorrectAnswer7').prop('disabled', false);
					$('#triviaWrongAnswer1_7').prop('disabled', false);
					$('#triviaWrongAnswer2_7').prop('disabled', false);
					$('#triviaWrongAnswer3_7').prop('disabled', false);
					$('#triviaHint7').prop('disabled', false);
				}
				break;
				
			case 8:
				if($('#triviaQuestion7').val() != "" && $('#triviaCorrectAnswer7').val() != "" && $('#triviaWrongAnswer1_7').val() != "" && $('#triviaWrongAnswer2_7').val() != "" && $('#triviaWrongAnswer3_7').val() != "") {
					$('#triviaDifficulty8').prop('disabled', false);
					$('#triviaQuestion8').prop('disabled', false);
					$('#triviaCorrectAnswer8').prop('disabled', false);
					$('#triviaWrongAnswer1_8').prop('disabled', false);
					$('#triviaWrongAnswer2_8').prop('disabled', false);
					$('#triviaWrongAnswer3_8').prop('disabled', false);
					$('#triviaHint8').prop('disabled', false);
				}
				break;
				
			case 9:
				if($('#triviaQuestion8').val() != "" && $('#triviaCorrectAnswer8').val() != "" && $('#triviaWrongAnswer1_8').val() != "" && $('#triviaWrongAnswer2_8').val() != "" && $('#triviaWrongAnswer3_8').val() != "") {
					$('#triviaDifficulty9').prop('disabled', false);
					$('#triviaQuestion9').prop('disabled', false);
					$('#triviaCorrectAnswer9').prop('disabled', false);
					$('#triviaWrongAnswer1_9').prop('disabled', false);
					$('#triviaWrongAnswer2_9').prop('disabled', false);
					$('#triviaWrongAnswer3_9').prop('disabled', false);
					$('#triviaHint9').prop('disabled', false);
				}
				break;
				
			case 10:
				if($('#triviaQuestion9').val() != "" && $('#triviaCorrectAnswer9').val() != "" && $('#triviaWrongAnswer1_9').val() != "" && $('#triviaWrongAnswer2_9').val() != "" && $('#triviaWrongAnswer3_9').val() != "") {
					$('#triviaDifficulty10').prop('disabled', false);
					$('#triviaQuestion10').prop('disabled', false);
					$('#triviaCorrectAnswer10').prop('disabled', false);
					$('#triviaWrongAnswer1_10').prop('disabled', false);
					$('#triviaWrongAnswer2_10').prop('disabled', false);
					$('#triviaWrongAnswer3_10').prop('disabled', false);
					$('#triviaHint10').prop('disabled', false);
				}
				break;
				
			case 11:
				if($('#triviaQuestion10').val() != "" && $('#triviaCorrectAnswer10').val() != "" && $('#triviaWrongAnswer1_10').val() != "" && $('#triviaWrongAnswer2_10').val() != "" && $('#triviaWrongAnswer3_10').val() != "") {
					$('#triviaDifficulty11').prop('disabled', false);
					$('#triviaQuestion11').prop('disabled', false);
					$('#triviaCorrectAnswer11').prop('disabled', false);
					$('#triviaWrongAnswer1_11').prop('disabled', false);
					$('#triviaWrongAnswer2_11').prop('disabled', false);
					$('#triviaWrongAnswer3_11').prop('disabled', false);
					$('#triviaHint11').prop('disabled', false);
				}
				break;
				
			default:
				if($('#triviaQuestion11').val() != "" && $('#triviaCorrectAnswer11').val() != "" && $('#triviaWrongAnswer1_11').val() != "" && $('#triviaWrongAnswer2_11').val() != "" && $('#triviaWrongAnswer3_11').val() != "") {
					$('#triviaDifficulty12').prop('disabled', false);
					$('#triviaQuestion12').prop('disabled', false);
					$('#triviaCorrectAnswer12').prop('disabled', false);
					$('#triviaWrongAnswer1_12').prop('disabled', false);
					$('#triviaWrongAnswer2_12').prop('disabled', false);
					$('#triviaWrongAnswer3_12').prop('disabled', false);
					$('#triviaHint12').prop('disabled', false);
				}
			}
		}
	});
	
});
