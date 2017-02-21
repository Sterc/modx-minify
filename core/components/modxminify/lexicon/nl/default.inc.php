<?php
$_lang['modxminify'] = 'MODX Minify';

$_lang['modxminify.menu.modxminify'] = 'MODX Minify';
$_lang['modxminify.menu.modxminify_desc'] = 'Minify je CSS, SCSS, LESS en JS bestanden.';

$_lang['modxminify.global.create'] = 'Maak';
$_lang['modxminify.global.add'] = 'Toevoegen';
$_lang['modxminify.global.update'] = 'Update';
$_lang['modxminify.global.edit'] = 'Aanpassen';
$_lang['modxminify.global.remove'] = 'Verwijderen';
$_lang['modxminify.global.remove_confirm'] = 'Verwijder';
$_lang['modxminify.global.search'] = 'Zoek';
$_lang['modxminify.global.save'] = 'Opslaan';
$_lang['modxminify.global.cancel'] = 'Annuleren';

$_lang['modxminify.group'] = 'Groep';
$_lang['modxminify.group.groups'] = 'Groepen';
$_lang['modxminify.group.intro_msg'] = 'Beheer hier je groepen. Elke groep kan verschillende bestanden van hetzelfde type bevatten (te beheren via de bestanden tab). Je kan bijvoorbeeld al je CSS en SCSS in een \'CSS\' groep plaatsen, welke vervolgens wordt geminified tot een CSS bestand.';
$_lang['modxminify.group.name'] = 'Groepsnaam';
$_lang['modxminify.group.description'] = 'Beschrijving';

$_lang['modxminify.file'] = 'Bestand';
$_lang['modxminify.file.files'] = 'Bestanden';
$_lang['modxminify.file.intro_msg'] = 'Hier kun je je CSS, SCSS, LESS en JS bestanden beheren. Wanneer je op de \'Toevoegen Bestand\' klikt, verschijnt er een venster waarin je een groep kunt selecteren en het pad van een bestand kunt specificeren. Wanneer je een nieuw bestand toevoegt, kun je meerdere bestanden in een keer toevoegen door elk bestandspad op een nieuwe regel van het tekstvak te beginnen. Alle bestanden zullen dan als aparte bestanden worden toegevoegd aan de tabel. Je kunt de volgorde van de bestanden herschikken door middel van drag and drop.';
$_lang['modxminify.file.description'] = 'Selecteer eerst een groep om de bestanden aan toe te voegen. Specificeer vervolgens de bestandspaden. Het bestandspad is verbonden met je MODX base_path.';
$_lang['modxminify.file.name'] = 'Bestandsnaam';
$_lang['modxminify.file.name.description'] = 'Vul het volledige bestandspad in (verbonden met je base_path). Je kunt meerdere bestanden in een keer toevoegen door elk bestandspad op een nieuwe regel te beginnen.';
$_lang['modxminify.file.position'] = 'Positie';
$_lang['modxminify.file.nogroups'] = 'Er zijn nog geen groepen toegevoegd. Voeg eerst een groep toe door te klikken op de \'Toevoegen Groep\' knop voordat je een bestand kunt toevoegen.';
$_lang['modxminify.file.noresults'] = 'Deze groep is momenteel leeg.';
$_lang['modxminify.file.remove.notice'] = 'Alleen de bestandsreferentie in deze groep wordt verwijderd. Het daadwerkelijke bestand wordt niet aangepast.';

$_lang['modxminify.err.group_name_ae'] = 'Die groepsnaam bestaat al!';
$_lang['modxminify.err.group_nf'] = 'Groep niet gevonden.';
$_lang['modxminify.err.group_name_ns'] = 'Groepsnaam is niet gespecificeerd!';
$_lang['modxminify.err.group_remove'] = 'Er deed zich een fout voor tijdens het verwijderen van deze groep.';
$_lang['modxminify.err.group_save'] = 'Er deed zich een fout voor tijdens het opslaan van deze groep.';

$_lang['modxminify.err.file_name_ae'] = 'Een of meerdere bestanden die je probeert toe te voegen bestaan reeds in deze groep! Bekijk a.u.b. je bestandsnamen.';
$_lang['modxminify.err.file_name_ns'] = 'Bestandsnaam is niet gespecificeerd! Vul a.u.b. ten minste een bestandsnaam in.';
$_lang['modxminify.err.file_name_notexist'] = 'Een of meerdere bestanden die je probeert toe te voegen, kunnen niet worden gevonden in de gespecifceerde bestandspaden.';
$_lang['modxminify.err.file_name_ae_single'] = 'Het bestand dat je probeert toe te voegen bestaat reeds in deze groep! Bekijk a.u.b. je bestandsnaam.';
$_lang['modxminify.err.file_name_notexist_single'] = 'Dat bestand kan niet worden gevonden in het gespecificeerde pad!';

/* System settings */
$_lang['setting_clientlexicon.namespaces'] = 'Naamruimten';
$_lang['setting_clientlexicon.namespaces_desc'] = 'Komma gescheiden lijst van naamruimten om te gebruiken in de clientlexicon.
Wanneer je deze leeg laat, worden alle naamruimten getoond.';
$_lang['setting_clientlexicon.user_name'] = 'Je naam';
$_lang['setting_clientlexicon.user_name_desc'] = 'Wordt gebruikt voor de Sterc Extra\'s nieuwsbrief inschrijving. (optioneel)';
$_lang['setting_clientlexicon.user_email'] = 'Je e-mail adres';
$_lang['setting_clientlexicon.user_email_desc'] = 'Wordt gebruikt voor de Sterc Extra\'s nieuwsbrief inschrijving. (optioneel)';
