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
return 'modxMinifyGroupCreateProcessor';
