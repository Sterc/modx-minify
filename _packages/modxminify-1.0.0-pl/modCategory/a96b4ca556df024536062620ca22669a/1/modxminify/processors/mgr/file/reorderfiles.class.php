<?php
/**
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyReOrderFilesProcessor extends modProcessor {

    public function initialize() {
        
        $this->modxMinify = $this->modx->getService('modxminify', 'modxMinify', $this->modx->getOption('modxminify.core_path', null, $this->modx->getOption('core_path') . 'components/modxminify/') . 'model/modxminify/');

        return parent::initialize();

    }

    public function process() {

        $order = $this->getProperty('order');
        $position = 0;
        $count = 0;
        if(count($order)) {
            foreach($order as $file) {
                $fileObject = $this->modx->getObject('modxMinifyFile',$file);
                if($fileObject) {
                    $fileObject->set('position',$position);
                    $fileObject->save();
                    $position++;
                $count++;
                }
                
            }
        }
        
        return json_encode(array(
            'success' => true,
            'total' => $count
        ));
        
    }

}
return 'modxMinifyReOrderFilesProcessor';