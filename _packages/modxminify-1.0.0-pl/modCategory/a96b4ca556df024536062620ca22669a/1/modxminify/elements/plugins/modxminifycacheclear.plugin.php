<?php
switch ($modx->event->name) {

	case 'OnSiteRefresh':
		$modxminify = $modx->getService('modxminify','modxMinify',$modx->getOption('modxminify.core_path',null,$modx->getOption('core_path').'components/modxminify/').'model/modxminify/',$scriptProperties);
		if (!($modxminify instanceof modxMinify)) return '';
		$modxminify->emptyMinifyCacheAll();
		break;

}