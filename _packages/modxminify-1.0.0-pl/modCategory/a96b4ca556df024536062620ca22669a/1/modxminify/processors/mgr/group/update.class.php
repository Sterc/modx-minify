<?php
/**
 * Update a group
 *
 * @package modxminify
 * @subpackage processors
 */

class modxMinifyGroupUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'modxMinifyGroup';
    public $languageTopics = array('modxminify:default');

    public function beforeSet()
    {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name', $this->modx->lexicon('modxminify.err.item_name_ns'));
        } else if ($this->modx->getCount($this->classKey, array('name' => $name)) && ($this->object->name != $name)) {
            $this->addFieldError('name', $this->modx->lexicon('modxminify.err.item_name_ae'));
        }
        return parent::beforeSet();
    }

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
return 'modxMinifyGroupUpdateProcessor';
