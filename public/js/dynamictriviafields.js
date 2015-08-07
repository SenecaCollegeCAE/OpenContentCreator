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
	console.log(widths);
	
	$('#questionlist a').click(function(e) {
		e.preventDefault();
		
		var thisLink = $(this);
		
		$('.smallbox1').removeClass('smallbox1');
		thisLink.parent().addClass('smallbox1');
		
		
		current = thisLink.parent().index() + 1;
		
		$('.steps').stop().animate({
			marginLeft: '-' + widths[current - 1] + 'px'
		}, 750);
	});
	
});
