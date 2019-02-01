<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_q_data extends CI_Controller
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
		$this->load->view('V_q_data');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_download()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('q_data') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$table_data_all = unserialize(base64_decode($this->input->post('table_data_all')));
		//var_dump($table_data_all);die();
		//-----------------------------------------------------------------------------------------------//
		$objPHPExcel = new PHPExcel();
		//-----------------------------------------------------------------------------------------------//
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'Doc ID')
			->setCellValue('C1', 'Tgl')
			->setCellValue('D1', 'ID')
			->setCellValue('E1', 'Product Code')
			->setCellValue('F1', 'Label')
			->setCellValue('G1', 'SN / Batch')
			->setCellValue('H1', 'Manufdate')
			->setCellValue('I1', 'Expired Date')
			->setCellValue('J1', 'Qty')
			->setCellValue('K1', 'Status');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach ($table_data_all as $data_row) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A' . ($index + 1), $index)
				->setCellValue('B' . ($index + 1), $data_row->PTQE_ID)
				->setCellValue('C' . ($index + 1), $data_row->PTQE_DATE)
				->setCellValue('D' . ($index + 1), $data_row->PTQE_GID)
				->setCellValue('E' . ($index + 1), $data_row->PT_ID)
				->setCellValue('F' . ($index + 1), $data_row->PTQE_LABEL)
				->setCellValue('G' . ($index + 1), $data_row->PTQE_NO)
				->setCellValue('H' . ($index + 1), $data_row->PTQE_MANUFDATE)
				->setCellValue('I' . ($index + 1), $data_row->PTQE_EXPIRED)
				->setCellValue('J' . ($index + 1), $data_row->PTQE_QTY)
				->setCellValue('K' . ($index + 1), $data_row->PTQE_STATUS);
			$index++;
		}
		//-----------------------------------------------------------------------------------------------//
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . gmdate("D, d M Y H:i:s") . '.xls"');
		//-----------------------------------------------------------------------------------------------//
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("php://output");
		//-----------------------------------------------------------------------------------------------//
		exit();
	}

	function Repack()
	{
		date_default_timezone_set('Asia/Jakarta');

		$repack_id = trim($this->input->post('repack_id'));
		$repack_total = trim($this->input->post('repack_total'));
		$repack = trim($this->input->post('repack'));

		if ($repack_total < $repack) {
				echo '
				<script>
					alert("LESS PRODUCK");
					window.location.href = "'.site_url('q_data').'";
				</script>
			';
			exit();
		}

		$total_repack = $repack_total - $repack;

		if (!empty($repack) || !$repack == 0 || !$repack == "") {

			$data_update_destroy = [
				"PTQE_QTY" => $total_repack
			];

			$is_ok = $this->M_library_database->UPDATE_QUARANTINE($repack_id,$data_update_destroy);
		}

		if ($total_repack == 0) {
			$is_ok1 = $this->M_library_database->DELETE_PRODUCT_IN_QUARANTINE($repack_id);
		}

		// if ($is_ok) {
		// 	$this->load->view('V_i_input_data_quarantine');
		// }

		$this->load->view('V_i_input_data_quarantine');
	}

	function Destroy()
	{
		date_default_timezone_set('Asia/Jakarta');

		$sv_id = trim($this->input->post('sv_id'));
		$sv_total = trim($this->input->post('sv_total'));
		$destroy = trim($this->input->post('destroy'));

		if ($sv_total < $destroy) {
				echo '
				<script>
					alert("LESS PRODUCK");
					window.location.href = "'.site_url('q_data').'";
				</script>
			';
			exit();
		}

		if (!empty($destroy) || !$destroy == 0 || !$destroy == "") {
			$total_bad = $sv_total - $destroy;

			$data_update_destroy = [
				"PTQE_QTY" => $total_bad
			];

			$is_ok = $this->M_library_database->UPDATE_QUARANTINE($sv_id,$data_update_destroy);
		}

		if ($total_bad == 0) {
			$is_ok = $this->M_library_database->DELETE_PRODUCT_IN_QUARANTINE($sv_id);
		}

		$this->load->view('V_q_data');
	}

	function Sample()
	{
		date_default_timezone_set('Asia/Jakarta');

		$sample_id = trim($this->input->post('sample_id'));
		$sample_ptid_id = trim($this->input->post('sample_ptid_id'));
		$sample_name = trim($this->input->post('sample_name'));
		$sample_pt_id = trim($this->input->post('sample_pt_id'));
		$sample_no = $this->input->post('sample_no');
		$sample_expired = trim($this->input->post('sample_expired'));
		// --------------------------------------------------------- //
		$sample_total = trim($this->input->post('sample_total'));
		$sample = trim($this->input->post('sample'));

		if ($sample_total < $sample) {
				echo '
				<script>
					alert("LESS PRODUCK");
					window.location.href = "'.site_url('q_data').'";
				</script>
			';
			exit();
		}

		$total_sample = $sample_total - $sample;

		if(!empty($sample) || !$sample == 0 || !$sample == ""){

			$data_sample = [
				"PTID_ID" => $sample_ptid_id,
				"PT_ID" => $sample_pt_id,
				"PTSP_NAME" => $sample_name,
				"PTSP_DATE" => date('Y-m-d H:i:s'),
				"PTSP_NO" => $sample_no,
				"PTSP_EXPIRED" => $sample_expired,
				"PTSP_QTY" => $sample
			];

			$is_ok = $this->M_library_database->INSERT_SAMPLE($data_sample);

			if ($is_ok) {
				$data_update = [
				"PTQE_QTY" => $total_sample
			];

			$is_ok = $this->M_library_database->UPDATE_QUARANTINE($sample_id,$data_update);

			}else{
				echo '
				<script>
					alert("UPDATE TO QUARANTINE IS FAILED");
					window.location.href = "'.site_url('q_data').'";
				</script>
				';
			exit();
			}
		}



		if ($total_sample == 0) {
			$is_ok = $this->M_library_database->DELETE_PRODUCT_IN_QUARANTINE($sv_id);
		}

		$this->load->view('V_q_data');
	}

	function C_return()
	{
		date_default_timezone_set('Asia/Jakarta');

		$return_id = trim($this->input->post('return_id'));
		$return_ptid_id = trim($this->input->post('return_ptid_id'));
		$return_name = trim($this->input->post('return_name'));
		$return_pt_id = trim($this->input->post('return_pt_id'));
		$return_no = $this->input->post('return_no');
		$return_expired = trim($this->input->post('return_expired'));
		// --------------------------------------------------------- //
		$return_total = trim($this->input->post('return_total'));
		$return = trim($this->input->post('return'));

		if ($return_total < $return) {
				echo '
				<script>
					alert("LESS PRODUCK");
					window.location.href = "'.site_url('q_data').'";
				</script>
			';
			exit();
		}

		$total_return = $return_total - $return;

		if(!empty($return) || !$return == 0 || !$return == ""){

			$data_return = [
					"PTID_ID" => $return_ptid_id,
					"PTRN_NAME" => $return_name,
					"PTRN_DATE" => date('Y-m-d H:i:s'),
					"PT_ID" => $return_pt_id,
					"PTRN_NO" => $return_no,
					"PTRN_EXPIRED" => $return_expired,
					"PTRN_QTY" => $return
			];

			$is_ok = $this->M_library_database->INSERT_RETURN($data_return);
			
			if ($is_ok) {
				$data_update = [
				"PTQE_QTY" => $total_return
			];

			$is_ok = $this->M_library_database->UPDATE_QUARANTINE($return_id,$data_update);

			}else{
				echo '
				<script>
					alert("UPDATE TO QUARANTINE IS FAILED");
					window.location.href = "'.site_url('q_data').'";
				</script>
				';
			exit();
			}
		}



		if ($total_return == 0) {
			$is_ok = $this->M_library_database->DELETE_PRODUCT_IN_QUARANTINE($return_id);
		}

		$this->load->view('V_q_data');
	}

	// function all_data_quarantine()
	// {

	// 	$sv_id = trim($this->input->post('sv_id'));
	// 	$sv_name = trim($this->input->post('sv_name'));
	// 	$sv_pt_id = trim($this->input->post('sv_pt_id'));
	// 	$sv_no = $this->input->post('sv_no');
	// 	$sv_expired = trim($this->input->post('sv_expired'));
	// 	$sv_total = trim($this->input->post('sv_total'));
	// 	// $repack = trim($this->input->post('repack'));
	// 	$sample = trim($this->input->post('sample'));
	// 	$destroy = trim($this->input->post('destroy'));
	// 	// $return = trim($this->input->post('return'));

	// 	$all_data = $repack + $sample + $destroy + $return;

	// 	if ($sv_total < $all_data) {
	// 			echo '
	// 			<script>
	// 				alert("LESS PRODUCK");
	// 				window.location.href = "'.site_url('q_data').'";
	// 			</script>
	// 		';
	// 		exit();
	// 	}

	// 	// if(!empty($repack) || !$repack == 0 || !$repack == ""){
			
	// 	// }

	// 	if(!empty($sample) || !$sample == 0 || !$sample == ""){

	// 		$data_sample = [
	// 				"PTSP_ID" => $sv_id,
	// 				"PTSP_NAME" => $sv_name,
	// 				"PTSP_DATE" => date('Y-m-d H:i:s'),
	// 				"PT_ID" => $sv_pt_id,
	// 				"PTSP_NO" => $sv_no,
	// 				"PTSP_EXPIRED" => $sv_expired,
	// 				"PTSP_QTY" => $sample
	// 		];

	// 		$is_ok = $this->M_library_database->INSERT_SAMPLE($data_sample);
	// 	}


		// $total_1 = $sv_total - $sample;

		// print_r($total_1);
		// die();
		// if (!empty($destroy) || !$destroy == 0 || !$destroy == "") {
		// 	// $total_bad = $total_1 - $destroy;

		// 	$data_update_destroy = [
		// 		"PTQE_QTY" => $destroy
		// 	];

		// 	$is_ok = $this->M_library_database->UPDATE_DESTROY($sv_id,$data_update_destroy);

		// 	// if ($is_ok) {
		// 	// 	echo '
		// 	// 	<script>
		// 	// 		alert("PRODUCT ");
		// 	// 		window.location.href = "'.site_url('q_data').'";
		// 	// 	</script>
		// 	// ';
		// 	// exit();
		// 	// }
		// }
		// // $total = $sv_total - $destroy - $sample;
		// // print_r($total);
		// // die();
		// // if(!empty($return) || !$return == 0 || !$return == ""){
			
		// // }

		// if ($total == 0) {
		// 	$is_ok = $this->M_library_database->DELETE_PRODUCT_IN_QUARANTINE($sv_id);
		// }

	// 	$this->load->view('V_q_data');

	// }
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
