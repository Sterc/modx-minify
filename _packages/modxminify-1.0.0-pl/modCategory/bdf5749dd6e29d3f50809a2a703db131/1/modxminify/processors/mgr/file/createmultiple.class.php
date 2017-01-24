<?php
/**
 * Create multiple items
 * 
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyFileCreateMultipleProcessor extends modObjectCreateProcessor {
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    public function process() {
        
        $data = $this->getProperties();

        // check if filename is empty
        if (empty($data['filename'])) {
            $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.file_name_ns'));
            return $this->failure();
        }

        // check for multiple filenames from textarea
        // a bit ugly because exploding on "/r/n" or PHP_EOL does not work for some reason
        $allFiles = nl2br($data['filename']);
        $allFiles = explode('<br />', $allFiles);
        foreach($allFiles as $file) {
            $file = trim($file);
            if (!empty($file)) {

                $data['filename'] = $file;

                // check if file doesn't already exist in group
                if ($this->modx->getObject('modxMinifyFile',array('filename' => $file,'group' => $data['group']))) {
                    $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.file_name_ae'));
                    return $this->failure();
                }

                // check if file exists on server
                if (!file_exists($this->modx->getOption('base_path').$file)) {
                    $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.file_name_notexist'));
                    return $this->failure();
                }

                $path = $this->modx->getOption('modxminify.core_path',null,$this->modx->getOption('core_path').'components/modxminify/').'processors/';
                $response = $this->modx->runProcessor(
                    'mgr/file/create', 
                    $data,
                    array(
                        'processors_path' => $path,
                        'location' => '',
                    )
                );
                if ($response->isError()) {
                    return $response->getMessage();
                }
            }
        }
        return $this->cleanup();
    }

}
return 'modxMinifyFileCreateMultipleProcessor';
