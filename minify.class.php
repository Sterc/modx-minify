<?php
/**
 * The base class for Modx Minify.
 */

require 'assetic/vendor/autoload.php';
use Assetic\AssetManager;
use Assetic\AssetWriter;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\ScssphpFilter;
use Assetic\Filter\JSMinFilter;

class ModxMinify {

    public $modx = null;
    public $log;
    public $groups = array();
    public $config = array();
    public $minifyPath;

    function __construct() {

		$this->config = array(
			'rootPath' => dirname(__DIR__),
			'configFile' => __DIR__.'/config.json'
		);

    }
    
    public function initModx() {

		require_once $this->config['rootPath'].'/config.core.php';
		require_once MODX_CORE_PATH.'model/modx/modx.class.php';
		$modx = new modX();
		$modx->initialize('web');
		$modx->getService('error','error.modError', '', '');
		$this->modx = $modx;

	}

	public function parseConfig() {

		$isValid = true;

		if(!file_exists($this->config['configFile'])) {
			$this->log .= "### Error: ".$this->config['configFile']." file not found.\n\r"; // file does not exist
			$isValid = false;
		}
		$configArray = json_decode(file_get_contents($this->config['configFile']),true);
		if(!is_array($configArray)) {
			$this->log .= "### Error: invalid ".$this->config['configFile']." file\n\r"; // file is not valid json
			$isValid = false;
		}
		$groups = (isset($configArray['groups']) ? $configArray['groups'] : array());
		if(!count($groups)) {
			$this->log .= "### Error: No files specified in groups. Check your ".$this->config['configFile']." file\n\r";
			$isValid = false;
		} else {
			$this->groups = $groups;
		}
		$this->minifyPath = $this->config['rootPath'].$configArray['minify_path'];

		return $isValid;

	}

	public function validateFile($filePath = false, $fileExt = false, $allowedExtensions = array('css','scss','js')) {

		$validFile = true;

		// $filePath = $this->config['rootPath'].$file;
		if(!file_exists($filePath)) {
			// file does not exist
			$this->log .= '### Error: File "'.$filePath.'"" does not exist. Skipping..'."\n\r";
			$validFile = false;
		}
		// $ext = pathinfo($filePath, PATHINFO_EXTENSION);
		if(!in_array($fileExt, $allowedExtensions)) {
			// not allowed extension
			// skip file
			// log extension in error message
			$this->log .= '### Error: '.$fileExt.' extension is not allowed'."\n\r";
			$validFile = false;
		}

		return $validFile;

	}

	public function minifyFiles($group = false) {

		if(!$this->parseConfig()) {
			// invalid config file.. show log for specific errors
			echo $this->showLog();
			return false;
		}

		$minifiedFiles = array();
		
		$am = new AssetManager();
		$writer = new AssetWriter($this->minifyPath);

		foreach($this->groups as $groupKey => $files) {
			
			if($group && $group != $groupKey) {
				// if group specified, only parse that group
				// when no group specified all groups will be parsed
				continue;
			}

			$allFiles = array();
			$fileDates = array();
			$updatedFiles = 0;

			foreach($files as $file) {

				$filePath = $this->config['rootPath'].$file;
				$fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
				if(!$this->validateFile($filePath,$fileExt)) {
					// no valid files found in group (non-existent or not allowed extension)
					continue;
				} else {
					$this->log .= 'File '.$filePath.' successfully added to group.'."\n\r";
				}

				$fileFilter = array();
				$minifyFilter = array();
				if($fileExt == 'js') {
					$minifyFilter = array(new JSMinFilter());
					$filePrefix = 'scripts';
					$fileSuffix = '.min.js';
				} else {
					if($fileExt = 'scss') {
						$fileFilter = array(new ScssphpFilter());
					}
					$minifyFilter = array(new CssMinFilter());
					$filePrefix = 'styles';
					$fileSuffix = '.min.css';
				}
				$fileDates[] = filemtime($filePath);
				$allFiles[] = new FileAsset($filePath,$fileFilter);

			} // endforeach $files

			if(count($fileDates) && count($allFiles)) {

				sort($fileDates);
				$lastEdited = end($fileDates);
				$minifyFilename = $filePrefix.'-'.$groupKey.'-'.$lastEdited.$fileSuffix;

				// find the old minified files
				// if necessary, remove old and generate new, based on file modification time of minified file
				foreach (glob($this->minifyPath.'/'.$filePrefix.'-'.$groupKey.'-*'.$fileSuffix) as $current) {
				    if(filemtime($current) > $lastEdited) {
				    	// current file is up to date
				    	$this->log .= 'Minified file "'.basename($current).'" up to date. Skipping group "'.$groupKey.'" minification.'."\n\r";
				    	$minifyFilename = basename($current);
				    	$minifiedFiles[$groupKey] = $this->minifyPath.'/'.$minifyFilename;
				    	continue 2;
				    } else {
				    	unlink($current);
				    	$this->log .= 'Removing current file '.$current."\n\r";
				    }
				}
				$updatedFiles++;

				$this->log .= "Writing ".$minifyFilename."\n\r";
				$collection = new AssetCollection($allFiles,$minifyFilter);
				$collection->setTargetPath($minifyFilename);
				$am->set($groupKey, $collection);

				$minifiedFiles[$groupKey] = $this->minifyPath.'/'.$minifyFilename;


			} else {

				$this->log .= 'No files parsed from group '.$groupKey.'. Check the log for more info.'."\n\r";

			}

		} // endforeach $this->groups

		if($updatedFiles > 0) {
			$writer->writeManagerAssets($am);
		}

		if(count($minifiedFiles)) {

			// $this->initModx();

			foreach($minifiedFiles as $groupKey => $filename) {
				// $cacheOptions = array(xPDO::OPT_CACHE_KEY => 'modxminify');
				$filename = str_replace('\\', '/', $filename); // dirty fix for windows folders
				$filename = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filename); // setting the relative path to script, instead of absolute path
				// $this->modx->cacheManager->set('modxminify_filename_'.$groupKey, $filename, 0, $cacheOptions);
			}
		}

		// if group isset as function param, then return that group filename
		if($group && $filename) {
			return $filename;
		}

		return;

	}

	public function showLog() {

		// if script accessed from commandline don't use nl2br
		if (php_sapi_name() == "cli") {
			$log = $this->log;
		} else {
			$log = nl2br($this->log);
		}

		echo $log;

	}

}