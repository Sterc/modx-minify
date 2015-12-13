<?php
require 'minify.class.php';
$minify = new ModxMinify();

$minify->minifyFiles();
$minify->showLog();


?>