<?php
/**
 * Default English Lexicon Entries for modxMinify
 *
 * @package modxminify
 * @subpackage lexicon
 */

$_lang['modxminify'] = 'MODX Minify';

$_lang['modxminify.menu.modxminify'] = 'MODX Minify';
$_lang['modxminify.menu.modxminify_desc'] = 'Minify your CSS, SCSS, LESS and JS files.';

$_lang['modxminify.global.create'] = 'Create';
$_lang['modxminify.global.add'] = 'Add';
$_lang['modxminify.global.update'] = 'Update';
$_lang['modxminify.global.edit'] = 'Edit';
$_lang['modxminify.global.remove'] = 'Remove';
$_lang['modxminify.global.remove_confirm'] = 'Are you sure you want to remove this';
$_lang['modxminify.global.search'] = 'Search';
$_lang['modxminify.global.save'] = 'Save';
$_lang['modxminify.global.cancel'] = 'Cancel';

$_lang['modxminify.group'] = 'Group';
$_lang['modxminify.group.groups'] = 'Groups';
$_lang['modxminify.group.intro_msg'] = 'Manage your groups here. Each group can contain multiple files of the same type (managed via the files tab). For example you can put all your CSS and SCSS files in a group named \'CSS\', and all files will be minified into one CSS file.';
$_lang['modxminify.group.name'] = 'Group name';
$_lang['modxminify.group.description'] = 'Description';

$_lang['modxminify.file'] = 'File';
$_lang['modxminify.file.files'] = 'Files';
$_lang['modxminify.file.intro_msg'] = 'Here you can manage your CSS, SCSS, LESS and JS files. Clicking the \'Add File\' button shows a window where you select a group and specifiy the filename path. When adding a new file you can add multiple files at once by separating each file on a new line in the textarea. All files will then be added as a separate file in the grid. You can rearrange the order of the files using drag and drop.';
$_lang['modxminify.file.description'] = 'First select a group to add the files to. Then specify the filename path(s). The filename path is relative to your MODX base_path.';
$_lang['modxminify.file.name'] = 'Filename';
$_lang['modxminify.file.name.description'] = 'Enter the full path of your file (relative to your base_path). To add multiple files, place every filepath on a new line.';
$_lang['modxminify.file.position'] = 'Position';
$_lang['modxminify.file.nogroups'] = 'No groups added yet. Please add a group via the \'Groups\' tab before adding files.';
$_lang['modxminify.file.noresults'] = 'This group is currently empty.';
$_lang['modxminify.file.remove.notice'] = 'Only the file reference in this group will be removed. The actual file will remain safe.';

$_lang['modxminify.err.group_name_ae'] = 'That group name already exists!';
$_lang['modxminify.err.group_nf'] = 'Group not found.';
$_lang['modxminify.err.group_name_ns'] = 'Group name is not specified!';
$_lang['modxminify.err.group_remove'] = 'An error occurred while trying to remove the group.';
$_lang['modxminify.err.group_save'] = 'An error occurred while trying to save the group.';

$_lang['modxminify.err.file_name_ae'] = 'One or more of the files you are trying to add already exist in this group! Please check your filenames.';
$_lang['modxminify.err.file_name_ns'] = 'Filename is not specified! Please enter at least one filename.';
$_lang['modxminify.err.file_name_notexist'] = 'One or more of the files you are trying to add cannot be found in the specified path(s).';
$_lang['modxminify.err.file_name_ae_single'] = 'The file you are trying to add is already added in this group! Please check the filename.';
$_lang['modxminify.err.file_name_notexist_single'] = 'That file cannot be found in the specified path!';

/* System settings */
$_lang['setting_clientlexicon.namespaces'] = 'Namespaces';
$_lang['setting_clientlexicon.namespaces_desc'] = 'Comma separated list of namespaces to use in clientlexicon.
 When left empty, all namespaces are shown.';
$_lang['setting_clientlexicon.user_name'] = 'Your name';
$_lang['setting_clientlexicon.user_name_desc'] = 'Is used for the Sterc Extra\'s newsletter subscription. (optional)';
$_lang['setting_clientlexicon.user_email'] = 'Your email address';
$_lang['setting_clientlexicon.user_email_desc'] = 'Is used for the Sterc Extra\'s newsletter subscription. (optional)';
