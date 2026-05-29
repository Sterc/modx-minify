# Modx Minify

Modx Minify is a MODX CMP to group and minify your CSS, SCSS, LESS and JS files. You can create groups, and each group can contain multiple files of the same type. So for instance you create a group named 'css' where you can add all your css, scss and less files. After that you place the snippet call ``[[!modxMinify?&group=`css`]]`` inside a `<link>` tag in your head and a minified css file will be generated which will contain all your files grouped and minified!

## Usage
* Install the package via Package Management
* Add groups and files via the cmp
* Inside your <head> in your template, place the snippet call, for example: 

``<link rel="stylesheet" type="text/css" href="[[!modxMinify?&group=`css`]]" />``

The modxMinify snippet generates one minified file from all the files added to your specified group. The snippet automatically detects changes in your files, and also checks for changes made in the CMP (adding, updating, removing or reordering of files).

## Combining groups
You can also combine multiple groups into one minified file, by using a comma-separated list of groups in your [[!modxMinify]] snippet call:

``[[!modxMinify?&group=`css,css2`]]``

In the above example all the files from group 'css' and 'css2' get combined into one minified CSS file.

## System Settings

All settings use the `modxminify.` namespace and can be configured in the MODX manager under System Settings.

| Setting      | Key                    | Default                  | Description                                       |
| ------------ | ---------------------- | ------------------------ | ------------------------------------------------- |
| `cache_path` | `modxminify.cache_path` | `{assets_path}cache`    | Path to the directory where minified files are stored. |
| `cache_url`  | `modxminify.cache_url`  | `{assets_url}cache`     | URL to the cache directory for serving minified files. |

## Known limitations

### mrclay/minify is pinned to ~2.2

The JS minification relies on `\JSMin::minify()` from `mrclay/minify`. This class (`min/lib/JSMin.php`) was removed in version 3.0.0 of that package, so upgrading to `~3.0` or `~4.0` will break JS minification with a "class not found" error.

Do not upgrade `mrclay/minify` in `core/components/modxminify/assetic/composer.json` without replacing the `JSMinFilter` with an alternative. The upstream package authors themselves recommend against using it for new projects — it does not handle modern JavaScript syntax well.

# Free Extra
This is a free extra and the code is publicly available for you to change. The extra is being actively maintained and you're free to put in pull requests which match our roadmap. Please create an issue if the pull request differs from the roadmap so we can make sure we're on the same page.

Need help? [Approach our support desk for paid premium support.](mailto:service@sterc.com)
