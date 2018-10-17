<?php
/* Copyright (C) 2018 ksar <ksar.ksar@gmail.com>
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
 * \file    remove_confirm/class/actions_removeconf.class.php
 * \ingroup removeconf
 * \brief   Example hook overload.
 *
 * Put detailed description here.
 */
 /*
 
 $pageyes=$page.(preg_match('/\?/',$page)?'&':'?').'action='.$action.'&confirm=yes';
 
	PHP FILE 					HOOK CONTEXT				ACTIONS 	CONFIRM				LANG				PAGE
	comm\propal\card.php 		propalcard, globalcard										Proposal
															clone		confirm_clone		WARNING, Need to select third party
															statut							WARNING, Need to select type
															delete		confirm_delete		DeleteProp			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															reopen		confirm_reopen		ReOpen				$_SERVER["PHP_SELF"] . '?id=' . $object->id
															ask_deleteline confirm_deleteline DeleteProductLine $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $lineid
															validate	confirm_validate	WARNING, a lot of things to check and could have error, not possible to cancel
	commande\card.php 			ordercard, globalcard										CustomerOrder
															delete		confirm_delete		DeleteOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															validate	confirm_validate	ValidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															modif		confirm_modif		UnvalidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															shipped		confirm_shipped		CloseOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															cancel		confirm_cancel		Cancel				$_SERVER["PHP_SELF"] . '?id=' . $object->id
															ask_deleteline confirm_deleteline DeleteProductLine	$_SERVER["PHP_SELF"].'?id='.$object->id.'&lineid='.$lineid
															clone		confirm_clone		WARNING, Need to select third party
	compta\facture\card.php		invoicecard, globalcard										InvoiceCustomer
															delete		confirm_delete		DeleteOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															validate	confirm_validate	ValidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															modif		confirm_modif		UnvalidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															shipped		confirm_shipped		CloseOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															cancel		confirm_cancel		Cancel				$_SERVER["PHP_SELF"] . '?id=' . $object->id
															ask_deleteline confirm_deleteline DeleteProductLine $_SERVER["PHP_SELF"].'?id='.$object->id.'&lineid='.$lineid
															clone		confirm_clone		WARNING, Need to select third party
	expedition\card.php			expeditioncard, globalcard									Shipment
															annuler 	confirm_cancel		CancelSending		$_SERVER['PHP_SELF'].'?id='.$object->id
															valid		confirm_valid		ValidateSending		$_SERVER['PHP_SELF'].'?id='.$object->id
															delete		confirm_delete		DeleteSending   	$_SERVER['PHP_SELF'].'?id='.$object->id
	asset\card.php				assetcard													Asset
															delete		confirm_delete		DeleteAssets		$_SERVER["PHP_SELF"] . '?id=' . $object->id, 
	expedition\shipment.php 	WARNING : No definition of hook context						CustomerOrder
															cloture		confirm_cloture		CloseShipment		$_SERVER['PHP_SELF']."?id=".$id
	product\inventory\card.php	inventorycard												Inventory
															delete		confirm_delete		DeleteInventory		$_SERVER["PHP_SELF"] . '?id=' . $object->id
	product\stock\card.php		warehousecard, globalcard									Warehouse
															delete		confirm_delete		DeleteAWarehouse	$_SERVER["PHP_SELF"]."?id=".$object->id
	supplier_proposal\card.php	supplier_proposalcard, globalcard							CommRequest
															clone		confirm_clone		WARNING, a lot of things to send by POST, not possible to cancel	
															delete		confirm_delete		DeleteAsk			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															reopen		confirm_reopen		ReOpen				$_SERVER["PHP_SELF"] . '?id=' . $object->id
															ask_deleteline	confirm_deleteline DeleteProductLine	$_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $lineid
															validate	confirm_validate	WARNING, a lot of things to check and could have error, not possible to cancel
	website\websiteaccount_card.php 	websiteaccountcard									WebsiteAccount
															delete		confirm_delete		DeleteWebsiteAccount $_SERVER["PHP_SELF"] . '?id=' . $object->id

															
															
	LOG_INFO=6, LOG_DEBUG=7
	dol_syslog($message, $level = LOG_INFO, $ident = 0, $suffixinfilename='', $restricttologhandler='')
*/
/**
 * Class Actionsremove_confirm
 */
class Actionsremoveconf
{
    /**
     * @var DoliDB Database handler.
     */
    public $db;
    /**
     * @var string Error
     */
    public $error = '';
    /**
     * @var array Errors
     */
    public $errors = array();


	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;


	/**
	 * Constructor
	 *
	 *  @param		DoliDB		$db      Database handler
	 */
	public function __construct($db)
	{
	    $this->db = $db;
	}

