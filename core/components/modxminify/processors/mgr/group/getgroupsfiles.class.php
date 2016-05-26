<?php
/**
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyGroupGetGroupsFilesProcessor extends modProcessor {

    public function initialize() {
        
        $this->modxMinify = $this->modx->getService('modxminify', 'modxMinify', $this->modx->getOption('modxminify.core_path', null, $this->modx->getOption('core_path') . 'components/modxminify/') . 'model/modxminify/');

        return parent::initialize();

    }

    public function process() {

        $groups = $this->modx->getCollection('modxMinifyGroup');
        $output = '';
        $count = 0;
        foreach($groups as $group) {
            $items = '';
            $files = $this->modx->getCollection('modxMinifyFile',array('group' => $group->get('id')));
            foreach($files as $file) {
                $items .= $this->modxMinify->getChunk('item', array('name' => $file->get('filename')));
            }
            $inner = $this->modxMinify->getChunk('wrapper', array('class' => 'files', 'output' => $items));
            $output .= $this->modxMinify->getChunk('item', array('name' => $group->get('name'), 'inner' => $inner));
            $count++;
        }
        $html = $this->modxMinify->getChunk('wrapper', array('class' => 'groups', 'output' => $output));
        return json_encode(array(
            'success' => true,
            'total' => $count,
            'html' => $html
        ));
        
    }

}
return 'modxMinifyGroupGetGroupsFilesProcessor';