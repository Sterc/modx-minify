# Modx Minify

Modx Minify is a MODX CMP to group and minify your CSS, SCSS, LESS and JS files. You can create groups, and each group can contain multiple files of the same type. So for instance you create a group named 'css' where you can add all your css, scss and less files. After that you place the snippet call ``[[!modxMinify?&group=`css`]]`` inside a `<link>` tag in your head and a minified css file will be generated which will contain all your files grouped and minified!

## Usage
* Install the package via Package Management
* Add groups and files via the cmp
* Inside your <head> in your template, place the snippet call, eg: ``<link rel="stylesheet" type="text/css" href="[[!modxMinify?&group=`css`]]" />``

The modxMinify snippet generates one minified file from all the files added to your specified group. The snippet automatically detects changes in your files, and also checks for changes made in the CMP (adding, updating, removing or reordering of files).