	/**
	 * Overloading the formConfirm function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
	public function formConfirm($parameters, &$object, &$action, $hookmanager)
	{
		global $conf, $user, $langs;

		$error = 0; // Error counter

       // print_r($parameters); print_r($object); echo "action: " . $action; 
	   dol_syslog(get_class($this).'::executeHooks action='.$action);

		
		//Propal
		if (strpos($parameters['context'], 'propalcard') !== false){
			
			dol_syslog(get_class($this).'::Context = Propalcard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
			
			//Reopen
			if ($action == 'reopen'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_reopen';
					dol_syslog(get_class($this).'::action = reopen', LOG_DEBUG, 1 , '', '');
			}
			
			//ask_deleteline
			if ($action == 'ask_deleteline'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid'];
					$action_confirm = 'confirm_deleteline';
					dol_syslog(get_class($this).'::action = ask_deleteline', LOG_DEBUG, 1 , '', '');
			}
		}
		
		//Commande
		if (strpos($parameters['context'], 'ordercard') !== false){
			
			dol_syslog(get_class($this).'::Context = ordercard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
			
			//Validate
			if ($action == 'validate'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_validate';
					dol_syslog(get_class($this).'::action = validate', LOG_DEBUG, 1 , '', '');
			}
			
			//Modif
			if ($action == 'modif'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_modif';
					dol_syslog(get_class($this).'::action = modif', LOG_DEBUG, 1 , '', '');
			}
			
			//Shipped
			if ($action == 'shipped'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_shipped';
					dol_syslog(get_class($this).'::action = shipped', LOG_DEBUG, 1 , '', '');
			}
			
			//Cancel
			if ($action == 'cancel'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_cancel';
					dol_syslog(get_class($this).'::action = cancel', LOG_DEBUG, 1 , '', '');
			}
			
			//ask_deleteline
			if ($action == 'ask_deleteline'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid'];
					$action_confirm = 'confirm_deleteline';
					dol_syslog(get_class($this).'::action = ask_deleteline', LOG_DEBUG, 1 , '', '');
			}
		}
		
		//Invoice
		if (strpos($parameters['context'], 'invoicecard') !== false){
			
			dol_syslog(get_class($this).'::Context = invoicecard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
			
			//Validate
			if ($action == 'validate'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_validate';
					dol_syslog(get_class($this).'::action = validate', LOG_DEBUG, 1 , '', '');
			}
			
			//Modif
			if ($action == 'modif'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_modif';
					dol_syslog(get_class($this).'::action = modif', LOG_DEBUG, 1 , '', '');
			}
			
			//Shipped
			if ($action == 'shipped'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_shipped';
					dol_syslog(get_class($this).'::action = shipped', LOG_DEBUG, 1 , '', '');
			}
			
			//Cancel
			if ($action == 'cancel'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_cancel';
					dol_syslog(get_class($this).'::action = cancel', LOG_DEBUG, 1 , '', '');
			}
			
			//ask_deleteline
			if ($action == 'ask_deleteline'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid'];
					$action_confirm = 'confirm_deleteline';
					dol_syslog(get_class($this).'::action = ask_deleteline', LOG_DEBUG, 1 , '', '');
			}
		}
		
		//Expedition
		if (strpos($parameters['context'], 'expeditioncard') !== false){
			
			dol_syslog(get_class($this).'::Context = expeditioncard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
			
			//Validate
			if ($action == 'validate'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_validate';
					dol_syslog(get_class($this).'::action = validate', LOG_DEBUG, 1 , '', '');
			}
			
			//Cancel
			if ($action == 'cancel'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_cancel';
					dol_syslog(get_class($this).'::action = cancel', LOG_DEBUG, 1 , '', '');
			}
		}
		
		//Inventory
		if (strpos($parameters['context'], 'inventorycard') !== false){
			
			dol_syslog(get_class($this).'::Context = inventorycard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
		}
		
		//Warehouse
		if (strpos($parameters['context'], 'warehousecard') !== false){
			
			dol_syslog(get_class($this).'::Context = warehousecard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
		}
		
		//Supplier_Proposal
		if (strpos($parameters['context'], 'supplier_proposalcard') !== false){
			
			dol_syslog(get_class($this).'::Context = supplier_proposalcard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
			
			//Reopen
			if ($action == 'reopen'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_reopen';
					dol_syslog(get_class($this).'::action = reopen', LOG_DEBUG, 1 , '', '');
			}
			
			//ask_deleteline
			if ($action == 'ask_deleteline'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid'];
					$action_confirm = 'confirm_deleteline';
					dol_syslog(get_class($this).'::action = ask_deleteline', LOG_DEBUG, 1 , '', '');
			}
		}
		
		//WebsiteAccount
		if (strpos($parameters['context'], 'websiteaccountcard') !== false){
			
			dol_syslog(get_class($this).'::Context = websiteaccountcard', LOG_DEBUG, 1 , '', '');
			
			//Delete
			if ($action == 'delete'){
					$this->results = true;
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$action_confirm = 'confirm_delete';
					dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
		}
		
		if (! $error) {
			if ($this->results == true){
				$pageyes=$page.(preg_match('/\?/',$page)?'&':'?').'action='.$action_confirm.'&confirm=yes';
				$this->resprints = "<script type='text/javascript'>/*Bonjour, voici le lien : document.location.href='".$pageyes."';*/</script>";
				dol_syslog(get_class($this).'::page = '.$pageyes, LOG_DEBUG, 1 , '', '');
				return 1; 
			}else{
				$this->results = false;
				//Debug
				$this->resprints = 'ça c\'est bien passé mais rien a afficher';
				dol_syslog(get_class($this).'::Nothing to bypass', LOG_DEBUG, 1 , '', '');
				//Live
				//$this->resprints = '';
				return 0;   
			}
		} else {
			$this->errors[] = 'Error message';
			dol_syslog(get_class($this).'::Module Error', LOG_DEBUG, 1 , '', '');
			return -1;
		}
	}


	/**
	 * Overloading the doActions function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
/*	public function doMassActions($parameters, &$object, &$action, $hookmanager)
	{
	    global $conf, $user, $langs;

	    $error = 0; // Error counter

        /* print_r($parameters); print_r($object); echo "action: " . $action; */
