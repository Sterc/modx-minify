<?php
/**
 * Get list Items
 *
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyFileGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modxMinifyFile';
    public $languageTopics = array('modxminify:default');
    public $defaultSortField = 'position';
    public $defaultSortDirection = 'ASC';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'filename:LIKE' => '%'.$query.'%'
            ));
        }
        return $c;
    }

    public function prepareRow(xPDOObject $object) {
        $groupId = $object->get('group');
        if($groupId){
            $getGroup = $this->modx->getObject('modxMinifyGroup',$groupId);
            if($getGroup) {
                $groupName = $getGroup->get('name');
                $object->set('group_name', $groupName);
            }
        }
        $lastmodified = filemtime($this->modx->getOption('base_path').$object->get('filename'));
        $object->set('last_modified', date('Y-m-d H:i:s',$lastmodified));

        return parent::prepareRow($object);
    }

}
return 'modxMinifyFileGetListProcessor';