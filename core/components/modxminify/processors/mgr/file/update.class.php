<?php
/**
 * Update a file
 * 
 * @package modxminify
 * @subpackage processors
 */

class modxMinifyFileUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    public function beforeSet() {
        $filename = $this->getProperty('filename');
        $group = $this->getProperty('group');

        if (empty($filename)) {
            $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.item_filename_ns'));
        }

        if (empty($group)) {
            $this->addFieldError('group',$this->modx->lexicon('modxminify.err.item_group_ns'));
        }

        if ($this->modx->getCount($this->classKey, array('filename' => $filename, 'group' => $group)) && ($this->object->filename != $filename)) {
            $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.item_filename_ae'));
        }
        return parent::beforeSet();
    }

}
return 'modxMinifyFileUpdateProcessor';