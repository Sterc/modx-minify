# Modx Minify

Modx Minify is a MODX CMP to group and minify your CSS, SCSS, LESS and JS files. You can create groups, and each group can contain multiple files of the same type. So for instance you create a group named 'css' where you can add all your css, scss and less files. After that you place the snippet call ``[[!modxMinify?&group=`css`]]`` inside a `<link>` tag in your head and a minified css file will be generated which will contain all your files grouped and minified!

## Usage
* Install the package via Package Management
* Add groups and files via the cmp
* Inside your <head> in your template, place the snippet call, for example: 

<link rel="stylesheet" type="text/css" href="[[!modxMinify?&group=`css`]]" />

The modxMinify snippet generates one minified file from all the files added to your specified group. The snippet automatically detects changes in your files, and also checks for changes made in the CMP (adding, updating, removing or reordering of files).

## Combining groups
You can also combine multiple groups into one minified file, by using a comma-separated list of groups in your [[!modxMinify]] snippet call:

``[[!modxMinify?&group=`css,css2`]]``

In the above example all the files from group 'css' and 'css2' get combined into one minified CSS file.

# Free Extra
This is a free extra and the code is publicly available for you to change. The extra is being actively maintained and you're free to put in pull requests which match our roadmap. Please create an issue if the pull request differs from the roadmap so we can make sure we're on the same page.

Need help? [Approach our support desk for paid premium support.](mailto:service@sterc.com)
