<?php
/**
 * Remove an Item.
 * 
 * @package modxminify
 * @subpackage processors
 */
class modxMinifyGroupRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'modxMinifyGroup';
    public $languageTopics = array('modxminify:default');
    public $objectType = 'modxminify.item';
}
return 'modxMinifyGroupRemoveProcessor';