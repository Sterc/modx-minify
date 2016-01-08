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
    public $defaultSortField = 'group';
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

    public function getData() {
        $data = array();
        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));

        /* query for chunks */
        $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey,$c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey,$this->getProperty('sortAlias',$sortClassKey),'',array($this->getProperty('sort')));
        if (empty($sortKey)) $sortKey = $this->getProperty('sort');
        $c->sortby($sortKey,$this->getProperty('dir'));
        // adding second sortby
        $c->sortby('position','asc');
        if ($limit > 0) {
            $c->limit($limit,$start);
        }

        $data['results'] = $this->modx->getCollection($this->classKey,$c);
        return $data;
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