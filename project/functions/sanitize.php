<?php
function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function is_match_in_array($pattern, $haystack = array()){
	foreach ($haystack as $key => $str){
		error_log($key, 0);
		if(preg_match_all($pattern, $str)){
	  		return true;
	  	}
	}
	return false;	
}

function array_exclude_keys($array, Array $excludeKeys){
    foreach($excludeKeys as $key){
        unset($array[$key]);
    }
    return $array;
}