<?php
/**
 * Resolve creating db tables
 *
 * THIS RESOLVER IS AUTOMATICALLY GENERATED, NO CHANGES WILL APPLY
 *
 * @package modxminify
 * @subpackage build
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('modxminify.core_path', null, $modx->getOption('core_path') . 'components/modxminify/') . 'model/';
            $modx->addPackage('modxminify', $modelPath, $modx->getOption('table_prefix'));

            $manager = $modx->getManager();

            $manager->createObjectContainer('modxMinifyGroup');
            $manager->createObjectContainer('modxMinifyFile');

            break;
    }
}

return true;