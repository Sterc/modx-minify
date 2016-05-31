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

        $groups = $this->modx->getCollection('modxMinifyGroup',$c);
        $output = '';
        $count = 0;
        foreach($groups as $group) {
            $items = '';
            $c = $this->modx->newQuery('modxMinifyFile');
            $c->where(array('group' => $group->get('id')));
            $c->sortby('position','asc');
            $files = $this->modx->getCollection('modxMinifyFile',$c);
            foreach($files as $file) {
                $placeholders = array_merge(
                    $file->toArray(),
                    array(
                        'lang.update_file' => $this->modx->lexicon('modxminify.global.update').' '.$this->modx->lexicon('modxminify.file'),
                        'lang.remove_file' => $this->modx->lexicon('modxminify.global.remove').' '.$this->modx->lexicon('modxminify.file')
                    )
                );
                $items .= $this->modxMinify->getChunk('file_item', $placeholders);
            }
            $inner = $this->modxMinify->getChunk('wrapper', array('class' => 'files', 'output' => $items));
            $output .= $this->modxMinify->getChunk('group_item', array('name' => $group->get('name'), 'inner' => $inner));
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