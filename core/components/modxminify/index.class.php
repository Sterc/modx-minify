<?php
require_once dirname(__FILE__) . '/model/modxminify/modxminify.class.php';
/**
 * @package modxminify
 */

abstract class modxMinifyBaseManagerController extends modExtraManagerController {
    /** @var modxMinify $modxminify */
    public $modxminify;
    public function initialize() {
        $this->modxminify = new modxMinify($this->modx); 
        parent::initialize();
    }
    public function getLanguageTopics() {
        return array('modxminify:default');
    }
    public function checkPermissions() { return true;}
}