<?php
//includes
include 'curio.php';
// enable CORS and set JSON Content-Type
headers();

//Manifest Begin
$manifest = new stdClass();
$manifest->id = $config['id'];
$manifest->version = $config['version'];
$manifest->name = $config['name'];
$manifest->description = $config['description'];
$manifest->icon = $config['icon'];
$manifest->resources = array("catalog", "meta", "stream");
$manifest->types = array("movie");
$manifest->idPrefixes = array("curio");

// define catalog
$catalog[0]['type'] = "movie";
$catalog[0]['name'] = "Curio Home";
$catalog[0]['id'] = "curio_home";
$catalog[0]['extraSupported'] = array("genre","skip");
$catalog[0]['genres'] = curio_get_genres();

// set catalogs in manifest
$manifest->catalogs = $catalog;

//Final JSON
echo json_encode((array)$manifest);

?>