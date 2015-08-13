<?php	
	set_time_limit(10);

	//Set content-type header to load an image
	header("Content-type: image/png");
	
	require_once("../../../../resources/library/phpMyGraph5.0.php");
	
	//Set the configuration directives
	$cfg['title'] = 'Audience Suggestion By Percentage';
	$cfg['width'] = '400';
	$cfg['height'] = '500';
	$cfg['column-color-random'] = true;
	$cfg['title-font-size'] = 4;
	$cfg['average-line-visible'] = 0;
	
	//Set data by randomly generating 5 numbers that add up to 100%
	$numberOfGroups = 5;
	$maxPercentage = 100;
	$groups = array();
	$group = 0;
	
	while(array_sum($groups) != $maxPercentage) {
		$groups[$group] = mt_rand(0, $maxPercentage/mt_rand(1, 5));
	
		if(++$group == $numberOfGroups)
			$group = 0;
	}
	
	$data = array(
			'Answer 1' => $groups[0],
			'Answer 2' => $groups[1],
			'Answer 3' => $groups[2],
			'Answer 4' => $groups[3],
			'Not Sure' => $groups[4]
	);
	
	//Create the php Graph instance
	$graph = new phpMyGraph();
	
	//Parse
	$graph->parseVerticalSimpleColumnGraph($data, $cfg);
?>