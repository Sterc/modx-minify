<?php
$group = $modx->getOption('group', $scriptProperties, false);
if(!$group) return;

require $modx->getOption('base_path').'/modx-minify/minify.class.php';
$minify = new ModxMinify();
$filename = $minify->minifyFiles($group);

return $filename;

$cacheOptions = array(xPDO::OPT_CACHE_KEY => 'modxminify');
$minCacheFile = $modx->cacheManager->get('modxminify_filename_'.$group, $cacheOptions);
if($minCacheFile && file_exists($minCacheFile)) {
    $filename = $minCacheFile;
} else {
    require $modx->getOption('base_path').'/modx-minify/minify.class.php';
    $minify = new ModxMinify();
    $filename = $minify->minifyFiles($group);
}
return $filename;