<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';
/**
 * Loads the home page.
 *
 * @package modxminify
 * @subpackage controllers
 */
class modxMinifyHomeManagerController extends modxMinifyBaseManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('modxminify'); }
    public function loadCustomCssJs() {
    
    
        $this->addJavascript($this->modxminify->getOption('jsUrl').'mgr/extras/griddraganddrop.js');
        $this->addJavascript($this->modxminify->getOption('jsUrl').'mgr/widgets/groups.grid.js');
        $this->addJavascript($this->modxminify->getOption('jsUrl').'mgr/widgets/files.grid.js');
        $this->addJavascript($this->modxminify->getOption('jsUrl').'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->modxminify->getOption('jsUrl').'mgr/sections/home.js');
    
    }

    public function getTemplateFile() { return $this->modxminify->getOption('templatesPath').'home.tpl'; }
}