<?php

use Assetic\AssetManager;
use Assetic\AssetWriter;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Filter\MinifyCssCompressorFilter;
use Assetic\Filter\CSSUriRewriteFilter;
use Assetic\Filter\ScssphpFilter;
use Assetic\Filter\LessphpFilter;
use Assetic\Filter\JSMinFilter;

/**
 * The main modxMinify service class.
 *
 * @package modxminify
 */
class modxMinify {
    public $modx = null;
    public $namespace = 'modxminify';
    public $cache = null;
    public $options = array();

    public function __construct(modX &$modx, array $options = array()) {
        $this->modx =& $modx;
        $this->namespace = $this->getOption('namespace', $options, 'modxminify');

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/modxminify/');
        $assetsPath = $this->getOption('assets_path', $options, $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/modxminify/');
        $assetsUrl = $this->getOption('assets_url', $options, $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/modxminify/');

        /* loads some default paths for easier management */
        $this->options = array_merge(array(
            'namespace' => $this->namespace,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'templatesPath' => $corePath . 'templates/',
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'connectorUrl' => $assetsUrl . 'connector.php',
            'rootPath' => $this->modx->getOption('base_path'),
            'cacheOptions' => array(xPDO::OPT_CACHE_KEY => 'modxminify'),
            'cachePath' => $assetsPath.'cache',
            'cacheUrl' => $assetsUrl.'cache'
        ), $options);

        $this->modx->addPackage('modxminify', $this->getOption('modelPath'));
        $this->modx->lexicon->load('modxminify:default');
    }

    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override local options.
     * @param mixed $default The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getOption($key, $options = array(), $default = null) {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->options)) {
                $option = $this->options[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    /**
     * Process files from specified group with Assetic library
     * https://github.com/kriswallsmith/assetic
     *
     * @param string|int $group
     *
     * @return string
     */
    public function minifyFiles($group) {

        $group = $this->getGroupId($group);

        $output = '';
        $filenames = $this->getGroupFilenames($group);
        if(count($filenames)) {

            require_once $this->options['corePath'] . 'assetic/vendor/autoload.php';

            $minifiedFiles = array();
        
            $am = new AssetManager();
            $writer = new AssetWriter($this->options['rootPath']);
            $allFiles = array();
            $fileDates = array();
            $updatedFiles = 0;
            $skipMinification = 0;

            foreach($filenames as $file) {

                $filePath = $this->options['rootPath'].$file;
                $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
                if(!$this->validateFile($filePath,$fileExt)) {
                    // no valid files found in group (non-existent or not allowed extension)
                    $this->log('File '.$filePath.' not valid.'."\n\r", 'error');
                    continue;
                } else {
                    $this->log('File '.$filePath.' successfully added to group.'."\n\r");
                }

                $fileFilter = array();
                $minifyFilter = array();
                if($fileExt == 'js') {
                    $minifyFilter = array(new JSMinFilter());
                    $filePrefix = 'scripts';
                    $fileSuffix = '.min.js';
                } else {
                    // if file is .scss, use the correct filter to parse scss to css
                    if($fileExt == 'scss') {
                        $fileFilter = array(new ScssphpFilter());
                    }
                    // if file is .less, use the correct filter to parse less to css
                    if($fileExt == 'less') {
                        $fileFilter = array(new LessphpFilter());
                    }
                    $minifyFilter = array(new CSSUriRewriteFilter(), new MinifyCssCompressorFilter());
                    $filePrefix = 'styles';
                    $fileSuffix = '.min.css';
                }
                $fileDates[] = filemtime($filePath);
                $allFiles[] = new FileAsset($filePath,$fileFilter);

            } // endforeach $files

            if(count($fileDates) && count($allFiles)) {

                sort($fileDates);
                $lastEdited = end($fileDates);
                $minifyFilename = $filePrefix.'-'.$group.'-'.$lastEdited.$fileSuffix;

                // find the old minified files
                // if necessary, remove old and generate new, based on file modification time of minified file
                foreach (glob($this->options['cachePath'].'/'.$filePrefix.'-'.$group.'-*'.$fileSuffix) as $current) {
                    if(filemtime($current) > $lastEdited) {
                        // current file is up to date
                        $this->log('Minified file "'.basename($current).'" up to date. Skipping group "'.$group.'" minification.'."\n\r");
                        $minifyFilename = basename($current);
                        $skip = 1;
                    } else {
                        unlink($current);
                        $this->log('Removing current file '.$current."\n\r");
                    }
                }
                $updatedFiles++;

                $this->log("Writing ".$minifyFilename."\n\r");
                $collection = new AssetCollection($allFiles,$minifyFilter);
                $collection->setTargetPath($this->options['cacheUrl'].'/'.$minifyFilename);
                $am->set($group, $collection);

                if($updatedFiles > 0 && $skip == 0) {
                    $writer->writeManagerAssets($am);
                }
                $output = $this->options['cacheUrl'].'/'.$minifyFilename;

            } else {

                $this->log('No files parsed from group '.$group.'. Check the log for more info.'."\n\r",'error');

            }


        } else {
            // No files in specified group
        }
        return $output;

    }

    /**
     * Get all the filenames that are added to a group
     *
     * @param string $group
     *
     * @return array
     */
    public function getGroupFilenames($group) {

        $filenames = $this->modx->cacheManager->get('group_'.$group.'_filenames', $this->options['cacheOptions']);
        if(!$filenames) {
            $filenames = array();
            $c = $this->modx->newQuery('modxMinifyFile');
            $c->where(array(
                'group' => $group
            ));
            $c->sortby('position','asc');
            $collection = $this->modx->getCollection('modxMinifyFile',$c);
            foreach($collection as $file) {
                $filenames[$file->get('id')] = $file->get('filename');
            }
            $this->modx->cacheManager->set('group_'.$group.'_filenames', $filenames, 0, $this->options['cacheOptions']);
        }
        return $filenames;

    }

     /**
     * Validates a single file
     *
     * @param string $filePath
     * @param string $fileExt
     * @param array $allowedExtensions
     *
     * @return boolean
     */
    public function validateFile($filePath = false, $fileExt = false, $allowedExtensions = array('css','scss','less','js')) {

        $validFile = true;

        if(!file_exists($filePath)) {
            // file does not exist
            // $this->log .= '### Error: File "'.$filePath.'"" does not exist. Skipping..'."\n\r";
            $validFile = false;
        }
        // $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        if(!in_array($fileExt, $allowedExtensions)) {
            // not allowed extension
            // skip file
            // log extension in error message
            $this->log('### Error: '.$fileExt.' extension is not allowed'."\n\r",'error');
            $validFile = false;
        }

        return $validFile;

    }


    /**
     * Returns the group ID based on group name.
     *
     * @param string|int $group
     *
     * @return integer
     */
    public function getGroupId($group) {

        if(is_numeric($group)) {
            $groupId = intval($group);
        } else {
            $groupObj = $this->modx->getObject('modxMinifyGroup',array('name' => $group));
            if($groupObj) {
                $groupId = $groupObj->get('id');
            }
        }
        return $groupId;

    }

    /**
     * Empty the modx cache files and remove minified file(s) for group
     *
     * @param string|int $group
     *
     * @return empty
     */
    public function emptyMinifyCache($group) {

        $group = $this->getGroupId($group);
        if($group) {
            $this->modx->cacheManager->delete('group_'.$group.'_filenames', $this->options['cacheOptions']);
            foreach (glob($this->options['cachePath'].'/*-'.$group.'-*') as $current) {
                unlink($current);
            }
        }
        return;

    }

     /**
     * Empty the modx cache files and remove minified file(s) for all groups
     * @return empty
     */
    public function emptyMinifyCacheAll() {

        $groups = $this->modx->getCollection('modxMinifyGroup');
        foreach($groups as $group) {
            $this->modx->log(xPDO::LOG_LEVEL_INFO,'[modxMinify] Cache files for group '.$group->get('name').' cleared.');
            $this->emptyMinifyCache($group->get('id'));
        }
        return;

    }

    /**
     * Write group data + group files to json file
     *
     * @param   string|int $group
     * @return 	empty
     */
    public function writeGroupFile($group) {

    	$group = $this->getGroupId($group);
    	$groupObj = $this->modx->getObject('modxMinifyGroup',$group);
        $groupsConfigFile = $this->options['assetsPath'].'config.json';
        if($groupObj && is_writable($this->options['assetsPath'])) {
            $groupsArray = json_decode(file_get_contents($groupsConfigFile),true);
            if(!count($groupsArray)) {
                $groupsArray = array();
            }
            $groupsArray[$group]['group'] = $groupObj->toArray();
            $filesColl = $this->modx->getCollection('modxMinifyFile',array('group' => $group));
            foreach($filesColl as $file) {
                $groupsArray[$group]['files'][$file->get('id')] = $file->toArray();
            }
            $fp = fopen($groupsConfigFile, 'w');
            fwrite($fp, json_encode($groupsArray));
            fclose($fp);
        }
        return;

    }

    /**
     * Write message to log
     *
     * @param string $message
     * @param string $level
     *
     */
    public function log($message,$level = 'info') {
        switch ($level) {
            case 'error':
                $this->modx->log(xPDO::LOG_LEVEL_ERROR,$message);
                break;
            case 'info':
            default:
                $this->modx->log(xPDO::LOG_LEVEL_INFO,$message);
                break;
        }
    }

}