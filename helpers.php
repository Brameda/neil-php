<?php
	
	


	
function image_url($asset, $width, $height, $mode, $title){
	
}

function image_tag($asset, $width, $height, $mode, $title){
	
}


function _get_filters_from_request(){
	$query  = explode('&', $_SERVER['QUERY_STRING']);
	$params = array();

	foreach( $query as $param ){
	  list($name, $value) = explode('=', $param);
	  $params[urldecode($name)][] = urldecode($value);
	}

	if(isset($params['filters'])){
		$filters = $params['filters'];
	} else {
		$filters = array();
	}
	
	return $filters;
}

function facet_option_set_url($filter, $option){
	
	$filters = _get_filters_from_request();
	$filters[] = $filter['code'].':'.$option['value'];
	
	print_r($filters);
	
	$params_get = array_merge($_GET, array('filters'=>$filters));
	
	foreach($filters as $item){
		print $item
	}
	
	print_r($params);
	
	return $_SERVER['SCRIPT_NAME'] . '?' . urldecode(http_build_query($params));
}

function facet_option_set_tag($filter, $option){
	$url = facet_option_set_url($filter, $option);
	return '<a href="'.$url.'">'.$option['label'].' ('.$option['count'].')</a>';
}

function facet_option_remove_url($filter, $option){
}

function facet_option_remove_tag($filter, $option){
}

	
?>