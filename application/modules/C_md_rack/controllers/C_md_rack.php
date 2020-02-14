<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_md_rack extends CI_Controller
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
		$this->load->view('V_md_rack');
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
					window.location.href = "' . site_url('md_rack') . '";
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
			->setCellValue('B1', 'ID')
			->setCellValue('C1', 'Type / Name')
			->setCellValue('D1', 'Subrack')
			->setCellValue('E1', 'Level')
			->setCellValue('F1', 'Storage ID');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach ($table_data_all as $data_row) {
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A' . ($index + 1), $index)
				->setCellValue('B' . ($index + 1), $data_row->RK_ID)
				->setCellValue('C' . ($index + 1), $data_row->RK_TYPE)
				->setCellValue('D' . ($index + 1), $data_row->RK_SUBRACK)
				->setCellValue('E' . ($index + 1), $data_row->RK_LEVEL)
				->setCellValue('F' . ($index + 1), $data_row->SE_ID);
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
	public function data_insert()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));
		$si_type = trim($this->input->post('si_type'));
		$si_subrack = trim($this->input->post('si_subrack'));
		$si_level = trim($this->input->post('si_level'));
		$si_storage_id = trim($this->input->post('si_storage_id'));
		//-----------------------------------------------------------------------------------------------//
		$si_id_length = strlen($si_id);
		if ($si_id_length != 3) {
			echo '
				<script>
					alert("ID MUST 3 DIGIT");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		if ($si_level > 2) {
			echo '
				<script>
					alert("MAX LEVEL 2");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		//AUTO GENERATOR ID RACK
		$is_has_fail = false;
		if ($si_type == "DRIVE IN") {
			for ($x = 1; $x <= $si_subrack; $x++) {
				if ($si_level == "1") {
					$generate_id_rack = $si_id . "-" . $x . "-" . "0";
					$data_insert = array(
						'RK_ID' => $generate_id_rack,
						'RK_TYPE' => $si_type,
						'RK_SUBRACK' => $si_subrack,
						'RK_LEVEL' => $si_level,
						'SE_ID' => $si_storage_id
					);
					$is_ok = $this->M_library_database->DB_INSERT_DATA_RACK($data_insert);
					if (!$is_ok) {
						$is_has_fail = true;
					}
				} else {
					for ($y = 1; $y <= $si_level; $y++) {
						if ($y == 1) {
							$generate_id_rack = $si_id . "-" . $x . "-" . "B";
						} else {
							$generate_id_rack = $si_id . "-" . $x . "-" . "T";
						}
						$data_insert = array(
							'RK_ID' => $generate_id_rack,
							'RK_TYPE' => $si_type,
							'RK_SUBRACK' => $si_subrack,
							'RK_LEVEL' => $si_level,
							'SE_ID' => $si_storage_id
						);
						$is_ok = $this->M_library_database->DB_INSERT_DATA_RACK($data_insert);
						if (!$is_ok) {
							$is_has_fail = true;
						}
					}
				}
			}
		} else {
			for ($x = 1; $x <= $si_level; $x++) {
				if ($si_level == "1") {
					$generate_id_rack = $si_id . "-" . "0";
				} else {
					if ($x == 1) {
						$generate_id_rack = $si_id . "-" . "B";
					} else {
						$generate_id_rack = $si_id . "-" . "T";
					}
				}
				$data_insert = array(
					'RK_ID' => $generate_id_rack,
					'RK_TYPE' => $si_type,
					'RK_SUBRACK' => $si_subrack,
					'RK_LEVEL' => $si_level,
					'SE_ID' => $si_storage_id
				);
				$is_ok = $this->M_library_database->DB_INSERT_DATA_RACK($data_insert);
				if (!$is_ok) {
					$is_has_fail = true;
				}
			}
		}
		//-----------------------------------------------------------------------------------------------//
		if (!$is_has_fail) {
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "INSERT RACK",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("INSERT SUCCESS");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		} else {
			echo '
				<script>
					alert("INSERT SOME DATA FAILED, PLEASE CHECK");
					window.location.href = "' . site_url('md_rack') . '";
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
	public function data_update()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$su_id_lastest = trim($this->input->post('su_id_lastest'));
		$su_id = trim($this->input->post('su_id'));
		$su_type = trim($this->input->post('su_type'));
		$su_subrack = trim($this->input->post('su_subrack'));
		$su_level = trim($this->input->post('su_level'));
		$su_storage_id = trim($this->input->post('su_storage_id'));
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'RK_ID' => $su_id,
			'RK_TYPE' => $su_type,
			'RK_SUBRACK' => $su_subrack,
			'RK_LEVEL' => $su_level,
			'SE_ID' => $su_storage_id
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_RACK($su_id_lastest, $data_update);
		//-----------------------------------------------------------------------------------------------//
		if ($is_ok) {
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "UPDATE RACK",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("UPDATE SUCCESS");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		} else {
			echo '
				<script>
					alert("UPDATE FAILED, PLEASE TRY AGAIN");
					window.location.href = "' . site_url('md_rack') . '";
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
	public function data_delete()
	{
		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id = trim($this->input->post('sd_id'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_RACK($sd_id);
		//-----------------------------------------------------------------------------------------------//
		if ($is_ok) {
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE RACK",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "' . site_url('md_rack') . '";
				</script>
			';
			exit();
		} else {
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "' . site_url('md_rack') . '";
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
