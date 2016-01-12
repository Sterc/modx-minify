<?php
/**
 * Default English Lexicon Entries for modxMinify
 *
 * @package modxminify
 * @subpackage lexicon
 */

$_lang['modxminify'] = 'modxMinify';

$_lang['modxminify.menu.modxminify'] = 'MODX Minify';
$_lang['modxminify.menu.modxminify_desc'] = 'Minify your CSS, SCSS, LESS and JS files.';

$_lang['modxminify.global.create'] = 'Create';
$_lang['modxminify.global.add'] = 'Add';
$_lang['modxminify.global.update'] = 'Update';
$_lang['modxminify.global.remove'] = 'Remove';
$_lang['modxminify.global.remove_confirm'] = 'Are you sure you want to remove this';
$_lang['modxminify.global.search'] = 'Search';

$_lang['modxminify.group'] = 'Group';
$_lang['modxminify.group.groups'] = 'Groups';
$_lang['modxminify.group.intro_msg'] = 'Manage your groups here. Each group can contain multiple files of the same type (managed via the Files tab). For example you can put all your css and scss files in a group named \'CSS\', and all files will be minified into one css file.';
$_lang['modxminify.group.name'] = 'Group key';
$_lang['modxminify.group.description'] = 'Description';

$_lang['modxminify.file'] = 'File';
$_lang['modxminify.file.files'] = 'Files';
$_lang['modxminify.file.intro_msg'] = 'Here you can manage your CSS, SCSS, LESS and JS files. Clicking the \'Add file\' button shows a window where you select a group and specifiy the filename path. When adding a new file you can add multiple files at once by separating each file on a newline in the textarea. All files will then be added as a separate file in the grid. You can rearrange the order of the files with drag and drop.';
$_lang['modxminify.file.description'] = 'First select the group to add the files to. Then specify the filename path(s). Filename path is relative to your modx base_path.';
$_lang['modxminify.file.name'] = 'Filename';
$_lang['modxminify.file.name.description'] = 'Enter the full path of your file (relative to your base_path). For multiple files place every file on a new line.';
$_lang['modxminify.file.position'] = 'Position';
$_lang['modxminify.file.nogroups'] = 'No groups added yet. Please add a group via the \'groups\' tab before adding files.';

$_lang['modxminify.err.group_name_ae'] = 'A group already exists with that key.';
$_lang['modxminify.err.group_nf'] = 'Group not found.';
$_lang['modxminify.err.group_name_ns'] = 'Key is not specified.';
$_lang['modxminify.err.group_remove'] = 'An error occurred while trying to remove the group.';
$_lang['modxminify.err.group_save'] = 'An error occurred while trying to save the group.';

$_lang['modxminify.err.file_name_ae'] = 'One or more of your files already exists in this group. Please check your filenames.';
$_lang['modxminify.err.file_name_notexist'] = 'One or more of your files cannot be found in the specified path(s).';
$_lang['modxminify.err.file_name_ae_single'] = 'That file already exists in this group. Please check your filename.';
$_lang['modxminify.err.file_name_notexist_single'] = 'That file cannot be found in the specified path.';
