<?php
/**
 * 
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyFileLoadContentProcessor extends modProcessor {

    public function initialize() {
        
        $this->modxMinify = $this->modx->getService('modxminify', 'modxMinify', $this->modx->getOption('modxminify.core_path', null, $this->modx->getOption('core_path') . 'components/modxminify/') . 'model/modxminify/');

        return parent::initialize();

    }

    public function process() {

        $chunk = $this->getProperty('chunk');
        $data = !empty($this->getProperty('data')) ? $this->getProperty('data') : array();
        $includeObject = $this->getProperty('includeObject');
        if($includeObject && isset($data['id'])) {
            $object = $this->modx->getObject($includeObject,$data['id']);
            if($object) {
                $data = array_merge($data,$object->toArray());
            }
        }
        $placeholders = array_merge($data,$this->modx->lexicon->fetch('modxminify'));
        $content = $this->modxMinify->getChunk($chunk, $placeholders);
        return json_encode(array(
            'success' => true,
            'html' => $content
        ));

    }
}
return 'modxMinifyFileLoadContentProcessor';