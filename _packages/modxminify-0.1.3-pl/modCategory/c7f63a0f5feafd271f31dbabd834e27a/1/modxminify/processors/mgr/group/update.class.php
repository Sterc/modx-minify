<?php
/**
 * Update an Item
 * 
 * @package modxminify
 * @subpackage processors
 */

class modxMinifyGroupUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'modxMinifyGroup';
    public $languageTopics = array('modxminify:default');

    public function beforeSet() {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('modxminify.err.item_name_ns'));

        } else if ($this->modx->getCount($this->classKey, array('name' => $name)) && ($this->object->name != $name)) {
            $this->addFieldError('name',$this->modx->lexicon('modxminify.err.item_name_ae'));
        }
        return parent::beforeSet();
    }

}
return 'modxMinifyGroupUpdateProcessor';