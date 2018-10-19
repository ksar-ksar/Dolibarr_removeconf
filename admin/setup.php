<?php
/* Copyright (C) 2004-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2018 ksar <ksar.ksar@gmail.com>
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
 * \file    removeconf/admin/setup.php
 * \ingroup removeconf
 * \brief   removeconf setup page.
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

global $langs, $user;

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
//require_once '../lib/removeconf.lib.php';
//require_once "../class/myclass.class.php";

function Print_table_header ($title){
	global $langs ;
	
	echo '<table class="noborder" width="100%">';
	echo '<tr class="liste_titre">';
	echo '<td><strong>'.$langs->trans($title).'</strong></td>';
	echo '<td align="center" width="20">&nbsp;</td>';
	echo '<td align="center" width="100">'.$langs->trans("Value").'</td>'."\n";
	echo '</tr>';
}

function Print_row ($constant_var){
	global $langs, $conf ;
	
	echo '<tr class="oddeven">';
	echo '<td>'.$langs->trans($constant_var).'</td>';
	echo '<td align="center" width="20">&nbsp;</td>';
	echo '<td align="center" width="100">';
	if ($conf->use_javascript_ajax){
		echo ajax_constantonoff($constant_var);
	}else{
		if (empty($conf->global->$constant_var)){
			echo '<a href="'.$_SERVER['PHP_SELF'].'?action=set_'.$constant_var.'">'.img_picto($langs->trans("Disabled"),'off').'</a>';
		}else{
			echo '<a href="'.$_SERVER['PHP_SELF'].'?action=del_'.$constant_var.'">'.img_picto($langs->trans("Enabled"),'on').'</a>';
		}
	}
	echo '</td></tr>';
}

// Translations
$langs->loadLangs(array("admin", "removeconf@removeconf"));

// Access control
if (! $user->admin) accessforbidden();

// Parameters
$action = GETPOST('action', 'alpha');

/*
 * Actions
 */

if (preg_match('/set_([a-z0-9_\-]+)/i',$action,$reg)){
    $code=$reg[1];
    if (dolibarr_set_const($db, $code, 1, 'chaine', 0, '', $conf->entity) > 0){
        header("Location: ".$_SERVER["PHP_SELF"]);
        exit;
    }else{
        dol_echo_error($db);
    }
}elseif (preg_match('/del_([a-z0-9_\-]+)/i',$action,$reg)){
    $code=$reg[1];
    if (dolibarr_del_const($db, $code, $conf->entity) > 0){
        header("Location: ".$_SERVER["PHP_SELF"]);
        exit;
    }else{
        dol_echo_error($db);
    }
}

/*
 * View
 */

$page_name = "removeconfSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="'.(DOL_URL_ROOT.'/admin/modules.php?restore_lastsearch_values=1').'">'.$langs->trans("BackToModuleList").'</a>';

echo load_fiche_titre($langs->trans($page_name), $linkback, 'title_setup');

// Configuration header
$h = 0;
$head = array();
$head[$h][0] = dol_buildpath("/removeconf/admin/setup.php", 1);
$head[$h][1] = $langs->trans("Settings");
$head[$h][2] = 'settings';
$h++;
$head[$h][0] = dol_buildpath("/removeconf/admin/about.php", 1);
$head[$h][1] = $langs->trans("About");
$head[$h][2] = 'about';
$h++;
dol_fiche_head($head, 'settings', '', -1, "removeconf@removeconf");

// Setup page goes here
echo $langs->trans("removeconfSetupPage");
print '<br/><br/>';

// Propal
Print_table_header("Propalmodule");

// Propal Delete
Print_row("REMOVECONF_P_DELETE");

// Propal Re-Open
Print_row("REMOVECONF_P_REOPEN");

// Propal Ask Delete Line
Print_row("REMOVECONF_P_ASK_DELETELINE");

echo '</table>';
echo '<br>';

// Order
Print_table_header("Ordermodule");

// Order Delete
Print_row("REMOVECONF_C_DELETE");

// Order Validate
Print_row("REMOVECONF_C_VALIDATE");

// Order Modification
Print_row("REMOVECONF_C_MODIF");

// Order Shipped
Print_row("REMOVECONF_C_SHIPPED");

// Order Cancel
Print_row("REMOVECONF_C_CANCEL");

// Order Ask Delete Line
Print_row("REMOVECONF_C_ASK_DELETELINE");

echo '</table>';
echo '<br>';

// Invoice
Print_table_header("Invoicemodule");

// Invoice Delete
Print_row("REMOVECONF_F_DELETE");

// Invoice Validate
Print_row("REMOVECONF_F_VALIDATE");

// Invoice Modification
Print_row("REMOVECONF_F_MODIF");

// Invoice Shipped
Print_row("REMOVECONF_F_SHIPPED");

// Invoice Cancel
Print_row("REMOVECONF_F_CANCEL");

// Invoice Ask Delete Line
Print_row("REMOVECONF_F_ASK_DELETELINE");

echo '</table>';
echo '<br>';

// Shipment
Print_table_header("Shipmentmodule");

// Shipment Delete
Print_row("REMOVECONF_E_DELETE");

// Shipment Valid
Print_row("REMOVECONF_E_VALID");

// Shipment Cancel
Print_row("REMOVECONF_E_ANNULER");

echo '</table>';
echo '<br>';

// Inventory
Print_table_header("Inventorymodule");

// Inventory Delete
Print_row("REMOVECONF_I_DELETE");

echo '</table>';
echo '<br>';

// Warehouse
Print_table_header("Warehousemodule");

// Warehouse Delete
Print_row("REMOVECONF_S_DELETE");

echo '</table>';
echo '<br>';

// Supplier Proposal Module
Print_table_header("SpModule");

// Supplier Proposal Module Delete
Print_row("REMOVECONF_SP_DELETE");

// Supplier Proposal Module Re-Open
Print_row("REMOVECONF_SP_REOPEN");

// Supplier Proposal Module Ask delete line
Print_row("REMOVECONF_SP_ASK_DELETELINE");

echo '</table>';
echo '<br>';

// WebsiteAccount Module
Print_table_header("WebModule");

// Supplier WebsiteAccount Delete
Print_row("REMOVECONF_W_DELETE");

echo '</table>';
echo '<br>';


// Page end
dol_fiche_end();

llxFooter();
$db->close();
