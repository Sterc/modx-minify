<?php
/**
 * Create an Item
 * 
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyGroupCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'modxMinifyGroup';
    public $languageTopics = array('modxminify:default');

    public function beforeSave() {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('modxminify.err.item_name_ns'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('modxminify.err.item_name_ae'));
        }
        return parent::beforeSave();
    }
}
return 'modxMinifyGroupCreateProcessor';
