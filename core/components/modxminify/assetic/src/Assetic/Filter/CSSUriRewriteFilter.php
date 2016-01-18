<?php

/*
 * This file is part of the Assetic package, an OpenSky project.
 *
 * (c) 2010-2014 OpenSky Project Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Assetic\Filter;

use Assetic\Asset\AssetInterface;

/**
 * URI rewrite from mrclay Minify
 *
 * @link https://github.com/mrclay/minify/blob/master/lib/Minify/CSS/UriRewriter.php
 */
class CSSUriRewriteFilter implements FilterInterface
{
    public function filterLoad(AssetInterface $asset)
    {
    }

    public function filterDump(AssetInterface $asset)
    {
        $sourceBase = $asset->getSourceRoot();
        $sourcePath = $asset->getSourcePath();
        $targetPath = $asset->getTargetPath();

        if (null === $sourcePath || null === $targetPath || $sourcePath == $targetPath) {
            return;
        }

        $content = \Minify_CSS_UriRewriter::rewrite(
            $asset->getContent()
            ,$sourceBase
        ); 

        $asset->setContent($content);
    }
}
