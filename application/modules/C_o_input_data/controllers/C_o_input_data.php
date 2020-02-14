<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_o_input_data extends CI_Controller{
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function __construct(){
        parent::__construct();
		
		if($this->session->userdata('session_mursmedic_status') != "LOGIN"){
			redirect(site_url("index"));
		}
    }
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function index(){
		$this->load->view('V_o_input_data');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_insert(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('o_input_data').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));

		$si_date_send = trim($this->input->post('si_date_send'));
		$si_distributor_id = trim($this->input->post('si_distributor_id'));
		$si_do_no = "";
		$si_order_no = trim($this->input->post('si_order_no'));
		$si_truck_type = "";
		$si_truck_no = "";
		$si_driver = "";
		$si_ekspedisi_id = trim($this->input->post('si_ekspedisi_id'));
		$si_seal_no = "";
		//-----------------------------------------------------------------------------------------------//
		//SAMPLE:PT_ID[]PT_NAME[]PT_UNIT[]PT_UNIT_MAX[]PT_TYPE[]PT_IS_MANUFDATE[]PT_STOCK
		//SAMPLE VALUE:ID PRODUCT A[]PRODUCT A[]BOX[]1[]SN[]NO[]5
		$array_si_product_id = $_POST['si_product_id'];
		$array_si_product_stock = $_POST['si_product_stock'];
		$array_si_product_qty = $_POST['si_product_qty'];
		
		$array_si_product_id_length = count($array_si_product_id);
		$sum_qty_total = 0;
		for($x = 0; $x < $array_si_product_id_length; $x++) {
			//FILTER
			if($array_si_product_qty[$x] > $array_si_product_stock[$x]){
				echo '
					<script>
						alert("INSERT FAILED, NOT ENOUGH STOCK");
						window.location.href = "'.site_url('o_input_data').'";
					</script>
				';
				exit();
			}
			//FILTER
			//-----------------------------------------------------------------------------------------------//
			$sum_qty_total += $array_si_product_qty[$x];
		}
		//-----------------------------------------------------------------------------------------------//
		$si_qty_total = $sum_qty_total;
		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'PTOD_ID' => $si_id,
			'PTOD_DATE' => date('Y-m-d H:i:s'),
			'PTOD_TGL_KIRIM' => $si_date_send,
			'DR_ID' => $si_distributor_id,
			'PTOD_DO_NO' => $si_do_no,
			'PTOD_ORDER_NO' => $si_order_no,
			'PTOD_TRUCK_TYPE' => $si_truck_type,
			'PTOD_TRUCK_NO' => $si_truck_no,
			'PTOD_DRIVER' => $si_driver,
			'EI_ID' => $si_ekspedisi_id,
			'PTOD_SEAL_NO' => $si_seal_no,
			'UR_ID' => $this->session->userdata("session_mursmedic_id"),
			'PTOD_STATUS' => "WAITING",
			'PTOD_APP_BY' => "",
			'PTOD_QTY_TOTAL' => $si_qty_total
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_OUTBOUND($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if(!$is_ok){
			echo '
				<script>
					alert("INSERT FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('o_input_data').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		//INSERT LOG
		$data_log = array(
			'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
			'UR_ID' => $this->session->userdata("session_mursmedic_id"),
			'LG_DESC' => "INSERT PRODUCT OUTBOUND",
			'LG_DATE' => date('Y-m-d H:i:s')
		);
		$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_o_input_data_detail');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_insert_detail(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('o_input_data').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));
		//-----------------------------------------------------------------------------------------------//
		$array_si_product_detail_id = $_POST['si_product_detail_id'];
		$array_si_product_detail_name = $_POST['si_product_detail_name'];
		$array_si_product_detail_rack = $_POST['si_product_detail_rack'];
		$array_si_product_detail_label = $_POST['si_product_detail_label'];
		$array_si_product_detail_no = $_POST['si_product_detail_no'];
		$array_si_product_detail_manufdate = $_POST['si_product_detail_manufdate'];
		$array_si_product_detail_qty = $_POST['si_product_detail_qty'];
		$array_si_product_detail_expired = $_POST['si_product_detail_expired'];
		
		$array_si_product_detail_no_length = count($array_si_product_detail_no);
		//-----------------------------------------------------------------------------------------------//
		//LOOP
		for($x = 0; $x < $array_si_product_detail_no_length; $x++) {
			//-----------------------------------------------------------------------------------------------//
			$si_detail_id = $this->M_library_module->GENERATOR_REFF();
			$si_detail_date = date('Y-m-d H:i:s');
			//-----------------------------------------------------------------------------------------------//
			$data_insert = array(
				'PTODDL_ID' => $si_detail_id,
				'PTODDL_DATE' => $si_detail_date,
				'PTOD_ID' => $si_id,
				'PT_ID' => $array_si_product_detail_id[$x],
				'RK_ID' => $array_si_product_detail_rack[$x],
				'PTODDL_LABEL' => $array_si_product_detail_label[$x],
				'PTODDL_NO' => $array_si_product_detail_no[$x],
				'PTODDL_MANUFDATE' => $array_si_product_detail_manufdate[$x],
				'PTODDL_EXPIRED' => $array_si_product_detail_expired[$x],
				'PTODDL_QTY' => $array_si_product_detail_qty[$x],
				'PTODDL_QTY_GOOD' => 0,
				'PTODDL_QTY_BAD' => 0
			);
			//-----------------------------------------------------------------------------------------------//
			$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_OUTBOUND_DETAIL($data_insert);
			//-----------------------------------------------------------------------------------------------//
		}
		//LOOP
		//-----------------------------------------------------------------------------------------------//
		//INSERT LOG
		$data_log = array(
			'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
			'UR_ID' => $this->session->userdata("session_mursmedic_id"),
			'LG_DESC' => "INSERT PRODUCT OUTBOUND DETAIL",
			'LG_DATE' => date('Y-m-d H:i:s')
		);
		$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_o_input_data_detail_print');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
