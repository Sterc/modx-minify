# Modx Minify

Modx Minify is a MODX CMP to group and minify your CSS, SCSS, LESS and JS files. You can create groups, and each group can contain multiple files of the same type. So for instance you create a group named 'css' where you can add all your css or scss files. After that you put the snippet call [[!modxMinify?&group=`css`]] inside a 'link' tag in your head and a minified css file will be generated which will contain all your files grouped and minified!

## Usage
1. Install the package via Package Management
2. Add groups and files via the cmp
4. In your <head> in your template, place the snippet call, eg: [[!modxMinify?&group=`css`]]
