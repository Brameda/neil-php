<?php
	
	
function image_url($asset, $width, $height, $mode, $title){
	
}

function image_tag($asset, $width, $height, $mode, $title){
	
}
	

function facet_option_set_url($filter, $option){
	
	if(isset($_GET['filters'])){
		$filters = $_GET['filters'];
	} else {
		$filters = array();
	}
	
	array_push($filters, $filter['code'].':'.$option['value']);
	
	print_r($filters);
	
	return $_SERVER['SCRIPT_NAME'] . '?' . http_build_query($filters);
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