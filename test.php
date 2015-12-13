<?php
require 'minify.class.php';

$minify = new ModxMinify();
$minify->minifyFiles();

echo $minify->showLog();