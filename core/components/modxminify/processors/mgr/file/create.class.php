<?php
/**
 * Create an Item
 * 
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyFileCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');

    public function beforeSet(){
        $items = $this->modx->getCollection($this->classKey);

        $this->setProperty('position', count($items));

        return parent::beforeSet();
    }

    public function beforeSave() {
        $filename = $this->getProperty('filename');

        if (empty($filename)) {
            $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.item_name_ns'));
        }

        return parent::beforeSave();

    }

    public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        $this->object->fromArray($this->getProperties());//

        /* run the before save logic */
        $canSave = $this->beforeSave();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        /* run object validation */
        if (!$this->object->validate()) {
            /** @var modValidator $validator */
            $validator = $this->object->getValidator();
            if ($validator->hasMessages()) {
                foreach ($validator->getMessages() as $message) {
                    $this->addFieldError($message['field'],$this->modx->lexicon($message['message']));
                }
            }
        }

        $preventSave = $this->fireBeforeSaveEvent();
        if (!empty($preventSave)) {
            return $this->failure($preventSave);
        }

        // check for multiple filenames from textarea
        // a bit ugly because exploding on "/r/n" or PHP_EOL does not work for some reason
        $allFiles = nl2br($this->object->get('filename'));
        $allFiles = explode('<br />', $allFiles);
        foreach($allFiles as $file) {
            if (!empty($file)) {
                if ($this->doesAlreadyExist(array('filename' => $file))) {
                    $this->addFieldError('filename',$this->modx->lexicon('modxminify.err.item_name_ae').': '.$file);
                }
                $new = $this->modx->newObject($this->classKey);
                $new->set('group', $this->object->get('group'));
                $new->set('filename',$file);
                $new->save();
            }
        }
        $this->afterSave();
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }
}
return 'modxMinifyFileCreateProcessor';
