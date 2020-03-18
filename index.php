<?php
//includes
include 'curio.php';

headers();

if ($_GET['id'] == "curio_home") {
	if ($_GET['extra']) {
		if (strpos($_GET['extra'], "&") !== false) {
			$sep = explode("&",$_GET['extra']);
			$gen = explode("=",$sep['0']);
			$skp = explode("=",$sep['1']);
			$data = curio_genre_skip($gen['1'],$skp['1']);
			echo json_encode($data);
		}
		else {
			$genre = explode("=",$_GET['extra']);
			if ($genre['0'] == "genre") {
				$data = curio_genre($genre['1']);
				echo json_encode($data);
			}
			elseif ($genre['0'] == "skip") {
				$data = curio_home_skip($genre['1']);
				echo json_encode($data);			
			}
			else {
				echo $_GET['extra'];
			}
		}	
	}
	else {
		$data = curio_home();
		echo json_encode($data);
	}
}
elseif ($_GET['content'] == "meta") {
	$id = explode(":",$_GET['id']);
	$metas = generate_meta(curio_meta($id['1']));	
	$meta_final['meta'] = $metas;
	echo json_encode($meta_final);
}
elseif ($_GET['content'] == "stream") {
	$id = explode(":",$_GET['id']);
	echo json_encode(curio_stream($id['1']));	
}
