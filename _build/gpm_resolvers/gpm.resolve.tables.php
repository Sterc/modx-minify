<?php
/**
 * Resolve creating db tables
 *
 * THIS RESOLVER IS AUTOMATICALLY GENERATED, NO CHANGES WILL APPLY
 *
 * @package modxminify
 * @subpackage build
 *
 * @var mixed $object
 * @var modX $modx
 * @var array $options
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('modxminify.core_path', null, $modx->getOption('core_path') . 'components/modxminify/') . 'model/';
            
            $modx->addPackage('modxminify', $modelPath, null);


            $manager = $modx->getManager();

            $manager->createObjectContainer('modxMinifyGroup');
            $manager->createObjectContainer('modxMinifyFile');

            break;
    }
}

return true;