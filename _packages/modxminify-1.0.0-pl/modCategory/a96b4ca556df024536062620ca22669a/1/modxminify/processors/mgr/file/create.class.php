<?php
/**
 * Create a file
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyFileCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    public function beforeSet()
    {
        $group = $this->getProperty('group');
        $items = $this->modx->getCollection($this->classKey, array('group' => $group));

        $this->setProperty('position', count($items));

        return parent::beforeSet();
    }

    public function beforeSave()
    {
        $filename = $this->getProperty('filename');
        $group = $this->getProperty('group');

        if (empty($filename)) {
            $this->addFieldError('filename', $this->modx->lexicon('modxminify.err.item_name_ns'));
        }
        if ($this->doesAlreadyExist(array('filename' => $filename,'group' => $group))) {
            $this->addFieldError('filename', $this->modx->lexicon('modxminify.err.item_name_ae'));
        }

        return parent::beforeSave();
    }

    /**
     * Return the success message
     * @return array
     */
    public function cleanup()
    {
        $this->modx->modxminify->emptyMinifyCache($this->object->get('group'));
        return $this->success('', $this->object);
    }
}
return 'modxMinifyFileCreateProcessor';
