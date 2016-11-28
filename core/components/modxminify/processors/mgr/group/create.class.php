<?php
/**
 * Create an Item
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyGroupCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'modxMinifyGroup';
    public $languageTopics = array('modxminify:default');

    public function beforeSave()
    {
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name', $this->modx->lexicon('modxminify.err.group_name_ns'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name', $this->modx->lexicon('modxminify.err.group_name_ae'));
        }
        return parent::beforeSave();
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
return 'modxMinifyGroupCreateProcessor';
