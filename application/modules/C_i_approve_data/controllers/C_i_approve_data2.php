<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_i_approve_data extends CI_Controller
{
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('session_mursmedic_status') != "LOGIN") {
			redirect(site_url("index"));
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function index()
	{
		$this->load->view('V_i_approve_data');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_approve()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('i_approve_data') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));

		$si_date_receive = trim($this->input->post('si_date_receive'));
		$si_supplier_id = trim($this->input->post('si_supplier_id'));
		$si_po_no = trim($this->input->post('si_po_no'));
		$si_packing_list_no = trim($this->input->post('si_packing_list_no'));
		$si_pib_no = trim($this->input->post('si_pib_no'));
		$si_invoice_no = trim($this->input->post('si_invoice_no'));
		$si_forwarder_id = trim($this->input->post('si_forwarder_id'));
		$si_container_no = trim($this->input->post('si_container_no'));
		$si_container_plat_no = trim($this->input->post('si_container_plat_no'));
		$si_seal_no = trim($this->input->post('si_seal_no'));
		//-----------------------------------------------------------------------------------------------//
		$array_si_detail_id = $_POST['si_detail_id'];
		$array_si_product_detail_id = $_POST['si_product_detail_id'];
		$array_si_product_detail_name = $_POST['si_product_detail_name'];
		$array_si_product_no = $_POST['si_product_no'];
		$array_si_product_qty_total = $_POST['si_product_qty_total'];
		$array_si_product_qty_good = $_POST['si_product_qty_good'];
		$array_si_product_qty_bad = $_POST['si_product_qty_bad'];

		$array_si_detail_id_length = count($array_si_detail_id);
		//-----------------------------------------------------------------------------------------------//
		//FILTER ALL SUM PRODUCT & FILTER SUM USE RACK & COMPARE AVAILABLE RACK
		$RACK_USE_FILTER = 0;
		for ($y = 0; $y < $array_si_detail_id_length; $y++) {
			//-----------------------------------------------------------------------------------------------//
			$si_product_qty_total = $array_si_product_qty_total[$y];
			$si_product_qty_good = $array_si_product_qty_good[$y];
			$si_product_qty_bad = $array_si_product_qty_bad[$y];
			//-----------------------------------------------------------------------------------------------//
			$si_sum_good_bad = $si_product_qty_good + $si_product_qty_bad;
			//-----------------------------------------------------------------------------------------------//
			if ($si_product_qty_total != $si_sum_good_bad) {
				echo '
					<script>
						alert("APPROVE FAILED, SUM TOTAL NOT MATCH");
						window.location.href = "' . site_url('i_approve_data') . '";
					</script>
				';
				exit();
			}
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			$si_product_detail_id_filter = $array_si_product_detail_id[$y];
			$get_data_search_product_for_rack_evo_filter = $this->M_library_database->DB_GET_DATA_SEARCH_PRODUCT_FOR_RACK_EVO($si_product_detail_id_filter);
			if (empty($get_data_search_product_for_rack_evo_filter) || $get_data_search_product_for_rack_evo_filter == "") {
				echo '
					<script>
						alert("APPROVE FAILED, PRODUCT NOT FOUND WHEN FILTER");
						window.location.href = "' . site_url('i_approve_data') . '";
					</script>
				';
				exit();
			}
			foreach ($get_data_search_product_for_rack_evo_filter as $data_row_search_product_for_rack_evo_filter) {
				$PT_UNIT_MAX_FILTER = $data_row_search_product_for_rack_evo_filter->PT_UNIT_MAX;
				$PT_UNIT_MAX_EXT_FILTER = $data_row_search_product_for_rack_evo_filter->PT_UNIT_MAX_EXT;
			}
			if ($PT_UNIT_MAX_EXT_FILTER == "0") {
				//BOX / PALLET
				$PRODUCT_TYPE_UNIT_FILTER = "BOX_OR_PALLET";
				$QTY_BOX_OR_PALLET_PRODUCT_FILTER = $si_product_qty_good;
				$QTY_PRODUCT_FILTER = $PT_UNIT_MAX_FILTER - $QTY_BOX_OR_PALLET_PRODUCT_FILTER;
				if ($QTY_PRODUCT_FILTER < 0) {
					$MOD_QTY_FILTER = fmod($QTY_BOX_OR_PALLET_PRODUCT_FILTER, $PT_UNIT_MAX_FILTER);
					if ($MOD_QTY_FILTER == 0) {
						$RACK_USE_COUNT_FILTER = $QTY_BOX_OR_PALLET_PRODUCT_FILTER / $PT_UNIT_MAX_FILTER;
					} else {
						$RACK_USE_COUNT_FILTER = $QTY_BOX_OR_PALLET_PRODUCT_FILTER / $PT_UNIT_MAX_FILTER;
						$ARRAY_RACK_USE_FILTER = explode(".", $RACK_USE_COUNT_FILTER);
						$RACK_USE_COUNT_FILTER = $ARRAY_RACK_USE_FILTER[0] + 1;
					}
				} else {
					$RACK_USE_COUNT_FILTER = 1;
				}
			} else {
				//PCS
				$PRODUCT_TYPE_UNIT_FILTER = "PCS";
				$QTY_PCS_PRODUCT = $PT_UNIT_MAX_EXT_FILTER - $si_product_qty_good;
				if ($QTY_PCS_PRODUCT < 0) {
					$MOD_PCS_PRODUCT = fmod($si_product_qty_good, $PT_UNIT_MAX_EXT_FILTER);
					if ($MOD_PCS_PRODUCT == 0) {
						$QTY_BOX_OR_PALLET_PRODUCT_FILTER = $si_product_qty_good / $PT_UNIT_MAX_EXT_FILTER;
					} else {
						$QTY_BOX_OR_PALLET_PRODUCT_FILTER = $si_product_qty_good / $PT_UNIT_MAX_EXT_FILTER;
						$ARRAY_QTY_BOX_OR_PALLET_PRODUCT = explode(".", $QTY_BOX_OR_PALLET_PRODUCT_FILTER);
						$QTY_BOX_OR_PALLET_PRODUCT_FILTER = $ARRAY_QTY_BOX_OR_PALLET_PRODUCT[0] + 1;
					}
					$QTY_PRODUCT_FILTER = $PT_UNIT_MAX_FILTER - $QTY_BOX_OR_PALLET_PRODUCT_FILTER;
					if ($QTY_PRODUCT_FILTER < 0) {
						$MOD_QTY_FILTER = fmod($QTY_BOX_OR_PALLET_PRODUCT_FILTER, $PT_UNIT_MAX_FILTER);
						if ($MOD_QTY_FILTER == 0) {
							$RACK_USE_COUNT_FILTER = $QTY_BOX_OR_PALLET_PRODUCT_FILTER / $PT_UNIT_MAX_FILTER;
						} else {
							$RACK_USE_COUNT_FILTER = $QTY_BOX_OR_PALLET_PRODUCT_FILTER / $PT_UNIT_MAX_FILTER;
							$ARRAY_RACK_USE_FILTER = explode(".", $RACK_USE_COUNT_FILTER);
							$RACK_USE_COUNT_FILTER = $ARRAY_RACK_USE_FILTER[0] + 1;
						}
					} else {
						$RACK_USE_COUNT_FILTER = 1;
					}
				} else {
					$QTY_BOX_OR_PALLET_PRODUCT_FILTER = 1;
					$RACK_USE_COUNT_FILTER = 1;
				}
			}
			$RACK_USE_FILTER = $RACK_USE_FILTER + $RACK_USE_COUNT_FILTER;
		}
		
		//-----------------------------------------------------------------------------------------------//
		//-----------------------------------------------------------------------------------------------//
		//-----------------------------------------------------------------------------------------------//
		$get_data_all_rack_filter = $this->M_library_database->DB_GET_DATA_ALL_RACK();
		if (empty($get_data_all_rack_filter) || $get_data_all_rack_filter == "") {
			echo '
				<script>
					alert("APPROVE FAILED, RACK NOT FOUND WHEN FILTER");
					window.location.href = "' . site_url('i_approve_data') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$RACK_AVAILABLE_FILTER = 0;
		foreach ($get_data_all_rack_filter as $data_row_all_rack_filter) {
			$RK_ID_FILTER = $data_row_all_rack_filter->RK_ID;
			$RK_TYPE_FILTER = $data_row_all_rack_filter->RK_TYPE;
			$RK_SUBRACK_FILTER = $data_row_all_rack_filter->RK_SUBRACK;
			$RK_LEVEL_FILTER = $data_row_all_rack_filter->RK_LEVEL;
			$SE_ID_FILTER = $data_row_all_rack_filter->SE_ID;
			//-----------------------------------------------------------------------------------------------//
			$PREFIX_RACK_ID_FILTER = substr($RK_ID_FILTER, 0, 3);
			//-----------------------------------------------------------------------------------------------//
			$check_rack_inbound_detail_evo_filter = $this->M_library_database->DB_CHECK_RACK_INBOUND_DETAIL_DRIVE_IN_EVO($PREFIX_RACK_ID_FILTER);
			if (empty($check_rack_inbound_detail_evo_filter) || $check_rack_inbound_detail_evo_filter == "") {
				$RACK_AVAILABLE_FILTER = $RACK_AVAILABLE_FILTER + 1;
			} else {
				$check_rack_outbound_detail_evo_filter = $this->M_library_database->DB_CHECK_RACK_OUTBOUND_DETAIL_DRIVE_IN_EVO($PREFIX_RACK_ID_FILTER);
				if (empty($check_rack_outbound_detail_evo_filter) || $check_rack_outbound_detail_evo_filter == "") {
					$get_data_detail_filter = $this->M_library_database->DB_GET_DATA_SEARCH_DETAIL_RACK_STOCK($RK_ID_FILTER);
					print_r($get_data_detail_filter);
					foreach ($get_data_detail_filter as $data_row_detail_filter) {
						$RK_ID_FILTER_STOCK = $data_row_detail_filter->RK_ID;
						$PT_ID_FILTER_STOCK = $data_row_detail_filter->PT_ID;
						$PT_NAME_FILTER_STOCK = $data_row_detail_filter->PT_NAME;
						$STOCK_FILTER_STOCK = $data_row_detail_filter->STOCK;
						$PT_UNIT_FILTER_STOCK = $data_row_detail_filter->PT_UNIT;
					}
					//-----------------------------------------------------------------------------------------------//
					if ($STOCK_FILTER_STOCK == "0") {
						$RACK_AVAILABLE_FILTER = $RACK_AVAILABLE_FILTER + 1;
					} else {
						continue;
					}
				} else {
					continue;
				}
			}
			// echo "RACK USE = ";
			// print_r($RACK_USE_FILTER);
			// echo "<br>";
			// echo "RACK AVAILABLE= ";
			// print_r($RACK_AVAILABLE_FILTER);
			// echo "<br>";
		}

		die();
		//-----------------------------------------------------------------------------------------------//
		if ($RACK_USE_FILTER > $RACK_AVAILABLE_FILTER) {
			echo '
				<script>
					alert("APPROVE FAILED, RACK USE ' . $RACK_USE_FILTER, ' AND RACK AVAILABLE ' . $RACK_AVAILABLE_FILTER . ' PLEASE ADD MORE RACK");
					window.location.href = "' . site_url('i_approve_data') . '";
				</script>
			';
			exit();
		}


		//var_dump($RACK_USE_FILTER."<>".$RACK_AVAILABLE_FILTER);die();
		//FILTER ALL SUM PRODUCT & FILTER SUM USE RACK & COMPARE AVAILABLE RACK
		//-----------------------------------------------------------------------------------------------//
		//LOOP INSERT ROW PRODUCT TO RACK
		for ($x = 0; $x < $array_si_detail_id_length; $x++) {//LOOP 1
			//-----------------------------------------------------------------------------------------------//
			$si_detail_id = $array_si_detail_id[$x];
			$si_detail_date = date('Y-m-d H:i:s');
			$si_product_detail_id = $array_si_product_detail_id[$x];
			$si_product_detail_name = $array_si_product_detail_name[$x];
			$si_product_no = $array_si_product_no[$x];
			$si_product_qty_total = $array_si_product_qty_total[$x];
			$si_product_qty_good = $array_si_product_qty_good[$x];
			$si_product_qty_bad = $array_si_product_qty_bad[$x];
			//-----------------------------------------------------------------------------------------------//
			//ONLY GET 1 DATA PRODUCT
			$get_data_search_product_for_rack_evo = $this->M_library_database->DB_GET_DATA_SEARCH_PRODUCT_FOR_RACK_EVO($si_product_detail_id);
			if (empty($get_data_search_product_for_rack_evo) || $get_data_search_product_for_rack_evo == "") {
				echo '
					<script>
						alert("APPROVE FAILED, PRODUCT NOT FOUND");
						window.location.href = "' . site_url('i_approve_data') . '";
					</script>
				';
				exit();
			}
			foreach ($get_data_search_product_for_rack_evo as $data_row_search_product_for_rack_evo) {
				$PT_ID = $data_row_search_product_for_rack_evo->PT_ID;
				$PT_NAME = $data_row_search_product_for_rack_evo->PT_NAME;
				$PT_UNIT = $data_row_search_product_for_rack_evo->PT_UNIT;
				$PT_UNIT_MAX = $data_row_search_product_for_rack_evo->PT_UNIT_MAX;
				$PT_UNIT_MAX_EXT = $data_row_search_product_for_rack_evo->PT_UNIT_MAX_EXT;
				$PT_DIMENSION = $data_row_search_product_for_rack_evo->PT_DIMENSION;
				$PT_WEIGHT = $data_row_search_product_for_rack_evo->PT_WEIGHT;
				$PT_VOLUME = $data_row_search_product_for_rack_evo->PT_VOLUME;
				$PT_TYPE = $data_row_search_product_for_rack_evo->PT_TYPE;
				$PT_IS_MANUFDATE = $data_row_search_product_for_rack_evo->PT_IS_MANUFDATE;
				$PTCY_ID = $data_row_search_product_for_rack_evo->PTCY_ID;
				$SR_ID = $data_row_search_product_for_rack_evo->SR_ID;
				$SR_NAME = $data_row_search_product_for_rack_evo->SR_NAME;
				$SR_PHONE = $data_row_search_product_for_rack_evo->SR_PHONE;
				$SR_EMAIL = $data_row_search_product_for_rack_evo->SR_EMAIL;
				$SR_ADDRESS = $data_row_search_product_for_rack_evo->SR_ADDRESS;
				$SR_ADDRESS_MANUFACTURING = $data_row_search_product_for_rack_evo->SR_ADDRESS_MANUFACTURING;
				$SR_COUNTRY = $data_row_search_product_for_rack_evo->SR_COUNTRY;
				$PT_IMAGE_TYPE = $data_row_search_product_for_rack_evo->PT_IMAGE_TYPE;
				$PT_IMAGE = $data_row_search_product_for_rack_evo->PT_IMAGE;
			}
			//ONLY GET 1 DATA PRODUCT
			//-----------------------------------------------------------------------------------------------//
			//ONLY GET 1 DATA PRODUCT INBOUND DETAIL
			$get_data_product_inbound_detail_single_evo = $this->M_library_database->DB_GET_DATA_PRODUCT_INBOUND_DETAIL_SINGLE_EVO($si_detail_id);
			if (empty($get_data_product_inbound_detail_single_evo) || $get_data_product_inbound_detail_single_evo == "") {
				echo '
					<script>
						alert("APPROVE FAILED, PRODUCT INBOUND DETAIL NOT FOUND");
						window.location.href = "' . site_url('i_approve_data') . '";
					</script>
				';
				exit();
			}
			foreach ($get_data_product_inbound_detail_single_evo as $data_row_product_inbound_detail_single_evo) {
				$INFO_PTIDDL_ID = $data_row_product_inbound_detail_single_evo->PTIDDL_ID;
				$INFO_PTIDDL_DATE = $data_row_product_inbound_detail_single_evo->PTIDDL_DATE;
				$INFO_PTID_ID = $data_row_product_inbound_detail_single_evo->PTID_ID;
				$INFO_PT_ID = $data_row_product_inbound_detail_single_evo->PT_ID;
				$INFO_RK_ID = $data_row_product_inbound_detail_single_evo->RK_ID;
				$INFO_PTIDDL_LABEL = $data_row_product_inbound_detail_single_evo->PTIDDL_LABEL;
				$INFO_PTIDDL_NO = $data_row_product_inbound_detail_single_evo->PTIDDL_NO;
				$INFO_PTIDDL_MANUFDATE = $data_row_product_inbound_detail_single_evo->PTIDDL_MANUFDATE;
				$INFO_PTIDDL_EXPIRED = $data_row_product_inbound_detail_single_evo->PTIDDL_EXPIRED;
				$INFO_PTIDDL_QTY = $data_row_product_inbound_detail_single_evo->PTIDDL_QTY;
				$INFO_PTIDDL_QTY_GOOD = $data_row_product_inbound_detail_single_evo->PTIDDL_QTY_GOOD;
				$INFO_PTIDDL_QTY_BAD = $data_row_product_inbound_detail_single_evo->PTIDDL_QTY_BAD;
			}
			//ONLY GET 1 DATA PRODUCT INBOUND DETAIL
			//-----------------------------------------------------------------------------------------------//
			//SUM RACK USE
			if ($PT_UNIT_MAX_EXT == "0") {
				//BOX / PALLET
				$PRODUCT_TYPE_UNIT = "BOX_OR_PALLET";
				$QTY_BOX_OR_PALLET_PRODUCT = $si_product_qty_good;
				$QTY_PRODUCT = $PT_UNIT_MAX - $QTY_BOX_OR_PALLET_PRODUCT;
				if ($QTY_PRODUCT < 0) {
					$MOD_QTY = fmod($QTY_BOX_OR_PALLET_PRODUCT, $PT_UNIT_MAX);
					if ($MOD_QTY == 0) {
						$RACK_USE = $QTY_BOX_OR_PALLET_PRODUCT / $PT_UNIT_MAX;
					} else {
						$RACK_USE = $QTY_BOX_OR_PALLET_PRODUCT / $PT_UNIT_MAX;
						$ARRAY_RACK_USE = explode(".", $RACK_USE);
						$RACK_USE = $ARRAY_RACK_USE[0] + 1;
					}
				} else {
					$RACK_USE = 1;
				}
			} else {
				//PCS
				$PRODUCT_TYPE_UNIT = "PCS";
				$QTY_PCS_PRODUCT = $PT_UNIT_MAX_EXT - $si_product_qty_good;
				if ($QTY_PCS_PRODUCT < 0) {
					$MOD_PCS_PRODUCT = fmod($si_product_qty_good, $PT_UNIT_MAX_EXT);
					if ($MOD_PCS_PRODUCT == 0) {
						$QTY_BOX_OR_PALLET_PRODUCT = $si_product_qty_good / $PT_UNIT_MAX_EXT;
					} else {
						$QTY_BOX_OR_PALLET_PRODUCT = $si_product_qty_good / $PT_UNIT_MAX_EXT;
						$ARRAY_QTY_BOX_OR_PALLET_PRODUCT = explode(".", $QTY_BOX_OR_PALLET_PRODUCT);
						$QTY_BOX_OR_PALLET_PRODUCT = $ARRAY_QTY_BOX_OR_PALLET_PRODUCT[0] + 1;
					}
					$QTY_PRODUCT = $PT_UNIT_MAX - $QTY_BOX_OR_PALLET_PRODUCT;
					if ($QTY_PRODUCT < 0) {
						$MOD_QTY = fmod($QTY_BOX_OR_PALLET_PRODUCT, $PT_UNIT_MAX);
						if ($MOD_QTY == 0) {
							$RACK_USE = $QTY_BOX_OR_PALLET_PRODUCT / $PT_UNIT_MAX;
						} else {
							$RACK_USE = $QTY_BOX_OR_PALLET_PRODUCT / $PT_UNIT_MAX;
							$ARRAY_RACK_USE = explode(".", $RACK_USE);
							$RACK_USE = $ARRAY_RACK_USE[0] + 1;
						}
					} else {
						$RACK_USE = 1;
					}
				} else {
					$QTY_BOX_OR_PALLET_PRODUCT = 1;
					$RACK_USE = 1;
				}
			}
			//SUM RACK USE
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			$FINAL_QTY = $si_product_qty_good;
			$FINAL_RACK_USE = $RACK_USE;
			//var_dump($FINAL_RACK_USE);die();
			//-----------------------------------------------------------------------------------------------//
			$get_data_all_rack = $this->M_library_database->DB_GET_DATA_ALL_RACK();
			if (empty($get_data_all_rack) || $get_data_all_rack == "") {
				echo '
					<script>
						alert("APPROVE FAILED, RACK NOT FOUND");
						window.location.href = "' . site_url('i_approve_data') . '";
					</script>
				';
				exit();
			}
			//-----------------------------------------------------------------------------------------------//
			foreach ($get_data_all_rack as $data_row_all_rack) {//LOOP 2
				$RK_ID = $data_row_all_rack->RK_ID;
				$RK_TYPE = $data_row_all_rack->RK_TYPE;
				$RK_SUBRACK = $data_row_all_rack->RK_SUBRACK;
				$RK_LEVEL = $data_row_all_rack->RK_LEVEL;
				$SE_ID = $data_row_all_rack->SE_ID;
				//-----------------------------------------------------------------------------------------------//
				$PREFIX_RACK_ID = substr($RK_ID, 0, 3);
				//-----------------------------------------------------------------------------------------------//
				$check_rack_inbound_detail_evo = $this->M_library_database->DB_CHECK_RACK_INBOUND_DETAIL_EVO($RK_ID);
				//-----------------------------------------------------------------------------------------------//
				$delete_product_inbound_detail_evo = $this->M_library_database->DB_DELETE_PRODUCT_INBOUND_DETAIL_EVO($si_detail_id);
				//-----------------------------------------------------------------------------------------------//
				if (empty($check_rack_inbound_detail_evo) || $check_rack_inbound_detail_evo == "") {
					if ($RK_TYPE == "SINGLE") {
						//SINGLE
						if ($RK_LEVEL == "1") {
							if ($FINAL_RACK_USE == 1) {
								if ($si_product_no == "") {
									$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								} else {
									$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								}
								$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY . "[]" . $barcode;
								$data_insert = array(
									'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
									'PTIDDL_DATE' => date('Y-m-d H:i:s'),
									'PTID_ID' => $INFO_PTID_ID,
									'PT_ID' => $INFO_PT_ID,
									'RK_ID' => $RK_ID,
									'PTIDDL_LABEL' => $GENERATOR_LABEL,
									'PTIDDL_NO' => $si_product_no,//SN OR BATCH
									'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
									'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
									'PTIDDL_QTY' => $FINAL_QTY,
									'PTIDDL_QTY_GOOD' => $FINAL_QTY,
									'PTIDDL_QTY_BAD' => 0
								);
								$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
								break 1;
							} else {
								if ($PRODUCT_TYPE_UNIT == "PCS") {
									//PCS
									$FINAL_QTY_ORI = $FINAL_QTY;
									$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
									$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								} else {
									//BOX / PALLET
									$FINAL_QTY_ORI = $FINAL_QTY;//100
									$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46
									$FINAL_QTY_INPUT = $PT_UNIT_MAX;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								}
								if ($si_product_no == "") {
									$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								} else {
									$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								}
								$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
								$data_insert = array(
									'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
									'PTIDDL_DATE' => date('Y-m-d H:i:s'),
									'PTID_ID' => $INFO_PTID_ID,
									'PT_ID' => $INFO_PT_ID,
									'RK_ID' => $RK_ID,
									'PTIDDL_LABEL' => $GENERATOR_LABEL,
									'PTIDDL_NO' => $si_product_no,//SN OR BATCH
									'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
									'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
									'PTIDDL_QTY' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_BAD' => 0
								);
								$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
								$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
								continue;
							}
						} else {
							for ($z = 0; $z < $RK_LEVEL; $z++) {//LOOP 3
								if ($PRODUCT_TYPE_UNIT == "PCS") {
									//PCS
									$FINAL_QTY_ORI = $FINAL_QTY;
									$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
									$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								} else {
									//BOX / PALLET
									$FINAL_QTY_ORI = $FINAL_QTY;//100; 46
									$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46; 46 - 54 = -8
									$FINAL_QTY_INPUT = $PT_UNIT_MAX;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								}
								if ($si_product_no == "") {
									$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								} else {
									$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								}
								$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
								$data_insert = array(
									'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
									'PTIDDL_DATE' => date('Y-m-d H:i:s'),
									'PTID_ID' => $INFO_PTID_ID,
									'PT_ID' => $INFO_PT_ID,
									'RK_ID' => $RK_ID,
									'PTIDDL_LABEL' => $GENERATOR_LABEL,
									'PTIDDL_NO' => $si_product_no,//SN OR BATCH
									'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
									'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
									'PTIDDL_QTY' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_BAD' => 0
								);
								$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
								$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
								if ($FINAL_RACK_USE == 0) {
									break 2;
								}
							}
						}
					} else {
						//DRIVE IN
						if ($RK_LEVEL == "1") {
							if ($FINAL_RACK_USE == 1) {
								if ($si_product_no == "") {
									$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								} else {
									$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								}
								$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY . "[]" . $barcode;
								$data_insert = array(
									'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
									'PTIDDL_DATE' => date('Y-m-d H:i:s'),
									'PTID_ID' => $INFO_PTID_ID,
									'PT_ID' => $INFO_PT_ID,
									'RK_ID' => $RK_ID,
									'PTIDDL_LABEL' => $GENERATOR_LABEL,
									'PTIDDL_NO' => $si_product_no,//SN OR BATCH
									'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
									'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
									'PTIDDL_QTY' => $FINAL_QTY,
									'PTIDDL_QTY_GOOD' => $FINAL_QTY,
									'PTIDDL_QTY_BAD' => 0
								);
								$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
								break 1;
							} else {
								if ($PRODUCT_TYPE_UNIT == "PCS") {
									//PCS
									$FINAL_QTY_ORI = $FINAL_QTY;
									$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
									$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								} else {
									//BOX / PALLET
									$FINAL_QTY_ORI = $FINAL_QTY;//100
									$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46
									$FINAL_QTY_INPUT = $PT_UNIT_MAX;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								}
								if ($si_product_no == "") {
									$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								} else {
									$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								}
								$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
								$data_insert = array(
									'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
									'PTIDDL_DATE' => date('Y-m-d H:i:s'),
									'PTID_ID' => $INFO_PTID_ID,
									'PT_ID' => $INFO_PT_ID,
									'RK_ID' => $RK_ID,
									'PTIDDL_LABEL' => $GENERATOR_LABEL,
									'PTIDDL_NO' => $si_product_no,//SN OR BATCH
									'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
									'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
									'PTIDDL_QTY' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_BAD' => 0
								);
								$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
								$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
								continue;
							}
						} else {
							for ($z = 0; $z < $RK_LEVEL; $z++) {//LOOP 3
								if ($PRODUCT_TYPE_UNIT == "PCS") {
									//PCS
									$FINAL_QTY_ORI = $FINAL_QTY;
									$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
									$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								} else {
									//BOX / PALLET
									$FINAL_QTY_ORI = $FINAL_QTY;//100; 46
									$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46; 46 - 54 = -8
									$FINAL_QTY_INPUT = $PT_UNIT_MAX;
									if ($FINAL_QTY < 0) {
										$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
									}
								}
								if ($si_product_no == "") {
									$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								} else {
									$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
								}
								$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
								$data_insert = array(
									'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
									'PTIDDL_DATE' => date('Y-m-d H:i:s'),
									'PTID_ID' => $INFO_PTID_ID,
									'PT_ID' => $INFO_PT_ID,
									'RK_ID' => $RK_ID,
									'PTIDDL_LABEL' => $GENERATOR_LABEL,
									'PTIDDL_NO' => $si_product_no,//SN OR BATCH
									'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
									'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
									'PTIDDL_QTY' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
									'PTIDDL_QTY_BAD' => 0
								);
								$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
								$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
								if ($FINAL_RACK_USE == 0) {
									break 2;
								}
							}
						}
					}
				} else {
					$check_rack_outbound_detail_evo = $this->M_library_database->DB_CHECK_RACK_OUTBOUND_DETAIL_EVO($RK_ID);
					if (empty($check_rack_outbound_detail_evo) || $check_rack_outbound_detail_evo == "") {
						//-----------------------------------------------------------------------------------------------//
						$get_data_detail = $this->M_library_database->DB_GET_DATA_SEARCH_DETAIL_RACK_STOCK($RK_ID);
						//-----------------------------------------------------------------------------------------------//
						foreach ($get_data_detail as $data_row_detail) {
							$RK_ID = $data_row_detail->RK_ID;
							$PT_ID = $data_row_detail->PT_ID;
							$PT_NAME = $data_row_detail->PT_NAME;
							$STOCK = $data_row_detail->STOCK;
							$PT_UNIT = $data_row_detail->PT_UNIT;
						}
						//-----------------------------------------------------------------------------------------------//
						if ($STOCK == "0") {
							if ($RK_TYPE == "SINGLE") {
								//SINGLE
								if ($RK_LEVEL == "1") {
									if ($FINAL_RACK_USE == 1) {
										if ($si_product_no == "") {
											$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										} else {
											$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										}
										$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY . "[]" . $barcode;
										$data_insert = array(
											'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
											'PTIDDL_DATE' => date('Y-m-d H:i:s'),
											'PTID_ID' => $INFO_PTID_ID,
											'PT_ID' => $INFO_PT_ID,
											'RK_ID' => $RK_ID,
											'PTIDDL_LABEL' => $GENERATOR_LABEL,
											'PTIDDL_NO' => $si_product_no,//SN OR BATCH
											'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
											'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
											'PTIDDL_QTY' => $FINAL_QTY,
											'PTIDDL_QTY_GOOD' => $FINAL_QTY,
											'PTIDDL_QTY_BAD' => 0
										);
										$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
										break 1;
									} else {
										if ($PRODUCT_TYPE_UNIT == "PCS") {
											//PCS
											$FINAL_QTY_ORI = $FINAL_QTY;
											$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
											$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										} else {
											//BOX / PALLET
											$FINAL_QTY_ORI = $FINAL_QTY;//100
											$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46
											$FINAL_QTY_INPUT = $PT_UNIT_MAX;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										}
										if ($si_product_no == "") {
											$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										} else {
											$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										}
										$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
										$data_insert = array(
											'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
											'PTIDDL_DATE' => date('Y-m-d H:i:s'),
											'PTID_ID' => $INFO_PTID_ID,
											'PT_ID' => $INFO_PT_ID,
											'RK_ID' => $RK_ID,
											'PTIDDL_LABEL' => $GENERATOR_LABEL,
											'PTIDDL_NO' => $si_product_no,//SN OR BATCH
											'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
											'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
											'PTIDDL_QTY' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_BAD' => 0
										);
										$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
										$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
										continue;
									}
								} else {
									for ($z = 0; $z < $RK_LEVEL; $z++) {//LOOP 3
										if ($PRODUCT_TYPE_UNIT == "PCS") {
											//PCS
											$FINAL_QTY_ORI = $FINAL_QTY;
											$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
											$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										} else {
											//BOX / PALLET
											$FINAL_QTY_ORI = $FINAL_QTY;//100; 46
											$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46; 46 - 54 = -8
											$FINAL_QTY_INPUT = $PT_UNIT_MAX;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										}
										if ($si_product_no == "") {
											$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										} else {
											$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										}
										$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
										$data_insert = array(
											'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
											'PTIDDL_DATE' => date('Y-m-d H:i:s'),
											'PTID_ID' => $INFO_PTID_ID,
											'PT_ID' => $INFO_PT_ID,
											'RK_ID' => $RK_ID,
											'PTIDDL_LABEL' => $GENERATOR_LABEL,
											'PTIDDL_NO' => $si_product_no,//SN OR BATCH
											'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
											'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
											'PTIDDL_QTY' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_BAD' => 0
										);
										$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
										$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
										if ($FINAL_RACK_USE == 0) {
											break 2;
										}
									}
								}
							} else {
								//DRIVE IN
								if ($RK_LEVEL == "1") {
									if ($FINAL_RACK_USE == 1) {
										if ($si_product_no == "") {
											$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										} else {
											$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										}
										$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY . "[]" . $barcode;
										$data_insert = array(
											'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
											'PTIDDL_DATE' => date('Y-m-d H:i:s'),
											'PTID_ID' => $INFO_PTID_ID,
											'PT_ID' => $INFO_PT_ID,
											'RK_ID' => $RK_ID,
											'PTIDDL_LABEL' => $GENERATOR_LABEL,
											'PTIDDL_NO' => $si_product_no,//SN OR BATCH
											'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
											'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
											'PTIDDL_QTY' => $FINAL_QTY,
											'PTIDDL_QTY_GOOD' => $FINAL_QTY,
											'PTIDDL_QTY_BAD' => 0
										);
										$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
										break 1;
									} else {
										if ($PRODUCT_TYPE_UNIT == "PCS") {
											//PCS
											$FINAL_QTY_ORI = $FINAL_QTY;
											$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
											$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										} else {
											//BOX / PALLET
											$FINAL_QTY_ORI = $FINAL_QTY;//100
											$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46
											$FINAL_QTY_INPUT = $PT_UNIT_MAX;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										}
										if ($si_product_no == "") {
											$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										} else {
											$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										}
										$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
										$data_insert = array(
											'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
											'PTIDDL_DATE' => date('Y-m-d H:i:s'),
											'PTID_ID' => $INFO_PTID_ID,
											'PT_ID' => $INFO_PT_ID,
											'RK_ID' => $RK_ID,
											'PTIDDL_LABEL' => $GENERATOR_LABEL,
											'PTIDDL_NO' => $si_product_no,//SN OR BATCH
											'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
											'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
											'PTIDDL_QTY' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_BAD' => 0
										);
										$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
										$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
										continue;
									}
								} else {
									for ($z = 0; $z < $RK_LEVEL; $z++) {//LOOP 3
										if ($PRODUCT_TYPE_UNIT == "PCS") {
											//PCS
											$FINAL_QTY_ORI = $FINAL_QTY;
											$FINAL_QTY = $FINAL_QTY - ($PT_UNIT_MAX * $PT_UNIT_MAX_EXT);
											$FINAL_QTY_INPUT = $PT_UNIT_MAX * $PT_UNIT_MAX_EXT;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										} else {
											//BOX / PALLET
											$FINAL_QTY_ORI = $FINAL_QTY;//100; 46
											$FINAL_QTY = $FINAL_QTY - $PT_UNIT_MAX;//100 - 54 = 46; 46 - 54 = -8
											$FINAL_QTY_INPUT = $PT_UNIT_MAX;
											if ($FINAL_QTY < 0) {
												$FINAL_QTY_INPUT = $FINAL_QTY_ORI;
											}
										}
										if ($si_product_no == "") {
											$barcode = substr($si_product_detail_id, 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										} else {
											$barcode = substr($si_product_detail_id, 0, 6) . substr($si_product_no, 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_date_receive, 0, 6));
										}
										$GENERATOR_LABEL = $si_product_detail_id . "[]" . $si_product_detail_name . "[]" . $RK_ID . "[]" . $si_date_receive . "[]" . $FINAL_QTY_INPUT . "[]" . $barcode;
										$data_insert = array(
											'PTIDDL_ID' => $this->M_library_module->GENERATOR_REFF(),
											'PTIDDL_DATE' => date('Y-m-d H:i:s'),
											'PTID_ID' => $INFO_PTID_ID,
											'PT_ID' => $INFO_PT_ID,
											'RK_ID' => $RK_ID,
											'PTIDDL_LABEL' => $GENERATOR_LABEL,
											'PTIDDL_NO' => $si_product_no,//SN OR BATCH
											'PTIDDL_MANUFDATE' => $INFO_PTIDDL_MANUFDATE,
											'PTIDDL_EXPIRED' => $INFO_PTIDDL_EXPIRED,
											'PTIDDL_QTY' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_GOOD' => $FINAL_QTY_INPUT,
											'PTIDDL_QTY_BAD' => 0
										);
										$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data_insert);
										$FINAL_RACK_USE = $FINAL_RACK_USE - 1;
										if ($FINAL_RACK_USE == 0) {
											break 2;
										}
									}
								}
							}
						} else {
							continue;
						}
					} else {
						continue;
					}
				}
			}
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
		}
		//LOOP INSERT ROW PRODUCT TO RACK
		//-----------------------------------------------------------------------------------------------//
		//-----------------------------------------------------------------------------------------------//
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'PTID_ID' => $si_id,
			'PTID_DATE' => date('Y-m-d H:i:s'),
			'PTID_TGL_TERIMA' => $si_date_receive,
			'SR_ID' => $si_supplier_id,
			'PTID_PO_NO' => $si_po_no,
			'PTID_PACKING_LIST_NO' => $si_packing_list_no,
			'PTID_PIB_NO' => $si_pib_no,
			'PTID_INVOICE_NO' => $si_invoice_no,
			'FR_ID' => $si_forwarder_id,
			'PTID_CONTAINER_NO' => $si_container_no,
			'PTID_CONTAINER_PLAT_NO' => $si_container_plat_no,
			'PTID_SEAL_NO' => $si_seal_no,
			'PTID_STATUS' => "APPROVE",
			'PTID_APP_BY' => $this->session->userdata("session_mursmedic_id")
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_PRODUCT_INBOUND($si_id, $data_update);
		//-----------------------------------------------------------------------------------------------//
		if (!$is_ok) {
			echo '
				<script>
					alert("APPROVE FAILED, PLEASE TRY AGAIN");
					window.location.href = "' . site_url('i_approve_data') . '";
				</script>
			';
			exit();
		} else {
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "APPROVE INBOUND DATA",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			$this->load->view('V_i_approve_data_print');
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_delete()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('i_approve_data') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id = trim($this->input->post('sd_id'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_PRODUCT_INBOUND($sd_id);
		//-----------------------------------------------------------------------------------------------//
		if ($is_ok) {
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE INBOUND DATA",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "' . site_url('i_approve_data') . '";
				</script>
			';
			exit();
		} else {
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "' . site_url('i_approve_data') . '";
				</script>
			';
			exit();
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
