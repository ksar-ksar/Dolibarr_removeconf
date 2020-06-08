<?php
/* Copyright (C) 2004-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2020 ksar <ksar.ksar@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    removeconf/admin/about.php
 * \ingroup removeconf
 * \brief   About page of module removeconf.
 */

// Load Dolibarr environment
$res=0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include($_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php");
// Try main.inc.php into web root detected using web root caluclated from SCRIPT_FILENAME
$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include(substr($tmp, 0, ($i+1))."/main.inc.php");
if (! $res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php")) $res=@include(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php");
// Try main.inc.php using relative path
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php");
if (! $res && file_exists("../../../main.inc.php")) $res=@include("../../../main.inc.php");
if (! $res) die("Include of main fails");

// Libraries
require_once DOL_DOCUMENT_ROOT.'/core/lib/admin.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';

// Translations
$langs->loadLangs(array("errors","admin","removeconf@removeconf"));

// Access control
if (! $user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'alpha');
$backtopage = GETPOST('backtopage', 'alpha');


/*
 * Actions
 */

// None


/*
 * View
 */

$form = new Form($db);

$page_name = "removeconfAbout";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="'.(DOL_URL_ROOT.'/admin/modules.php?restore_lastsearch_values=1').'">'.$langs->trans("BackToModuleList").'</a>';

print load_fiche_titre($langs->trans($page_name), $linkback, 'object_removeconf@removeconf');

// Configuration header
$h = 0;
$head = array();
$head[$h][0] = dol_buildpath("/removeconf/admin/about.php", 1);
$head[$h][1] = $langs->trans("About");
$head[$h][2] = 'about';
$h++;
dol_fiche_head($head, 'about', '', 0, 'removeconf@removeconf');

print '<br/>';
print '<div style="float: left; margin-right: 20px;"><img src="../img/removeconf.png" /></div>';
print '<div>';
print '<br/><br/>';
print $langs->trans("removeconfAboutPage");
print '<br/><br/>'.$langs->trans('ForAnyQuestions').' <a href="mailto:ksar.ksar@gmail.com">ksar.ksar@gmail.com</a>';
print '<br/><br/><strong>Git : </stong><a href="https://github.com/ksar-ksar/Dolibarr_removeconf">https://github.com/ksar-ksar/Dolibarr_removeconf</a>';
print '<br/><br/>';
print '<br/><br/>';
print '<br/><br/>';
print '<br/><br/>';
print '<br/><br/>';
print '<br/><br/>';
print '<br/><br/>';
print '</div>';
print '<br/><br/>';

// Page end
dol_fiche_end();
llxFooter();
$db->close();
