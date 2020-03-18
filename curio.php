<?php
include 'config.php';
include 'helpers.php';

function curio_generate_cache() {
	$data = file_get_contents("https://api.curio.io/api/stories?allow303=1");
	$data = json_decode($data,true);
	$time = time();
	$fin['time'] = $time;
	$i = 0;
	foreach($data['data'] as $d) {
		$fin['res'][$i]['id'] = $d['id'];
		$fin['res'][$i]['title'] = $d['title'];
		$fin['res'][$i]['description'] = $d['description'];
		$fin['res'][$i]['provider'] = $d['provider']['name'];
		$fin['res'][$i]['image'] = $d['imageUrl'];
		$fin['res'][$i]['stream'] = $d['media']['mp3Url'];
		$fin['res'][$i]['time'] = $d['media']['duration'];
		$fin['res'][$i]['extlink'] = $d['articleUrl'];
		$fin['res'][$i]['date'] = $d['publishedAt'];
		$i++;
	}
	file_put_contents(PATH,json_encode($fin));
}

function curio_get_cache() {
	if (!(file_exists(PATH))) {
		curio_generate_cache();
	}
	$data = file_get_contents(PATH);
	$data = json_decode($data,true);
	if (compare_time($data['time'])) {
		curio_generate_cache();
	}
	return $data;
}

function curio_get_genres() {
	$providers = file_get_contents("https://api.curio.io/api/providers");
	$providers = json_decode($providers,true);
	foreach ($providers['data'] as $d) {
		$t[] = $d['name'];
	}
	return $t;
}

function curio_home() {
	$fin = curio_get_cache();
	for ($i=0;$i<65;$i++) {
		$final[$i]['id'] = "curio:{$fin['res'][$i]['id']}";
		$final[$i]['description'] = $fin['res'][$i]['description'];
		$final[$i]['name'] = $fin['res'][$i]['title'];
		$final[$i]['poster'] = $fin['res'][$i]['image'];
		$final[$i]['runtime'] = $fin['res'][$i]['time']/60;
		$final[$i]['date'] = $fin['res'][$i]['date'];
		$final[$i]['genre'] = array($fin['res'][$i]['provider']);
		$metas['metas'][] = generate_meta($final[$i]);
	}
	return $metas;
}

function curio_meta($id) {
	$fin = curio_get_cache();
	foreach ($fin['res'] as $f) {
		if ($f['id'] == $id) {
			$final['id'] = "curio:{$id}";
			$final['description'] = $f['description'];
			$final['name'] = $f['title'];
			$final['poster'] = $f['image'];
			$final['runtime'] = $f['time']/60;
			$final['date'] = $f['date'];
			$final['genre'] = array($f['provider']);
			break;			
		}
	}
	return $final;
}

function curio_stream($id) {
	$fin = curio_get_cache();
	foreach ($fin['res'] as $f) {
		if ($f['id'] == $id) {
			$stream_arr['streams']['0']['url'] = $f['stream'];
			$stream_arr['streams']['0']['title'] = "MP3 Audio" ;
			$stream_arr['streams']['0']['name'] = "curio";
			$stream_arr['streams']['1']['externalUrl'] = $f['extlink'];
			$stream_arr['streams']['1']['title'] = "News Article Link" ;
			$stream_arr['streams']['1']['name'] = "curio";
			break;			
		}
	}
	return $stream_arr;
}

function curio_genre($id) {
	$data = curio_get_cache();
	$i = 0;
	foreach ($data['res'] as $fin) {
		if ($fin['provider'] == $id) {
			$final[$i]['id'] = "curio:{$fin['id']}";
			$final[$i]['description'] = $fin['description'];
			$final[$i]['name'] = $fin['title'];
			$final[$i]['poster'] = $fin['image'];
			$final[$i]['runtime'] = $fin['time']/60;
			$final[$i]['date'] = $fin['date'];
			$final[$i]['genre'] = array($fin['provider']);
			$metas['metas'][] = generate_meta($final[$i]);
			$i++;
			if ($i > 65)
				break;
		}
	}
	return $metas;
}

function curio_home_skip($quant) {
	$fin = curio_get_cache();
	$size = sizeof($fin['res']);
	if ($size > $quant) {
		$f = $quant + 65;
		for ($i=$quant;$i<$f;$i++) {
			$final[$i]['id'] = "curio:{$fin['res'][$i]['id']}";
			$final[$i]['description'] = $fin['res'][$i]['description'];
			$final[$i]['name'] = $fin['res'][$i]['title'];
			$final[$i]['poster'] = $fin['res'][$i]['image'];
			$final[$i]['runtime'] = $fin['res'][$i]['time']/60;
			$final[$i]['date'] = $fin['res'][$i]['date'];
			$final[$i]['genre'] = array($fin['res'][$i]['provider']);
			$metas['metas'][] = generate_meta($final[$i]);
		}
	}
	else 
		$metas = null;
	return $metas;		
}

function curio_genre_skip($id,$quant) {
	$data = curio_get_cache();
	foreach ($data['res'] as $fin) {
		if ($fin['provider'] == $id) {
			$fina[] = $fin;
		}
	}
	$size = sizeof($fina);
	if ($size > $quant) {
		$f = $quant + 65;
		for ($i=$quant;$i<$f;$i++) {
			$final[$i]['id'] = "curio:{$fina[$i]['id']}";
			$final[$i]['description'] = $fina[$i]['description'];
			$final[$i]['name'] = $fina[$i]['title'];
			$final[$i]['poster'] = $fina[$i]['image'];
			$final[$i]['runtime'] = $fina[$i]['time']/60;
			$final[$i]['date'] = $fina[$i]['date'];
			$final[$i]['genre'] = array($fina[$i]['provider']);
			$metas['metas'][] = generate_meta($final[$i]);
		}
	}
	else 
		$metas = null;
	return $metas;
}
