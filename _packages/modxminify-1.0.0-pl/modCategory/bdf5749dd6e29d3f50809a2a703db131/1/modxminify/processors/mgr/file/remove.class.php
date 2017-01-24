<?php
/**
 * Remove a file
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyFileRemoveProcessor extends modObjectRemoveProcessor
{
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    /**
     * Return the success message
     * @return array
     */
    public function cleanup()
    {
        $this->modx->modxminify->emptyMinifyCache($this->object->get('group'));
    }
}
return 'modxMinifyFileRemoveProcessor';
