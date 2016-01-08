<?php
/**
 * The base modxMinify snippet.
 *
 * @package modxminify
 */

$modxminify = $modx->getService('modxminify','modxMinify',$modx->getOption('modxminify.core_path',null,$modx->getOption('core_path').'components/modxminify/').'model/modxminify/',$scriptProperties);
if (!($modxminify instanceof modxMinify)) return '';

$group = $modx->getOption('group', $scriptProperties, false);

$output = $modxminify->minifyFiles($group);

return $output;