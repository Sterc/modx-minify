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
}
return 'modxMinifyFileGetListProcessor';