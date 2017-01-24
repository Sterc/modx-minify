<?php
/**
 * Update a file
 *
 * @package modxminify
 * @subpackage processors
 */

class modxMinifyFileUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    public function beforeSet()
    {
        $filename = $this->getProperty('filename');
        $group = $this->getProperty('group');

        if (empty($filename)) {
            $this->addFieldError('filename', $this->modx->lexicon('modxminify.err.item_filename_ns'));
        }

        if (empty($group)) {
            $this->addFieldError('group', $this->modx->lexicon('modxminify.err.item_group_ns'));
        }

        if ($this->modx->getCount($this->classKey, array('filename' => $filename, 'group' => $group)) && ($this->object->filename != $filename)) {
            $this->addFieldError('filename', $this->modx->lexicon('modxminify.err.file_name_ae_single'));
        }

        // check if file exists on server
        if (!file_exists($this->modx->getOption('base_path').$filename)) {
            $this->addFieldError('filename', $this->modx->lexicon('modxminify.err.file_name_notexist_single'));
            // return $this->failure();
        }

        return parent::beforeSet();
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
return 'modxMinifyFileUpdateProcessor';