/*	    if (in_array($parameters['currentcontext'], array('somecontext1','somecontext2')))		// do something only for the context 'somecontext1' or 'somecontext2'
	    {
	        foreach($parameters['toselect'] as $objectid)
	        {
	            // Do action on each object id

	        }
	    }

	    if (! $error) {
	        $this->results = array('myreturn' => 999);
	        $this->resprints = 'A text to show';
	        return 0;                                    // or return 1 to replace standard code
	    } else {
	        $this->errors[] = 'Error message';
	        return -1;
	    }
	}


	/**
	 * Overloading the addMoreMassActions function : replacing the parent's function with the one below
	 *
	 * @param   array()         $parameters     Hook metadatas (context, etc...)
	 * @param   CommonObject    $object         The object to process (an invoice if you are in invoice module, a propale in propale's module, etc...)
	 * @param   string          $action         Current action (if set). Generally create or edit or null
	 * @param   HookManager     $hookmanager    Hook manager propagated to allow calling another hook
	 * @return  int                             < 0 on error, 0 on success, 1 to replace standard code
	 */
/*	public function addMoreMassActions($parameters, &$object, &$action, $hookmanager)
	{
	    global $conf, $user, $langs;

	    $error = 0; // Error counter

        /* print_r($parameters); print_r($object); echo "action: " . $action; */
/*	    if (in_array($parameters['currentcontext'], array('somecontext1','somecontext2')))		// do something only for the context 'somecontext1' or 'somecontext2'
	    {
	        $this->resprints = '<option value="0"'.($disabled?' disabled="disabled"':'').'>'.$langs->trans("remove_confirmMassAction").'</option>';
	    }

	    if (! $error) {
	        return 0;                                    // or return 1 to replace standard code
	    } else {
	        $this->errors[] = 'Error message';
	        return -1;
	    }
	}



	/**
	 * Execute action
	 *
	 * @param	array	$parameters		Array of parameters
	 * @param   Object	$object		   	Object output on PDF
	 * @param   string	$action     	'add', 'update', 'view'
	 * @return  int 		        	<0 if KO,
	 *                          		=0 if OK but we want to process standard actions too,
	 *  	                            >0 if OK and we want to replace standard actions.
	 */
/*	function beforePDFCreation($parameters, &$object, &$action)
	{
		global $langs,$conf;
		global $hookmanager;

		$outputlangs=$langs;

		$ret=0; $deltemp=array();
		dol_syslog(get_class($this).'::executeHooks action='.$action);

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
/*		if (in_array($parameters['currentcontext'], array('somecontext1','somecontext2')))		// do something only for the context 'somecontext1' or 'somecontext2'
		{

		}

		return $ret;
	}

	/**
	 * Execute action
	 *
	 * @param	array	$parameters		Array of parameters
	 * @param   Object	$pdfhandler   	PDF builder handler
	 * @param   string	$action     	'add', 'update', 'view'
	 * @return  int 		        	<0 if KO,
	 *                          		=0 if OK but we want to process standard actions too,
	 *  	                            >0 if OK and we want to replace standard actions.
	 */
/*	function afterPDFCreation($parameters, &$pdfhandler, &$action)
	{
		global $langs,$conf;
		global $hookmanager;

		$outputlangs=$langs;

		$ret=0; $deltemp=array();
		dol_syslog(get_class($this).'::executeHooks action='.$action);

		/* print_r($parameters); print_r($object); echo "action: " . $action; */
/*		if (in_array($parameters['currentcontext'], array('somecontext1','somecontext2')))		// do something only for the context 'somecontext1' or 'somecontext2'
		{

		}

		return $ret;
	}

	/* Add here any other hooked methods... */

}
