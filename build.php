<?php
require 'assetic/vendor/autoload.php';
use Assetic\AssetManager;
use Assetic\AssetWriter;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\ScssphpFilter;
use Assetic\Filter\JSMinFilter;

// initialize the modx class
require_once(dirname(dirname(__FILE__)) . '/config.core.php');
require_once(MODX_CORE_PATH . 'model/modx/modx.class.php');

$output = '';
$root = dirname(dirname(__FILE__));
$config = dirname(__FILE).'/config.json';
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

$minifyPath = $root.$configArray['minify_path'];
$minifiedFiles = array();
$updatedFiles = 0;

$am = new AssetManager();
$writer = new AssetWriter($minifyPath);

foreach($groups as $groupKey => $files) {

	$output .= '========= group: '.$groupKey.' ========='."\n\r";

	$allFiles = array();
	$fileDates = array();

	foreach($files as $file) {
		$filePath = $root.$file;
		if(!file_exists($filePath)) {
			// file does not exist
			// log filename in error message
			$output .= 'Error: File "'.$filePath.'"" does not exist. Skipping..'."\n\r";
			continue;
		}
		$ext = pathinfo($filePath, PATHINFO_EXTENSION);
		if(!in_array($ext, array('css','scss','js'))) {
			// not allowed extension
			// skip file
			// log extension in error message
			$output .= $ext." extension is not allowed\n\r";
			continue;
		}
		$fileFilter = array();
		$minifyFilter = array();
		if($ext == 'js') {
			$minifyFilter = array(new JSMinFilter());
			$filePrefix = 'scripts';
			$fileSuffix = '.min.js';
		} else {
			if($ext = 'scss') {
				$fileFilter = array(new ScssphpFilter());
			}
			$minifyFilter = array(new CssMinFilter());
			$filePrefix = 'styles';
			$fileSuffix = '.min.css';
		}
		$fileDates[] = filemtime($filePath);
		$allFiles[] = new FileAsset($filePath,$fileFilter);
	} // endforeach $files

	sort($fileDates);
	$lastEdited = end($fileDates);
	$minifyFilename = $filePrefix.'-'.$groupKey.'-'.$lastEdited.$fileSuffix;

	// find the old minified files
	// if necessary, remove old and generate new, based on file modification time of minified file
	foreach (glob($minifyPath.'/'.$filePrefix.'-'.$groupKey.'-*'.$fileSuffix) as $current) {
	    if(filemtime($current) > $lastEdited) {
	    	// current file is up to date
	    	$output .= 'Minified file "'.basename($current).'" up to date. Skipping group "'.$groupKey.'" minification.'."\n\r";
	    	$minifyFilename = basename($current);
	    	$minifiedFiles[$groupKey] = $configArray['minify_path'].'/'.$minifyFilename;
	    	continue 2;
	    } else {
	    	unlink($current);
	    	$output .= 'Removing current file '.$current."\n\r";
	    }
	}

	$updatedFiles++;

	$output .= "Writing ".$minifyFilename."\n\r";
	$collection = new AssetCollection($allFiles,$minifyFilter);
	$collection->setTargetPath($minifyFilename);
	$am->set($groupKey, $collection);

	$minifiedFiles[$groupKey] = $configArray['minify_path'].'/'.$minifyFilename;
}

if($updatedFiles > 0) {
	$writer->writeManagerAssets($am);
}
if(count($minifiedFiles)) {
	$modx = new modX();
	$modx->initialize('web');
	$modx->getService('error','error.modError', '', '');
	foreach($minifiedFiles as $groupKey => $filename) {
		$cacheOptions = array(xPDO::OPT_CACHE_KEY => 'modxminify');
		$modx->cacheManager->set('modxminify_filename_'.$groupKey, $filename, 0, $cacheOptions);
	}
	$output .= print_r($minifiedFiles,true);
}

echo nl2br($output);


?>