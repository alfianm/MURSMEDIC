<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_log extends CI_Controller
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
		$this->load->view('V_log');
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
					window.location.href = "' . site_url('log') . '";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		//-----------------------------------------------------------------------------------------------//
		$table_data_all = unserialize(base64_decode($this->input->post('table_data_all')));
		//var_dump($table_data_all);die();
		//-----------------------------------------------------------------------------------------------//
		$objPHPExcel = new PHPExcel();
		//-----------------------------------------------------------------------------------------------//
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'ID')
			->setCellValue('C1', 'Userid')
			->setCellValue('D1', 'Desc')
			->setCellValue('E1', 'Date');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach ($table_data_all as $data_row) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A' . ($index + 1), $index)
				->setCellValue('B' . ($index + 1), $data_row->LG_ID)
				->setCellValue('C' . ($index + 1), $data_row->UR_ID)
				->setCellValue('D' . ($index + 1), $data_row->LG_DESC)
				->setCellValue('E' . ($index + 1), $data_row->LG_DATE);
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
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
