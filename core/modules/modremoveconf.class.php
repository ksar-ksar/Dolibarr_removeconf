<?php
/* Copyright (C) 2004-2018 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2020 ksar <ksar.ksar@gmail.com>
 * Copyright (C) 2020-2020 akene <allo@iouston.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup   removeconf     Module removeconf
 *  \brief      removeconf module descriptor.
 *
 *  \file       htdocs/custom/removeconf/core/modules/modremoveconf.class.php
 *  \ingroup    removeconf
 *  \brief      Description and activation file for module removeconf
 */
include_once DOL_DOCUMENT_ROOT .'/core/modules/DolibarrModules.class.php';


/**
 *  Description and activation class for module removeconf
 */
class modremoveconf extends DolibarrModules
{
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
        global $langs,$conf;

        $this->db = $db;

		// Id for module (must be unique).
		$this->numero = 207300;		
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'removeconf';

		// Family can be 'crm','financial','hr','projects','products','ecm','technic','interface','other'
		// It is used to group modules by family in module setup page
		$this->family = "technic";
		// Module position in the family on 2 digits ('01', '10', '20', ...)
		$this->module_position = '90';

		// Module label (no space allowed), used if translation string 'ModuleremoveconfName' not found (MyModue is name of module).
		$this->name = preg_replace('/^mod/i','',get_class($this));
		// Module description, used if translation string 'ModuleremoveconfDesc' not found (MyModue is name of module).
		$this->description = "Remove the confirmation pop-up";
		// Used only if file README.md and README-LL.md not found.
		$this->descriptionlong = "Allows admin to remove some confirmation pop-up for all the users.";

		$this->editor_name = 'ksar';
		$this->editor_url = 'https://github.com/ksar-ksar/';

		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated' or a version string like 'x.y.z'
		$this->version = '2.0.2';
		
		// Url to the file with your last numberversion of this module
		$this->url_last_version = 'https://raw.githubusercontent.com/ksar-ksar/Dolibarr_removeconf/master/version.txt';
		
		// Key used in llx_const table to save module status enabled/disabled (where removeconf is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Name of image file used for this module.
		$this->picto='removeconf@removeconf';

		// Defined all module parts (triggers, login, substitutions, menus, css, etc...)
		$this->module_parts = array('hooks' => array('all'));

		// Data directories to create when module is enabled.
		$this->dirs = array();

		// Config pages. Put here list of php page, stored into removeconf/admin directory, to use to setup module.
		$this->config_page_url = array("about.php@removeconf");

		// Dependencies
		$this->hidden = false;			// A condition to hide module
		$this->depends = array();		// List of module class names as string that must be enabled if this module is enabled
		$this->requiredby = array();	// List of module ids to disable if this one is disabled
		$this->conflictwith = array();	// List of module class names as string this module is in conflict with
		$this->langfiles = array("removeconf@removeconf");
		$this->phpmin = array(5,3);					// Minimum version of PHP required by module
		$this->need_dolibarr_version = array(9,0);	// Minimum version of Dolibarr required by module
		$this->warnings_activation = array();                     // Warning to show when we activate module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation_ext = array();                 // Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','ES'='textes'...)

		// Constants
		$this->const = array();


		if (! isset($conf->removeconf) || ! isset($conf->removeconf->enabled))
		{
			$conf->removeconf=new stdClass();
			$conf->removeconf->enabled=0;
		}


		// Array to add new pages in new tabs
        $this->tabs = array();

        // Dictionaries
		$this->dictionaries=array();
 
        // Boxes/Widgets
        $this->boxes = array();


		// Cronjobs (List of cron jobs entries to add when module is enabled)
		$this->cronjobs = array();
		
		// Permissions
		$this->rights = array();		// Permission array used by this module
		$this->rights_class = $this->name;

		$r = 0;
		$this->rights[$r][0] = 2073001;
		$this->rights[$r][1] = 'Supprimer les propales sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'propal_delete';
        $this->rights[$r][5] = '';
		$r++;
		$this->rights[$r][0] = 2073002;
		$this->rights[$r][1] = 'Réouvrir les propales sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'reopen_propale';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 2073003;
		$this->rights[$r][1] = 'Supprimer les lignes de propales sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_propale_line';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 2073004;
		$this->rights[$r][1] = 'Supprimer les commandes sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_order';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 2073005;
		$this->rights[$r][1] = 'Valider les commandes sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'validate_order';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 2073006;
		$this->rights[$r][1] = 'Modifier les commandes sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'update_order';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 2073007;
		$this->rights[$r][1] = 'Expédier les commandes sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'shipping_order';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 2073008;
		$this->rights[$r][1] = 'Annuler les commandes sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'cancel_order';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 2073009;
		$this->rights[$r][1] = 'Supprimer les lignes commandes sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_order_line';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730010;
		$this->rights[$r][1] = 'Supprimer les factures sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_invoice';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730011;
		$this->rights[$r][1] = 'Valider les factures sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'validate_invoice';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730012;
		$this->rights[$r][1] = 'Modifier les factures sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'update_invoice';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730013;
		$this->rights[$r][1] = 'Expédier les factures sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'shipping_invoice';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730014;
		$this->rights[$r][1] = 'Annuler les factures sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'cancel_invoice';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730015;
		$this->rights[$r][1] = 'Supprimer les lignes de facture sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_invoice_line';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730016;
		$this->rights[$r][1] = 'Supprier les expéditions sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_shipping';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730017;
		$this->rights[$r][1] = 'Valider les expéditions sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'validate_shipping';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730018;
		$this->rights[$r][1] = 'Annuler les expéditions sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'cancel_shipping';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730019;
		$this->rights[$r][1] = 'Supprimer les inventaires sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_inventory';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730020;
		$this->rights[$r][1] = 'Supprimer les entreprots sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_warehouse';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730021;
		$this->rights[$r][1] = 'Supprimer les propales fournisseurs sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_propal_supplier';
        $this->rights[$r][5] = '';
        $r++;
		$this->rights[$r][0] = 20730022;
		$this->rights[$r][1] = 'Réouvrir les propales fournisseurs sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'reopen_propal_supplier';
        $this->rights[$r][5] = '';
    	$r++;
		$this->rights[$r][0] = 20730023;
		$this->rights[$r][1] = 'Supprimer une ligne de propale fournisseur sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_propal_supplier_line';
        $this->rights[$r][5] = '';
	    $r++;
		$this->rights[$r][0] = 20730024;
		$this->rights[$r][1] = 'Supprimer le site web sans confirmation';
		$this->rights[$r][2] = 'r';
		$this->rights[$r][3] = 0;
		$this->rights[$r][4] = 'delete_website';
        $this->rights[$r][5] = '';
		
		// Main menu entries
		$this->menu = array();			// List of menus to add
	}

	/**
	 *	Function called when module is enabled.
	 *	The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *	It also creates data directories
	 *
     *	@param      string	$options    Options when enabling module ('', 'noboxes')
	 *	@return     int             	1 if OK, 0 if KO
	 */
	public function init($options='')
	{
		$sql = array();

		return $this->_init($sql, $options);
	}

	/**
	 *	Function called when module is disabled.
	 *	Remove from database constants, boxes and permissions from Dolibarr database.
	 *	Data directories are not deleted
	 *
	 *	@param      string	$options    Options when enabling module ('', 'noboxes')
	 *	@return     int             	1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();

		return $this->_remove($sql, $options);
	}

}
