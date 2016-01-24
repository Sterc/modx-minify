<?php
/**
 * Remove an Item.
 * 
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyGroupRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'modxMinifyGroup';
    public $languageTopics = array('modxminify:default');

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
return 'modxMinifyGroupRemoveProcessor';