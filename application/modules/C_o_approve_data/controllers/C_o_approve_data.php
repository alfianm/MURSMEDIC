<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_o_approve_data extends CI_Controller{
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
		$this->load->view('V_o_approve_data');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_approve(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('o_approve_data').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));

		$si_date_send = trim($this->input->post('si_date_send'));//2018-12-18
		$si_distributor_id = trim($this->input->post('si_distributor_id'));
		$si_do_no = trim($this->input->post('si_do_no'));
		$si_order_no = trim($this->input->post('si_order_no'));
		$si_truck_type = trim($this->input->post('si_truck_type'));
		$si_truck_no = trim($this->input->post('si_truck_no'));
		$si_driver = trim($this->input->post('si_driver'));
		$si_ekspedisi_id = trim($this->input->post('si_ekspedisi_id'));
		$si_seal_no = trim($this->input->post('si_seal_no'));
		//-----------------------------------------------------------------------------------------------//
		$array_si_detail_id = $_POST['si_detail_id'];
		$array_si_product_detail_id = $_POST['si_product_detail_id'];
		$array_si_product_no = $_POST['si_product_no'];
		$array_si_product_qty_total = $_POST['si_product_qty_total'];
		$array_si_product_qty_good = $_POST['si_product_qty_good'];
		$array_si_product_qty_bad = $_POST['si_product_qty_bad'];
		
		$array_si_detail_id_length = count($array_si_detail_id);
		//-----------------------------------------------------------------------------------------------//
		$si_date_send_formated = $this->M_library_module->CLEAN_STRING($si_date_send);
		$si_date_now_formated = $this->M_library_module->CLEAN_STRING(date('Y-m-d'));
		if($si_date_send_formated < $si_date_now_formated){
			echo '
				<script>
					alert("TGL KIRIM TELAH LEWAT");
					window.location.href = "'.site_url('o_approve_data').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		//LOOP FILTER
		for($x = 0; $x < $array_si_detail_id_length; $x++) {
			//-----------------------------------------------------------------------------------------------//
			$si_product_qty_total = $array_si_product_qty_total[$x];
			$si_product_qty_good = $array_si_product_qty_good[$x];
			$si_product_qty_bad = $array_si_product_qty_bad[$x];
			//-----------------------------------------------------------------------------------------------//
			$si_sum_good_bad = $si_product_qty_good + $si_product_qty_bad;
			//-----------------------------------------------------------------------------------------------//
			if($si_product_qty_total != $si_sum_good_bad){
				echo '
					<script>
						alert("APPROVE FAILED, SUM TOTAL NOT MATCH");
						window.location.href = "'.site_url('o_approve_data').'";
					</script>
				';
				exit();
			}
		}
		//LOOP FILTER
		//-----------------------------------------------------------------------------------------------//
		//LOOP
		for($x = 0; $x < $array_si_detail_id_length; $x++) {
			//-----------------------------------------------------------------------------------------------//
			$si_detail_id = $array_si_detail_id[$x];
			$si_detail_date = date('Y-m-d H:i:s');
			$si_product_detail_id = $array_si_product_detail_id[$x];
			$si_product_no = $array_si_product_no[$x];
			$si_product_qty_total = $array_si_product_qty_total[$x];
			$si_product_qty_good = $array_si_product_qty_good[$x];
			$si_product_qty_bad = $array_si_product_qty_bad[$x];
			//-----------------------------------------------------------------------------------------------//
			$data_update = array(
				'PTODDL_ID' => $si_detail_id,
				'PTODDL_DATE' => $si_detail_date,
				'PTODDL_NO' => $si_product_no,
				'PTODDL_QTY_GOOD' => $si_product_qty_good,
				'PTODDL_QTY_BAD' => $si_product_qty_bad
			);
			//-----------------------------------------------------------------------------------------------//
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_PRODUCT_OUTBOUND_DETAIL($si_detail_id,$data_update);
			//-----------------------------------------------------------------------------------------------//
		}
		//LOOP
		//-----------------------------------------------------------------------------------------------//
		//-----------------------------------------------------------------------------------------------//
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
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
			'PTOD_STATUS' => "APPROVE",
			'PTOD_APP_BY' => $this->session->userdata("session_mursmedic_id")
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_PRODUCT_OUTBOUND($si_id,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if(!$is_ok){
			echo '
				<script>
					alert("APPROVE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('o_approve_data').'";
				</script>
			';
			exit();
		}else{
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "APPROVE OUTBOUND DATA",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("APPROVE SUCCESS");
					window.location.href = "'.site_url('o_approve_data').'";
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
	public function data_delete(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('o_approve_data').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id = trim($this->input->post('sd_id'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_PRODUCT_OUTBOUND($sd_id);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE OUTBOUND DATA",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "'.site_url('o_approve_data').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('o_approve_data').'";
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
	public function data_delete_detail(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('o_approve_data').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id_detail = trim($this->input->post('sd_id_detail'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_PRODUCT_OUTBOUND_DETAIL($sd_id_detail);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE OUTBOUND DATA DETAIL",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "'.site_url('o_approve_data').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('o_approve_data').'";
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
