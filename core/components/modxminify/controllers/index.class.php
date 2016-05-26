<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';
/**
 * Loads the home page.
 *
 * @package modxminify
 * @subpackage controllers
 */
class modxMinifyIndexManagerController extends modxMinifyBaseManagerController {
    public function process(array $scriptProperties = array()) {

        $placeholders = array(
            'pagetitle' => $this->modx->lexicon('modxminify'),
            'description' => $this->modx->lexicon('modxminify.menu.modxminify_desc')
        );
        $this->setPlaceholders(array_merge($placeholders, $this->modxminify->options));

    }
    public function getPageTitle() { 
        return $this->modx->lexicon('modxminify');
    }
    public function loadCustomCssJs() {
        $this->addHtml('<script type="text/javascript">
            var mm_connector_url = "'.$this->modxminify->options['connectorUrl'].'";
            var http_modauth = "'.$this->modx->user->getUserToken($this->modx->context->get('key')).'";
        </script>');
        $this->addJavascript('https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js');
        $this->addJavascript($this->modxminify->getOption('jsUrl').'mgr/sections/index.js');
    }

    public function getTemplateFile() { 
        return $this->modxminify->getOption('templatesPath').'index.tpl'; 
    }
}