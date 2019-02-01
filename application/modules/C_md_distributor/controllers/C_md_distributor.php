<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_md_distributor extends CI_Controller{
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
		$this->load->view('V_md_distributor');
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
					window.location.href = "'.site_url('md_distributor').'";
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
			->setCellValue('F1','Address')
			->setCellValue('G1','Shipping Address')
			->setCellValue('H1','City');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach($table_data_all as $data_row){
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.($index+1),$index)
				->setCellValue('B'.($index+1),$data_row->DR_ID)
				->setCellValue('C'.($index+1),$data_row->DR_NAME)
				->setCellValue('D'.($index+1),$data_row->DR_PHONE)
				->setCellValue('E'.($index+1),$data_row->DR_EMAIL)
				->setCellValue('F'.($index+1),$data_row->DR_ADDRESS)
				->setCellValue('G'.($index+1),$data_row->DR_ADDRESS_SHIPPING)
				->setCellValue('H'.($index+1),$data_row->DR_CITY);
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
					window.location.href = "'.site_url('md_distributor').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));
		$si_name = trim($this->input->post('si_name'));
		$si_phone = trim($this->input->post('si_phone'));
		$si_email = trim($this->input->post('si_email'));
		$si_address = trim($this->input->post('si_address'));
		$si_address_shipping = trim($this->input->post('si_address_shipping'));
		$si_city = trim($this->input->post('si_city'));
		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'DR_ID' => $si_id,
			'DR_NAME' => $si_name,
			'DR_PHONE' => $si_phone,
			'DR_EMAIL' => $si_email,
			'DR_ADDRESS' => $si_address,
			'DR_ADDRESS_SHIPPING' => $si_address_shipping,
			'DR_CITY' => $si_city
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_DISTRIBUTOR($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "INSERT DISTRIBUTOR",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("INSERT SUCCESS");
					window.location.href = "'.site_url('md_distributor').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("INSERT FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_distributor').'";
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
					window.location.href = "'.site_url('md_distributor').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$su_id_lastest = trim($this->input->post('su_id_lastest'));
		$su_id = trim($this->input->post('su_id'));
		$su_name = trim($this->input->post('su_name'));
		$su_phone = trim($this->input->post('su_phone'));
		$su_email = trim($this->input->post('su_email'));
		$su_address = trim($this->input->post('su_address'));
		$su_address_shipping = trim($this->input->post('su_address_shipping'));
		$su_city = trim($this->input->post('su_city'));
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'DR_ID' => $su_id,
			'DR_NAME' => $su_name,
			'DR_PHONE' => $su_phone,
			'DR_EMAIL' => $su_email,
			'DR_ADDRESS' => $su_address,
			'DR_ADDRESS_SHIPPING' => $su_address_shipping,
			'DR_CITY' => $su_city
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DISTRIBUTOR($su_id_lastest,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "UPDATE DISTRIBUTOR",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("UPDATE SUCCESS");
					window.location.href = "'.site_url('md_distributor').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("UPDATE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_distributor').'";
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
					window.location.href = "'.site_url('md_distributor').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id = trim($this->input->post('sd_id'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_DISTRIBUTOR($sd_id);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE DISTRIBUTOR",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "'.site_url('md_distributor').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_distributor').'";
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
