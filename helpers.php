<?php
//includes
include 'config.php';

function headers() {
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: *");
    header("Content-Type: application/json");
}

function generate_meta($arr) {
	$meta_arr = array("type" => "movie", 
	                  "id" => $arr['id'],
					  "name" => $arr['name'],
					  "genre" => $arr['genre'],
					  "banner" => $arr['img'],
					  "poster" => $arr['poster'],
					  "background" => $arr['img'],
					  "posterShape" => "landscape",
					  "description" => $arr['description'],
					  "runtime" => "Length:{$arr['runtime']}, Added on:{$arr['date']}");
    return $meta_arr;					  
}


function compare_time($time) {
	$t =time();
	if (($t - $time) > 3600) {
		return true;
	}
	else 
		return false;
}



