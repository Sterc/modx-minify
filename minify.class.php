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
			$this->log .= $this->config['configFile']." file not found.\n\r"; // file does not exist
			$isValid = false;
		}
		$configArray = json_decode(file_get_contents($this->config['configFile']),true);
		if(!is_array($configArray)) {
			$this->log .= "invalid ".$this->config['configFile']." file\n\r"; // file is not valid json
			$isValid = false;
		}
		$groups = (isset($configArray['groups']) ? $configArray['groups'] : array());
		if(!count($groups)) {
			$this->log .= "No files specified in groups. Check your ".$this->config['configFile']." file\n\r";
			$isValid = false;
		} else {
			$this->groups = $groups;
		}
		$this->minifyPath = $this->config['rootPath'].$configArray['minify_path'];

		return $isValid;

	}

	public function validateFile($file = false,$allowedExtensions = array('css','scss','js')) {

		$validFile = true;

		$filePath = $this->config['rootPath'].$file;
		if(!file_exists($filePath)) {
			// file does not exist
			$this->log .= 'Error: File "'.$filePath.'"" does not exist. Skipping..'."\n\r";
			$validFile = false;
		}
		$ext = pathinfo($filePath, PATHINFO_EXTENSION);
		if(!in_array($ext, $allowedExtensions)) {
			// not allowed extension
			// skip file
			// log extension in error message
			$this->log .= $ext." extension is not allowed\n\r";
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

		foreach($this->groups as $groupKey => $files) {
			
			if($group && $group != $groupKey) {
				// if group specified, only parse that group
				// when no group specified all groups will be parsed
				continue;
			}

			foreach($files as $file) {

				if(!$this->validateFile($file)) {
					// no valid files found in group (non-existent or not allowed extension)
					continue;
				}

			}

		}

	}

	public function showLog() {

		if (php_sapi_name() == "cli") {
			$log = $this->log;
		} else {
			$log = nl2br($this->log);
		}

		return $log;

	}

}