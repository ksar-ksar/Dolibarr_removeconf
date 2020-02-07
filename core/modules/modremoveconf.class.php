<?php
/* Copyright (C) 2004-2018 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2020 ksar <ksar.ksar@gmail.com>
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
		$this->numero = 500045;		
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'removeconf';

		// Family can be 'crm','financial','hr','projects','products','ecm','technic','interface','other'
		// It is used to group modules by family in module setup page
		$this->family = "other";
		// Module position in the family on 2 digits ('01', '10', '20', ...)
		$this->module_position = '90';

		// Module label (no space allowed), used if translation string 'ModuleremoveconfName' not found (MyModue is name of module).
		$this->name = preg_replace('/^mod/i','',get_class($this));
		// Module description, used if translation string 'ModuleremoveconfDesc' not found (MyModue is name of module).
		$this->description = "Remove the confirmation pop-up";
		// Used only if file README.md and README-LL.md not found.
		$this->descriptionlong = "Allows admin to remove some confirmation pop-up for all the users.";

		$this->editor_name = 'ksar';
		$this->editor_url = '';

		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated' or a version string like 'x.y.z'
		$this->version = '1.0.2';
		// Key used in llx_const table to save module status enabled/disabled (where removeconf is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		// Name of image file used for this module.
		$this->picto='removeconf@removeconf';

		// Defined all module parts (triggers, login, substitutions, menus, css, etc...)
		$this->module_parts = array('hooks' => array('all'));

		// Data directories to create when module is enabled.
		$this->dirs = array();

		// Config pages. Put here list of php page, stored into removeconf/admin directory, to use to setup module.
		$this->config_page_url = array("setup.php@removeconf");

		// Dependencies
		$this->hidden = false;			// A condition to hide module
		$this->depends = array();		// List of module class names as string that must be enabled if this module is enabled
		$this->requiredby = array();	// List of module ids to disable if this one is disabled
		$this->conflictwith = array();	// List of module class names as string this module is in conflict with
		$this->langfiles = array("removeconf@removeconf");
		$this->phpmin = array(5,3);					// Minimum version of PHP required by module
		$this->need_dolibarr_version = array(9,0);	// Minimum version of Dolibarr required by module
		$this->warnings_activation = array('always'=>'Experimental module, some actions could not be undone if you remove confirmation');                     // Warning to show when we activate module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation_ext = array();                 // Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','ES'='textes'...)

		// Constants
		$this->const = array(
			0=>array('REMOVECONF_P_DELETE','chaine',0,'Remove the confirmation on Propal Delete action',0,'current', 1),
			1=>array('REMOVECONF_P_REOPEN','chaine',0,'Remove the confirmation on Propal Reopen action',0,'current', 1),
			2=>array('REMOVECONF_P_ASK_DELETELINE','chaine',0,'Remove the confirmation on Propal Ask Delete Line action',0,'current', 1),
			3=>array('REMOVECONF_C_DELETE','chaine',0,'Remove the confirmation on Order Delete action',0,'current', 1),
			4=>array('REMOVECONF_C_VALIDATE','chaine',0,'Remove the confirmation on Order Validate action',0,'current', 1),
			5=>array('REMOVECONF_C_MODIF','chaine',0,'Remove the confirmation on Order Modification action',0,'current', 1),
			6=>array('REMOVECONF_C_SHIPPED','chaine',0,'Remove the confirmation on Order Shipped action',0,'current', 1),
			7=>array('REMOVECONF_C_CANCEL','chaine',0,'Remove the confirmation on Order Cancel action',0,'current', 1),
			8=>array('REMOVECONF_C_ASK_DELETELINE','chaine',0,'Remove the confirmation on Order Ask Delete Line action',0,'current', 1),
			9=>array('REMOVECONF_F_DELETE','chaine',0,'Remove the confirmation on Invoice Delete action',0,'current', 1),
			10=>array('REMOVECONF_F_VALID','chaine',0,'Remove the confirmation on Invoice Valid action',0,'current', 1),
			11=>array('REMOVECONF_F_MODIF','chaine',0,'Remove the confirmation on Invoice Modification action',0,'current', 1),
			12=>array('REMOVECONF_F_SHIPPED','chaine',0,'Remove the confirmation on Invoice Shipped action',0,'current', 1),
			13=>array('REMOVECONF_F_CANCEL','chaine',0,'Remove the confirmation on Invoice Cancel action',0,'current', 1),
			14=>array('REMOVECONF_F_ASK_DELETELINE','chaine',0,'Remove the confirmation on Invoice Ask Delete Line action',0,'current', 1),
			15=>array('REMOVECONF_E_DELETE','chaine',0,'Remove the confirmation on Shipment Delete action',0,'current', 1),
			16=>array('REMOVECONF_E_VALID','chaine',0,'Remove the confirmation on Shipment Validate action',0,'current', 1),
			17=>array('REMOVECONF_E_ANNULER','chaine',0,'Remove the confirmation on Shipment Cancel action',0,'current', 1),
			18=>array('REMOVECONF_I_DELETE','chaine',0,'Remove the confirmation on Inventory Delete action',0,'current', 1),
			19=>array('REMOVECONF_S_DELETE','chaine',0,'Remove the confirmation on Warehouse Delete action',0,'current', 1),
			20=>array('REMOVECONF_SP_DELETE','chaine',0,'Remove the confirmation on Supplier proposal Delete action',0,'current', 1),
			21=>array('REMOVECONF_SP_REOPEN','chaine',0,'Remove the confirmation on Supplier proposal Reopen action',0,'current', 1),
			22=>array('REMOVECONF_SP_ASK_DELETELINE','chaine',0,'Remove the confirmation on Propal Ask Delete Line action',0,'current', 1),
			23=>array('REMOVECONF_W_DELETE','chaine',0,'Remove the confirmation on WebsiteAccount Delete action',0,'current', 1)
		);


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
