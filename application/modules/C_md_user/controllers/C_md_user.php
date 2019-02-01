<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_md_user extends CI_Controller{
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
		$this->load->view('V_md_user');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function data_download(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('md_user').'";
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
			->setCellValue('A1','No')
			->setCellValue('B1','ID')
			->setCellValue('C1','Name')
			->setCellValue('D1','Phone')
			->setCellValue('E1','Email')
			->setCellValue('F1','Grant ID');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach($table_data_all as $data_row){
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.($index+1),$index)
				->setCellValue('B'.($index+1),$data_row->UR_ID)
				->setCellValue('C'.($index+1),$data_row->UR_NAME)
				->setCellValue('D'.($index+1),$data_row->UR_PHONE)
				->setCellValue('E'.($index+1),$data_row->UR_EMAIL)
				->setCellValue('F'.($index+1),$data_row->GT_ID);
			$index++;
		}
		//-----------------------------------------------------------------------------------------------//
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0",false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.gmdate("D, d M Y H:i:s").'.xls"');
		//-----------------------------------------------------------------------------------------------//
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save("php://output");
		//-----------------------------------------------------------------------------------------------//
		exit();
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
					window.location.href = "'.site_url('md_user').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));
		$si_password = trim($this->input->post('si_password'));
		$si_name = trim($this->input->post('si_name'));
		$si_phone = trim($this->input->post('si_phone'));
		$si_email = trim($this->input->post('si_email'));
		$si_grant_id = trim($this->input->post('si_grant_id'));
		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'UR_ID' => $si_id,
			'UR_PASSWORD' => $si_password,
			'UR_NAME' => $si_name,
			'UR_PHONE' => $si_phone,
			'UR_EMAIL' => $si_email,
			'GT_ID' => $si_grant_id
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_USER($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "INSERT USER",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("INSERT SUCCESS");
					window.location.href = "'.site_url('md_user').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("INSERT FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_user').'";
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
	public function data_update(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.site_url('md_user').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$su_id = trim($this->input->post('su_id'));
		$su_password = trim($this->input->post('su_password'));
		$su_name = trim($this->input->post('su_name'));
		$su_phone = trim($this->input->post('su_phone'));
		$su_email = trim($this->input->post('su_email'));
		$su_grant_id = trim($this->input->post('su_grant_id'));
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'UR_ID' => $su_id,
			'UR_PASSWORD' => $su_password,
			'UR_NAME' => $su_name,
			'UR_PHONE' => $su_phone,
			'UR_EMAIL' => $su_email,
			'GT_ID' => $su_grant_id
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_USER($su_id,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "UPDATE USER",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			if($su_id == $this->session->userdata("session_mursmedic_id")){
				$this->session->sess_destroy();
				redirect(site_url('index'));
				exit();
			}
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("UPDATE SUCCESS");
					window.location.href = "'.site_url('md_user').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("UPDATE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_user').'";
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
					window.location.href = "'.site_url('md_user').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id = trim($this->input->post('sd_id'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_USER($sd_id);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE USER",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			if($sd_id == $this->session->userdata("session_mursmedic_id")){
				$this->session->sess_destroy();
				redirect(site_url('index'));
				exit();
			}
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "'.site_url('md_user').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_user').'";
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
