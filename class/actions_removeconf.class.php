<?php
/* Copyright (C) 2018-2023 ksar 				<ksar.ksar@gmail.com>
 * Copyright (C) 2020-2020 akene 				<allo@iouston.com>
 * Copyright (C) 2021-2021 Erik van Berkum 		<erikvanberkum@gmail.com>
 * Copyright (C) 2023 	   Regis Houssin        <regis.houssin@inodbox.com>
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
															ask_deleteline confirm_deleteline DeleteProductLine $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid']
															validate	confirm_validate	WARNING, a lot of things to check and could have error, not possible to cancel
	commande\card.php 			ordercard, globalcard										CustomerOrder
															delete		confirm_delete		DeleteOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															validate	confirm_validate	ValidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															modif		confirm_modif		UnvalidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															shipped		confirm_shipped		CloseOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															cancel		confirm_cancel		Cancel				$_SERVER["PHP_SELF"] . '?id=' . $object->id
															ask_deleteline confirm_deleteline DeleteProductLine	$_SERVER["PHP_SELF"].'?id='.$object->id.'&lineid='.$parameters['lineid']
															clone		confirm_clone		WARNING, Need to select third party
	compta\facture\card.php		invoicecard, globalcard										InvoiceCustomer
															delete		confirm_delete		DeleteOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															validate	confirm_validate	ValidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															modif		confirm_modif		UnvalidateOrder		$_SERVER["PHP_SELF"] . '?id=' . $object->id
															shipped		confirm_shipped		CloseOrder			$_SERVER["PHP_SELF"] . '?id=' . $object->id
															cancel		confirm_cancel		Cancel				$_SERVER["PHP_SELF"] . '?id=' . $object->id
															ask_deleteline confirm_deleteline DeleteProductLine $_SERVER["PHP_SELF"].'?id='.$object->id.'&lineid='.$parameters['lineid']
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
															ask_deleteline	confirm_deleteline DeleteProductLine	$_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid']
															validate	confirm_validate	WARNING, a lot of things to check and could have error, not possible to cancel
	website\websiteaccount_card.php 	websiteaccountcard									WebsiteAccount
															delete		confirm_delete		DeleteWebsiteAccount $_SERVER["PHP_SELF"] . '?id=' . $object->id
 	bom\bom_card.php			bom							delete		confirm_delete		DeleteBom			$_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            clone       confirm_clone       CloneBom            $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            validate    confirm_validate    ValidateBom         $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            setdraft    confirm_setdraft    DraftBom            $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            close       confirm_close       CloseBom            $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            reopen      confirm_reopen      ReopenBom           $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            deleteline  confirm_deleteline  DeleteBomLine       $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid']
    mrp\mo_card.php             mo                          delete      confirm_delete      DeleteMO            $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            clone       confirm_clone       CloneMO             $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&socid=' . $parameters['socid']
                                                            validate    confirm_validate    ValidateMO          $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            setdraft    confirm_setdraft    DraftMO             $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            reopen      confirm_reopen      ReopenMO            $_SERVER["PHP_SELF"] . '?id=' . $object->id
                                                            deleteline  confirm_deleteline  DeleteMOine         $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid']
	fourn\commande\card			ordersuppliercard, globalcard
															delete		confirm_delete		DeleteOrder			$_SERVER["PHP_SELF"].'?id='.$object->id
															clone		confirm_clone		WARNING, need to select a third party, not possible to cancel
															valid		confirm_valid		ValidateOrder		$_SERVER["PHP_SELF"].'?id='.$object->id
															approve		confirm_approve		ApproveThisOrder	$_SERVER['PHP_SELF']."?id=".$object->id WARNING, if stock enabled, warehouse to be selected,  not possible to cancel
															approve2	confirm_approve2	ApproveThisOrder	$_SERVER['PHP_SELF']."?id=".$object->id WARNING, if stock enabled, warehouse to be selected,  not possible to cancel
															refuse		confirm_refuse		DenyingThisOrder	$_SERVER['PHP_SELF']."?id=$object->id" 	WARNING, need to indicate the Reason, Reason will be blank
															cancel		confirm_cancel		Cancel	$_SERVER['PHP_SELF']."?id=$object->id"	WARNING, need to indicate the Reason, Reason will be blank
															commande	confirm_commande	WARNING, a lot of things to send by POST, not possible to cancel
															ask_deleteline	confirm_deleteline	DeleteProductLine $_SERVER["PHP_SELF"].'?id='.$object->id.'&lineid='.$lineid


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

	   dol_syslog(get_class($this).'::executeHooks action='.$action);

		//Propal
		if (strpos($parameters['context'], 'propalcard') !== false){

			dol_syslog(get_class($this).'::Context = Propalcard', LOG_DEBUG, 1 , '', '');

			//Delete
			if (($action == 'delete') && ($user->rights->removeconf->propal_delete)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_delete';
				dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}

			//Reopen
			if (($action == 'reopen') && ($user->rights->removeconf->reopen_propale)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_reopen';
				dol_syslog(get_class($this).'::action = reopen', LOG_DEBUG, 1 , '', '');
			}

			//ask_deleteline
			if (($action == 'ask_deleteline') && ($user->rights->removeconf->delete_propale_line)){
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
			if (($action == 'delete') && ($user->rights->removeconf->delete_order)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_delete';
				dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}

			//Validate
			if (($action == 'validate') && ($user->rights->removeconf->validate_order)){
				$qualified_for_stock_change=0;
				if (empty($conf->global->STOCK_SUPPORTS_SERVICES))					{
					$qualified_for_stock_change=$object->hasProductsOrServices(2);
				}else{
					$qualified_for_stock_change=$object->hasProductsOrServices(1);
				}

				if (isModEnabled('stock') && !empty($conf->global->STOCK_CALCULATE_ON_VALIDATE_ORDER) && $qualified_for_stock_change)
				{
					require_once DOL_DOCUMENT_ROOT . '/product/stock/class/entrepot.class.php';
					$warehouse = new Entrepot($this->db);
					$warehouse_array = $warehouse->list_array();
					if (count($warehouse_array) == 1) {
						$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&idwarehouse=' . key($warehouse_array);
						$this->results = true;
						$action_confirm = 'confirm_validate';
						dol_syslog(get_class($this).'::action = validate', LOG_DEBUG, 1 , '', '');
					}
				}else{
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id ;
					$this->results = true;
					$action_confirm = 'confirm_validate';
					dol_syslog(get_class($this).'::action = validate', LOG_DEBUG, 1 , '', '');
				}
			}

			//Modif
			if (($action == 'modif') && ($user->rights->removeconf->update_order)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_modif';
				dol_syslog(get_class($this).'::action = modif', LOG_DEBUG, 1 , '', '');
			}

			//Shipped
			if (($action == 'shipped') && ($user->rights->removeconf->shipping_order)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_shipped';
				dol_syslog(get_class($this).'::action = shipped', LOG_DEBUG, 1 , '', '');
			}

			//Cancel
			if (($action == 'cancel') && ($user->rights->removeconf->cancel_order)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_cancel';
				dol_syslog(get_class($this).'::action = cancel', LOG_DEBUG, 1 , '', '');
			}

			//ask_deleteline
			if (($action == 'ask_deleteline') && ($user->rights->removeconf->delete_order_line)){
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
			if (($action == 'delete') && ($user->rights->removeconf->delete_invoice)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_delete';
				dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}

			//Valid
			if (($action == 'valid') && ($user->rights->removeconf->validate_invoice)){
				$qualified_for_stock_change = 0;
				if (empty($conf->global->STOCK_SUPPORTS_SERVICES)){
					$qualified_for_stock_change = $object->hasProductsOrServices(2);
				}else{
					$qualified_for_stock_change = $object->hasProductsOrServices(1);
				}

				if (isModEnabled('stock') && !empty($conf->global->STOCK_CALCULATE_ON_BILL) && $qualified_for_stock_change){
					require_once DOL_DOCUMENT_ROOT . '/product/stock/class/entrepot.class.php';
					$warehouse = new Entrepot($this->db);
					$warehouse_array = $warehouse->list_array();
					if (count($warehouse_array) == 1) {
						$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&idwarehouse=' . key($warehouse_array);
						$this->results = true;
						$action_confirm = 'confirm_valid';
						dol_syslog(get_class($this).'::action = valid', LOG_DEBUG, 1 , '', '');
					}
				}else{
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
					$this->results = true;
					$action_confirm = 'confirm_valid';
					dol_syslog(get_class($this).'::action = valid', LOG_DEBUG, 1 , '', '');
				}
			}

			//Modif
			if (($action == 'modif') && ($user->rights->removeconf->update_invoice)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_modif';
				dol_syslog(get_class($this).'::action = modif', LOG_DEBUG, 1 , '', '');
			}

			//Shipped
			if (($action == 'shipped') && ($user->rights->removeconf->shipping_invoice)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_shipped';
				dol_syslog(get_class($this).'::action = shipped', LOG_DEBUG, 1 , '', '');
			}

			//Cancel
			if (($action == 'cancel') && ($user->rights->removeconf->cancel_invoice)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_cancel';
				dol_syslog(get_class($this).'::action = cancel', LOG_DEBUG, 1 , '', '');
			}

			//ask_deleteline
			if (($action == 'ask_deleteline') && ($user->rights->removeconf->delete_invoice_line)){
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
			if (($action == 'delete') && ($user->rights->removeconf->delete_shipping)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_delete';
				dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}

			//Valid
			if (($action == 'valid') && ($user->rights->removeconf->validate_shipping)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_valid';
				dol_syslog(get_class($this).'::action = valid', LOG_DEBUG, 1 , '', '');
			}

			//Cancel
			if (($action == 'cancel') && ($user->rights->removeconf->cancel_shipping)){
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
			if (($action == 'delete') && ($user->rights->removeconf->delete_inventory)){
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
			if (($action == 'delete') && ($user->rights->removeconf->delete_warehouse)){
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
			if (($action == 'delete') && ($user->rights->removeconf->delete_propal_supplier)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_delete';
				dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}

			//Reopen
			if (($action == 'reopen') && ($user->rights->removeconf->reopen_propal_supplier)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_reopen';
				dol_syslog(get_class($this).'::action = reopen', LOG_DEBUG, 1 , '', '');
			}

			//ask_deleteline
			if (($action == 'ask_deleteline') && ($user->rights->removeconf->delete_propal_supplier_line)){
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
			if (($action == 'delete') && ($user->rights->removeconf->delete_website)){
				$this->results = true;
				$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
				$action_confirm = 'confirm_delete';
				dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
			}
		}

        // BOM
        if (strpos($parameters['context'], 'bomcard') !== false){
            
			dol_syslog(get_class($this).'::Context = bomcard', LOG_DEBUG, 1 , '', '');

            //Bom Delete
            if (($action == 'delete') && ($user->rights->removeconf->delete_bom)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_delete';
                dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
            }
            // BOM clone
            if (($action == 'clone') && ($user->rights->removeconf->clone_bom)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_clone';
                dol_syslog(get_class($this).'::action = clone', LOG_DEBUG, 1 , '', '');
            }
            // Bom validate
            if (($action == 'validate') && ($user->rights->removeconf->validate_bom)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_validate';
                dol_syslog(get_class($this).'::action = validate', LOG_DEBUG, 1 , '', '');
            }
            // BOM draft
            if (($action == 'setdraft') && ($user->rights->removeconf->draft_bom)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_setdraft';
                dol_syslog(get_class($this).'::action = setdraft', LOG_DEBUG, 1 , '', '');
            }
            // BOM close
            if (($action == 'close') && ($user->rights->removeconf->disable_bom)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_close';
                dol_syslog(get_class($this).'::action = close', LOG_DEBUG, 1 , '', '');
            }
            // BOM reopen
            if (($action == 'reopen' ) && ($user->rights->removeconf->reopen_bom)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_reopen';
                dol_syslog(get_class($this).'::action = confirm_reopen', LOG_DEBUG, 1 , '', '');
            }
            // BOM delete line
            if (($action == 'deleteline') && ($user->rights->removeconf->delete_bom_line)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid'];
                $action_confirm = 'confirm_deleteline';
                dol_syslog(get_class($this).'::action = deleteline', LOG_DEBUG, 1 , '', '');
            }
        }

        // MO
        if (strpos($parameters['context'], 'mocard') !== false){
            
			dol_syslog(get_class($this).'::Context = mocard', LOG_DEBUG, 1 , '', '');

            //MO Delete
            if (($action == 'delete') && ($user->rights->removeconf->delete_mo)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_delete';
                dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
            }
            // MO clone
            if (($action == 'clone') && ($user->rights->removeconf->clone_mo)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&socid=' . $parameters['socid'];
                $action_confirm = 'confirm_clone';
                dol_syslog(get_class($this).'::action = clone', LOG_DEBUG, 1 , '', '');
            }
            // MO validate
            if (($action == 'validate') && ($user->rights->removeconf->validate_mo)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_validate';
                dol_syslog(get_class($this).'::action = validate', LOG_DEBUG, 1 , '', '');
            }
            // MO draft
            if (($action == 'setdraft') && ($user->rights->removeconf->draft_mo)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_setdraft';
                dol_syslog(get_class($this).'::action = setdraft', LOG_DEBUG, 1 , '', '');
            }
            // MO reopen
            if (($action == 'reopen') && ($user->rights->removeconf->reopen_mo)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
                $action_confirm = 'confirm_reopen';
                dol_syslog(get_class($this).'::action = reopen', LOG_DEBUG, 1 , '', '');
            }
            // MO delete line
            if (($action == 'deleteline') && ($user->rights->removeconf->delete_mo_line)){
                $this->results = true;
                $page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid'];
                $action_confirm = 'confirm_deleteline';
                dol_syslog(get_class($this).'::action = deleteline', LOG_DEBUG, 1 , '', '');
            }
        }

        // Purchase order
        if (strpos($parameters['context'], 'ordersuppliercard') !== false){
                
			dol_syslog(get_class($this).'::Context = ordersuppliercard', LOG_DEBUG, 1 , '', '');

        	// Purchase order Delete
        	if (($action == 'delete') && ($user->rights->removeconf->delete_purchase_order)){
        		$this->results = true;
        		$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
        		$action_confirm = 'confirm_delete';
        		dol_syslog(get_class($this).'::action = delete', LOG_DEBUG, 1 , '', '');
        	}
        	// Purchase order validate and approve
        	if (($action == 'valid') && ($user->rights->removeconf->validate_purchase_order)){
        		$this->results = true;
        		$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
        		$action_confirm = 'confirm_valid';
        		dol_syslog(get_class($this).'::action = valid', LOG_DEBUG, 1 , '', '');
        	}
			// Purchase order approve
        	if (($action == 'approve' || $action == 'approve2') && ($user->rights->removeconf->approve_purchase_order)){
				$qualified_for_stock_change = 0;
				if (empty($conf->global->STOCK_SUPPORTS_SERVICES))					{
					$qualified_for_stock_change=$object->hasProductsOrServices(2);
				}else{
					$qualified_for_stock_change=$object->hasProductsOrServices(1);
				}

				if (isModEnabled('stock') && !empty($conf->global->STOCK_CALCULATE_ON_SUPPLIER_VALIDATE_ORDER) && $qualified_for_stock_change)
				{
					require_once DOL_DOCUMENT_ROOT . '/product/stock/class/entrepot.class.php';
					$warehouse = new Entrepot($this->db);
					$warehouse_array = $warehouse->list_array();
					if (count($warehouse_array) == 1) {
						$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&idwarehouse=' . key($warehouse_array);
						$this->results = true;
						$action_confirm = "confirm_".$action;
						dol_syslog(get_class($this).'::action = '.$action, LOG_DEBUG, 1 , '', '');
					}
				}else{
					$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id ;
					$this->results = true;
					$action_confirm = "confirm_".$action;
					dol_syslog(get_class($this).'::action = '.$action, LOG_DEBUG, 1 , '', '');
				}
			}           
        	// Purchase order refuse
        	if (($action == 'refuse') && ($user->rights->removeconf->refuse_purchase_order)){
        		$this->results = true;
        		$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
        		$action_confirm = 'confirm_refuse';
        		dol_syslog(get_class($this).'::action = refuse', LOG_DEBUG, 1 , '', '');
        	}
        	// Purchase order cancel
        	if (($action == 'cancel') && ($user->rights->removeconf->cancel_purchase_order)){
        		$this->results = true;
        		$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id;
        		$action_confirm = 'confirm_cancel';
        		dol_syslog(get_class($this).'::action = cancel', LOG_DEBUG, 1 , '', '');
        	}
        	// Purchase order delete line
        	if (($action == 'ask_deleteline') && ($user->rights->removeconf->delete_purchase_order_line)){
        		$this->results = true;
        		$page = $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&lineid=' . $parameters['lineid'];
        		$action_confirm = 'confirm_deleteline';
        		dol_syslog(get_class($this).'::action = deleteline', LOG_DEBUG, 1 , '', '');
        	}
        }

		if (! $error) {
			if ($this->results == true){
				$pageyes=$page.(preg_match('/\?/',$page)?'&':'?').'action='.$action_confirm.'&confirm=yes&token='.urlencode(newToken());
				$this->resprints = "<script type='text/javascript'>document.location.href='".$pageyes."';</script>";
				dol_syslog(get_class($this).'::page = '.$pageyes, LOG_DEBUG, 1 , '', '');
				return 1;
			}else{
				$this->results = false;
				dol_syslog(get_class($this).'::Nothing to bypass', LOG_DEBUG, 1 , '', '');
				$this->resprints = '';
				return 0;
			}
		} else {
			$this->errors[] = 'Error message';
			dol_syslog(get_class($this).'::Module Error', LOG_DEBUG, 1 , '', '');
			return -1;
		}
	}
}
