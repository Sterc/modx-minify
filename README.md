# ModxMinify

ModxMinify is a MODX extra for compiling SCSS and LESS files, grouping and minifying CSS and JS assets.

Create named groups of files, then use the `modxMinify` snippet to output a single minified file per group.

## Usage

1. Install the package via Package Management
2. Add groups and files via the CMP
3. Place the snippet in your template's `<head>`:

```html
<link rel="stylesheet" type="text/css" href="[[!modxMinify? &group=`css`]]" />
<script src="[[!modxMinify? &group=`js`]]"></script>
```

The `modxMinify` snippet generates one minified file from all files in the specified group. It automatically detects changes in your files and any modifications made in the CMP (adding, updating, removing, or reordering files).

## Combining groups

You can combine multiple groups into one minified file by passing a comma-separated list of group names to `modxMinify`:

```
[[!modxMinify? &group=`vendor_css,theme_css`]]
```

In the above example all files from the `vendor_css` and `theme_css` groups are combined into one minified CSS file.

## System Settings

All settings use the `modxminify.` namespace and can be configured in the MODX manager under System Settings.

| Setting      | Key                     | Default                  | Description                                            |
| ------------ | ----------------------- | ------------------------ | ------------------------------------------------------ |
| `cache_path` | `modxminify.cache_path` | `{assets_path}cache`     | Path to the directory where minified files are stored. |
| `cache_url`  | `modxminify.cache_url`  | `{assets_url}cache`      | URL to the cache directory for serving minified files. |

## Dependencies

ModxMinify uses [Assetic](https://github.com/kriswallsmith/assetic) as its asset pipeline, with the following libraries handling compilation and minification:

| Library                                                          | Purpose           |
| ---------------------------------------------------------------- | ----------------- |
| [scssphp/scssphp](https://github.com/scssphp/scssphp)            | SCSS compilation  |
| [oyejorge/less.php](https://github.com/oyejorge/less.php)        | LESS compilation  |
| [cssmin/cssmin](https://code.google.com/archive/p/cssmin/)       | CSS minification  |
| [mrclay/minify](https://github.com/mrclay/minify)                | JS minification (pinned to ~2.2, see Known Limitations) |
| [patchwork/jsqueeze](https://github.com/nicolas-grekas/JSqueeze) | JS compression    |

## Known limitations

### mrclay/minify is pinned to ~2.2

The JS minification relies on `\JSMin::minify()` from `mrclay/minify`. This class (`min/lib/JSMin.php`) was removed in version 3.0.0 of that package, so upgrading to `~3.0` or `~4.0` will break JS minification with a "class not found" error.

Do not upgrade `mrclay/minify` in `core/components/modxminify/assetic/composer.json` without replacing the `JSMinFilter` with an alternative. The upstream package authors themselves recommend against using it for new projects — it does not handle modern JavaScript syntax well.

# Free Extra
This is a free extra and the code is publicly available for you to change. The extra is being actively maintained and you're free to put in pull requests which match our roadmap. Please create an issue if the pull request differs from the roadmap so we can make sure we're on the same page.

Need help? [Approach our support desk for paid premium support.](mailto:service@sterc.com)

## License

GPL v2 — see [LICENSE.md](LICENSE.md).
