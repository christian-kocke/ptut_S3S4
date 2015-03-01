<?php
function escape($string){
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function is_match_in_array($pattern, $haystack = array()){
	foreach ($haystack as $key => $str){
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

function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    error_log(call_user_func_array('array_multisort', $args));
    return array_pop($args);
}