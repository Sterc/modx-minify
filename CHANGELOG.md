Changelog for modxMinify.

ModxMinify 1.0.5 (2026-05-28)
=============================
- Migrate to new GPM build format (gpm.yml)
- Move CHANGELOG.md to repository root
- Upgrade scssphp to scssphp/scssphp v2.1.0 (requires PHP >= 8.1)
- Fix PHP warning: undefined variable $skip when no cached file exists yet
- Fix group selector in CMP showing only 20 groups (removed default limit)
- Fix CMP intro message showing menu description instead of full intro text
- Add README note for MODX installations in a subdirectory (cache path config)
- Fix fatal error on SCSS syntax errors; log file/line to MODX error log instead of crashing the site

ModxMinify 1.0.4 (2026-05-28)
=============================
- Downgrade scssphp back to leafo/scssphp v0.x for broad PHP compatibility
- Add gpm.yml for new GPM build format

ModxMinify 1.0.3 (2025-02-05)
=============================
- Upgrade ScssPhp by composer

ModxMinify 1.0.2 (2022-11-14)
=============================
- PHP 8 compatibility

ModxMinify 1.0.1 (2018-05-03)
=============================
- Add missing less.php library
- Fix bug with hardcoded 'modx_' prefix in build (#9 and #25)
- Add cache_path and cache_url settings to override path to minified file (PR#27) - Thanks to @digitalpenguin
- Update composer dependencies
- Remove twig from composer dependencies for better compatibility (#32)

ModxMinify 1.0.0 (2017-01-24)
=============================
- PR release

ModxMinify 0.2.0 (2016-05-25)
=============================
- Added ability to combine multiple groups in one modxMinify call.

ModxMinify 0.1.9 (2016-02-11)
=============================
- Added plugin to clear ModxMinify cache files on Modx cache clear.
- Fixed exception bug in Leafo class
- Added (and removed :p) config.json for groups/files

ModxMinify 0.1.7 (2016-01-20)
=============================
- New css uri rewrite filter (for rewriting relative urls in css files)
- New css minify filter
- fix assetwriter paths

ModxMinify 0.1.6 (2016-01-18)
=============================

ModxMinify 0.1.5 (2016-01-15)
=============================
- Updated Assetic library to latest version
- Added support for .less files
- Fix file extension check in minify class

ModxMinify 0.1 (2015-12-18)
=============================
- Initial release.
