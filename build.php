<?php
require 'assetic/vendor/autoload.php';
use Assetic\AssetManager;
use Assetic\AssetWriter;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\ScssphpFilter;
use Assetic\Filter\JSMinFilter;

$output = '';
$root = dirname(dirname(__FILE__));
$config = 'config.json';
if(!file_exists($config)) {
	$output .= $config." file not found.\n\r"; // file does not exist
}
// print_r(json_decode(file_get_contents($config)));exit;
$configArray = json_decode(file_get_contents($config),true);
if(!is_array($configArray)) {
	$output .= "invalid ".$config." file\n\r"; // file is not valid json
}
$groups = (isset($configArray['groups']) ? $configArray['groups'] : array());
if(!count($groups)) {
	$output .= "No files specified in groups. Check your ".$config." file\n\r";
}

$am = new AssetManager();
$writer = new AssetWriter($root.$configArray['minify_path']);

foreach($groups as $groupKey => $files) {
	$allFiles = array();
	foreach($files as $file) {
		$filePath = $root.$file;
		if(!file_exists($filePath)) {
			// file does not exist
			// log filename in error message
			continue;
		}
		$ext = pathinfo($filePath, PATHINFO_EXTENSION);
		if(!in_array($ext, array('css','scss','js'))) {
			// not allowed extension
			// skip file
			// log in error message
			$output .= $ext." extension is not allowed\n\r";
			continue;
		}
		$fileFilter = array();
		$minifyFilter = array();
		if($ext == 'js') {
			$minifyFilter = array(new JSMinFilter());
			$minifyFilename = 'scripts.min.js';
		} else {
			if($ext = 'scss') {
				$fileFilter = array(new ScssphpFilter());
			}
			$minifyFilter = array(new CssMinFilter());
			$minifyFilename = 'styles.min.css';
		}
		$allFiles[] = new FileAsset($filePath,$fileFilter);
	}
	$output .= "Writing ".$minifyFilename."\n\r";
	$collection = new AssetCollection($allFiles,$minifyFilter);
	$collection->setTargetPath($minifyFilename);
	$am->set($groupKey, $collection);
}

$writer->writeManagerAssets($am);
echo $output;

?>