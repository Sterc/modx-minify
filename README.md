# Modx Minify

## Usage
1. Clone the project (or download zip and unpack) to your website root folder.
2. Edit the config.json file and add your css, scss or js files inside the 'groups' key.
3. In MODX, create a snippet, make it static, and point the static filename to /modx/minifygetfilename.snippet.php
4. In your <head> in your template, place the snippet call, eg: [[!minifyGetFilename?&groups=`css`]]
