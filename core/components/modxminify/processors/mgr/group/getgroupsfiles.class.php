<?php
/**
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyGroupGetGroupsFilesProcessor extends modProcessor
{

    public function process()
    {

        $lexicons = $this->modx->lexicon->fetch('modxminify');
        $c = $this->modx->newQuery('modxMinifyGroup');
        $c->sortby('id', 'asc');
        $groups = $this->modx->getCollection('modxMinifyGroup', $c);
        $output = '';
        $count = 0;
        foreach ($groups as $group) {
            $items = '';
            $c = $this->modx->newQuery('modxMinifyFile');
            $c->where(array('group' => $group->get('id')));
            $c->sortby('position', 'asc');
            $files = $this->modx->getCollection('modxMinifyFile', $c);
            $filesCount = 0;
            foreach ($files as $file) {
                $placeholders = array_merge(
                    $file->toArray(),
                    $lexicons
                );
                $items .= $this->modx->modxminify->getChunk('file_item', $placeholders);
                $filesCount++;
            }
            if ($filesCount) {
                $inner = $this->modx->modxminify->getChunk('wrapper', array('class' => 'files', 'output' => $items));
            } else {
                $inner = '<div class="no-results">'.$this->modx->lexicon('modxminify.file.noresults').'</div>';
            }
            $output .= $this->modx->modxminify->getChunk(
                'group_item',
                array_merge(
                    $group->toArray(),
                    array('inner' => $inner),
                    $lexicons
                )
            );
            $count++;
        }
        $html = $this->modx->modxminify->getChunk('wrapper', array('class' => 'groups', 'output' => $output));
        return json_encode(array(
            'success' => true,
            'total' => $count,
            'html' => $html
        ));
    }
}
return 'modxMinifyGroupGetGroupsFilesProcessor';
