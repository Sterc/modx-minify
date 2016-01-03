<?php
/**
 * Create an Item
 * 
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyFileCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    public function beforeSet(){
        $items = $this->modx->getCollection($this->classKey);

        $this->setProperty('position', count($items));

        return parent::beforeSet();
    }

    public function beforeSave() {
        $filename = $this->getProperty('filename');

        if (empty($filename)) {
            $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.item_name_ns'));
        } else if ($this->doesAlreadyExist(array('filename' => $filename))) {
            $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.item_name_ae'));
        }
        return parent::beforeSave();
    }
}
return 'modxMinifyFileCreateProcessor';
