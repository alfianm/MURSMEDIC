<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_i_input_data_quarantine extends CI_Controller
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
		$this->load->view('V_i_input_data_quarantine');
	}

	public function Repack()
	{
		date_default_timezone_set('Asia/Jakarta');

		$repack_id = trim($this->input->post('repack_id'));
		$repack_pt_id = trim($this->input->post('repack_pt_id'));
		$repack_total = trim($this->input->post('repack_total'));
		$repack = trim($this->input->post('repack'));

		if ($repack_total < $repack) {
			echo '
				<script>
					alert("LESS PRODUCK");
					window.location.href = "' . site_url('q_data') . '";
				</script>
			';
			exit();
		}

		$total_repack = $repack_total - $repack;

		if (!empty($repack) || !$repack == 0 || !$repack == "") {

			$data_update_destroy = [
				"PTQE_QTY" => $total_repack
			];

			$is_ok = $this->M_library_database->UPDATE_QUARANTINE($repack_id, $data_update_destroy);
		}

		if ($total_repack == 0) {
			$is_ok1 = $this->M_library_database->DELETE_PRODUCT_IN_QUARANTINE($repack_id);
		}

		// if ($is_ok) {
		// 	$this->load->view('V_i_input_data_quarantine');
		// }

		$this->load->view('V_i_input_data_quarantine');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_insert_q()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('i_input_data') . '";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));

		$si_date_receive = trim($this->input->post('si_date_receive'));
		$si_supplier_id = trim($this->input->post('si_supplier_id'));
		$si_po_no = trim($this->input->post('si_po_no'));
		$si_packing_list_no = trim($this->input->post('si_packing_list_no'));
		$si_pib_no = trim($this->input->post('si_pib_no'));
		$si_invoice_no = trim($this->input->post('si_invoice_no'));
		$si_forwarder_id = trim($this->input->post('si_forwarder_id'));
		$si_container_no = "";//FIX
		$si_container_plat_no = "";//FIX
		$si_seal_no = "";//FIX
		//-----------------------------------------------------------------------------------------------//
		//SAMPLE:PT_ID[]PT_NAME[]PT_UNIT[]PT_UNIT_MAX[]PT_TYPE[]PT_IS_MANUFDATE
		//SAMPLE VALUE:ID PRODUCT A[]PRODUCT A[]BOX[]1[]SN[]NO
		$array_si_product_id = $_POST['si_product_id'];
		$array_si_product_qty = $_POST['si_product_qty'];
		$array_si_product_expired = $_POST['si_product_expired'];

		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
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
			'UR_ID' => $this->session->userdata("session_mursmedic_id"),
			'PTID_STATUS' => "WAITING",
			'PTID_APP_BY' => "",
			'PTID_QTY_TOTAL' => $array_si_product_qty
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if (!$is_ok) {
			echo '
				<script>
					alert("INSERT FAILED, PLEASE TRY AGAIN");
					window.location.href = "' . site_url('i_input_data') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		//INSERT LOG
		$data_log = array(
			'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
			'UR_ID' => $this->session->userdata("session_mursmedic_id"),
			'LG_DESC' => "INSERT PRODUCT INBOUND",
			'LG_DATE' => date('Y-m-d H:i:s')
		);
		$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_i_input_data_detail_quarantine');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_insert_detail_q()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('i_input_data') . '";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));
		
		//-----------------------------------------------------------------------------------------------//
		$array_si_product_detail_id = $_POST['si_product_detail_id'];
		$array_si_product_detail_no = $_POST['si_product_detail_no'];
		$array_si_product_detail_manufdate = $_POST['si_product_detail_manufdate'];
		$array_si_product_detail_qty = $_POST['si_product_detail_qty'];
		$si_product_detail_expired = $_POST['si_product_detail_expired'];

		$array_si_product_detail_no_length = count($array_si_product_detail_no);

		//-----------------------------------------------------------------------------------------------//
		//LOOP
		
			//-----------------------------------------------------------------------------------------------//
			//-----------------------------------------------------------------------------------------------//
		$si_detail_id = $this->M_library_module->GENERATOR_REFF();
		$si_detail_date = date('Y-m-d H:i:s');
			//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'PTIDDL_ID' => $si_detail_id,
			'PTIDDL_DATE' => $si_detail_date,
			'PTID_ID' => $si_id,
			'PT_ID' => $array_si_product_detail_id,
			'RK_ID' => "",
			'PTIDDL_LABEL' => "",
			'PTIDDL_NO' => $array_si_product_detail_no,
			'PTIDDL_MANUFDATE' => $array_si_product_detail_manufdate,
			'PTIDDL_EXPIRED' => $si_product_detail_expired,
			'PTIDDL_QTY' => $array_si_product_detail_qty,
			'PTIDDL_QTY_GOOD' => 0,
			'PTIDDL_QTY_BAD' => 0
		);
			//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL($data_insert);

		//LOOP
		//-----------------------------------------------------------------------------------------------//
		//INSERT LOG
		$data_log = array(
			'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
			'UR_ID' => $this->session->userdata("session_mursmedic_id"),
			'LG_DESC' => "INSERT PRODUCT INBOUND DETAIL",
			'LG_DATE' => date('Y-m-d H:i:s')
		);
		$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_i_input_data_detail_print_quarantine');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	function get_produk_by_id()
	{
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->GET_PRODUK_BY_ID($id_key);
		$result = json_encode($data);
		echo $result;
		exit();
	}
}
//-----------------------------------------------------------------------------------------------//
