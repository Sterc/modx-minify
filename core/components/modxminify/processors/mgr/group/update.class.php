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

    /**
     * Return the success message
     * @return array
     */
    public function cleanup() {
        $modxminify = $this->modx->getService('modxminify','modxMinify',$this->modx->getOption('modxminify.core_path',null,$this->modx->getOption('core_path').'components/modxminify/').'model/modxminify/',array());
        if (!($modxminify instanceof modxMinify)) return '';
        $modxminify->emptyMinifyCache($this->object->get('id'));
        return $this->success('',$this->object);
    }

}
return 'modxMinifyGroupUpdateProcessor';