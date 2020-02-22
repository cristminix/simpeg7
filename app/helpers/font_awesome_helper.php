<?php
function icon_array(){
	$pattern = '/\.(icon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
	$parsed_file = file_get_contents('assets/css/font-awesome/latest/css/font-awesome.css');

		preg_match_all("/fa\-([a-zA-z0-9\-]+[^\:\.\,\s])/", $parsed_file, $matches);
		$exclude_icons = array("fa-lg", "fa-2x", "fa-3x", "fa-4x", "fa-5x", "fa-ul", "fa-li", "fa-fw", "fa-border", "fa-pulse", "fa-rotate-90", "fa-rotate-180", "fa-rotate-270", "fa-spin", "fa-flip-horizontal", "fa-flip-vertical", "fa-stack", "fa-stack-1x", "fa-stack-2x", "fa-inverse");
		
		$needle = (is_array($exclude_icons)) ? array_values(array_diff($matches[0], $exclude_icons)) : array_values(array_diff($matches[0], array($exclude_icons)));
		$icon = array();
		$i=0;
		/* foreach($needle as $key=>$val){
			$icon[$i]["value"]= $val;
			$icon[$i]["id"]	= "fa ".$val;
			$icon[$i]["icon"] = "fa ".$val;
			$i++;
		} */
		return json_encode($needle);
	
}