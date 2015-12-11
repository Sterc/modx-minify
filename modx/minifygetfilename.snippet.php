<?php
$group = $modx->getOption('group', $scriptProperties, false);
if(!$group) return;

$cacheOptions = array(xPDO::OPT_CACHE_KEY => 'modxminify');
$minCacheFile = $modx->cacheManager->get('modxminify_filename_'.$group, $cacheOptions);
if($minCacheFile) {
    $filename = $minCacheFile;
} else {
    // run the build script (/minify/build.php)
    // TODO: class based build script so we can access build function from here
}
return $filename;