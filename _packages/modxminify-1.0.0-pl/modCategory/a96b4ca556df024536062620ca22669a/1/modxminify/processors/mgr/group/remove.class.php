<?php
/**
 * Remove a group
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyGroupRemoveProcessor extends modObjectRemoveProcessor
{
    public $classKey = 'modxMinifyGroup';
    public $languageTopics = array('modxminify:default');

    /**
     * Return the success message
     * @return array
     */
    public function cleanup()
    {
        $this->modx->modxminify->emptyMinifyCache($this->object->get('id'));
        return $this->success('', $this->object);
    }
}
return 'modxMinifyGroupRemoveProcessor';
