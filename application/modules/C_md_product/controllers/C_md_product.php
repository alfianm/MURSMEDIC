<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_md_product extends CI_Controller{
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
		$this->load->view('V_md_product');
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
					window.location.href = "'.site_url('md_product').'";
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
			->setCellValue('B1','Product Code')
			->setCellValue('C1','Name')
			->setCellValue('D1','Unit')
			->setCellValue('E1','Max Capacity (Rack)')
			->setCellValue('F1','Max Capacity (Box)')
			->setCellValue('G1','Type')
			->setCellValue('H1','Manufacturing Date')
			->setCellValue('I1','Category ID')
			->setCellValue('J1','Supplier ID')
			->setCellValue('K1','Supplier Name');
		//-----------------------------------------------------------------------------------------------//
		$index = 1;
		foreach($table_data_all as $data_row){
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.($index+1),$index)
				->setCellValue('B'.($index+1),$data_row->PT_ID)
				->setCellValue('C'.($index+1),$data_row->PT_NAME)
				->setCellValue('D'.($index+1),$data_row->PT_UNIT)
				->setCellValue('E'.($index+1),$data_row->PT_UNIT_MAX)
				->setCellValue('F'.($index+1),$data_row->PT_UNIT_MAX_EXT)
				->setCellValue('G'.($index+1),$data_row->PT_TYPE)
				->setCellValue('H'.($index+1),$data_row->PT_IS_MANUFDATE)
				->setCellValue('I'.($index+1),$data_row->PTCY_ID)
				->setCellValue('J'.($index+1),$data_row->SR_ID)
				->setCellValue('K'.($index+1),$data_row->SR_NAME);
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
					window.location.href = "'.site_url('md_product').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_id = trim($this->input->post('si_id'));
		$si_name = trim($this->input->post('si_name'));
		$si_unit = trim($this->input->post('si_unit'));
		$si_unit_max = trim($this->input->post('si_unit_max'));
		$si_unit_max_ext = trim($this->input->post('si_unit_max_ext'));
		//-----------------------------------------------------------------------------------------------//
		$si_dimension_a = trim($this->input->post('si_dimension_a')).trim($this->input->post('si_dimension_type_a'));
		$si_dimension_b = trim($this->input->post('si_dimension_b')).trim($this->input->post('si_dimension_type_b'));
		$si_dimension_c = trim($this->input->post('si_dimension_c')).trim($this->input->post('si_dimension_type_c'));
		$si_dimension = $si_dimension_a." x ".$si_dimension_b." x ".$si_dimension_c;
		//-----------------------------------------------------------------------------------------------//
		$si_weight = trim($this->input->post('si_weight'));
		$si_volume = trim($this->input->post('si_volume'));
		$si_type = trim($this->input->post('si_type'));
		$si_is_manufdate = trim($this->input->post('si_is_manufdate'));
		$si_category_id = trim($this->input->post('si_category_id'));
		$si_supplier_id = trim($this->input->post('si_supplier_id'));
		$si_image_type = trim($this->input->post('si_image_type'));
		//-----------------------------------------------------------------------------------------------//
		if(isset($_POST['si_image'])){//???
			$si_image = $_FILES['si_image'];
			$si_image_data_ext = $_FILES['si_image']['type'];
			$si_image_data_size = ($_FILES['si_image']['size'])/(1000*1000);//IN MEGABYTE(MB)
			
			$si_image_data_temp = $si_image['tmp_name'];
			$si_image = base64_encode(file_get_contents($si_image_data_temp,true));
			//-----------------------------------------------------------------------------------------------//
			if($si_image_data_size > 3){
				echo '
					<script>
						alert("IMAGE SIZE OVERSIZE : '.$si_image_data_size.' MB");
						window.location.href = "'.site_url('md_product').'";
					</script>
				';
				exit();
			}
			//-----------------------------------------------------------------------------------------------//
			$filter_image = array('image/jpeg','image/jpg','image/png');
			if(!in_array($si_image_data_ext,$filter_image,true)){
				echo '
					<script>
						alert("WRONG IMAGE FORMAT");
						window.location.href = "'.site_url('md_product').'";
					</script>
				';
				exit();
			}
		}else{
			$si_image = "";
		}
		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'PT_ID' => $si_id,
			'PT_NAME' => $si_name,
			'PT_UNIT' => $si_unit,
			'PT_UNIT_MAX' => $si_unit_max,
			'PT_UNIT_MAX_EXT' => $si_unit_max_ext,
			'PT_DIMENSION' => $si_dimension,
			'PT_WEIGHT' => $si_weight,
			'PT_VOLUME' => $si_volume,
			'PT_TYPE' => $si_type,
			'PT_IS_MANUFDATE' => $si_is_manufdate,
			'PTCY_ID' => $si_category_id,
			'SR_ID' => $si_supplier_id,
			'PT_IMAGE_TYPE' => $si_image_type,
			'PT_IMAGE' => $si_image
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_PRODUCT($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "INSERT PRODUCT",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("INSERT SUCCESS");
					window.location.href = "'.site_url('md_product').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("INSERT FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_product').'";
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
					window.location.href = "'.site_url('md_product').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$su_id = trim($this->input->post('su_id'));
		$su_name = trim($this->input->post('su_name'));
		$su_unit = trim($this->input->post('su_unit'));
		$su_unit_max = trim($this->input->post('su_unit_max'));
		$su_unit_max_ext = trim($this->input->post('su_unit_max_ext'));
		//-----------------------------------------------------------------------------------------------//
		$su_dimension_a = trim($this->input->post('su_dimension_a')).trim($this->input->post('su_dimension_type_a'));
		$su_dimension_b = trim($this->input->post('su_dimension_b')).trim($this->input->post('su_dimension_type_b'));
		$su_dimension_c = trim($this->input->post('su_dimension_c')).trim($this->input->post('su_dimension_type_c'));
		$su_dimension = $su_dimension_a." x ".$su_dimension_b." x ".$su_dimension_c;
		//-----------------------------------------------------------------------------------------------//
		$su_weight = trim($this->input->post('su_weight'));
		$su_volume = trim($this->input->post('su_volume'));
		$su_type = trim($this->input->post('su_type'));
		$su_is_manufdate = trim($this->input->post('su_is_manufdate'));
		$su_category_id = trim($this->input->post('su_category_id'));
		$su_supplier_id = trim($this->input->post('su_supplier_id'));
		$su_image_type = trim($this->input->post('su_image_type'));
		//-----------------------------------------------------------------------------------------------//
		if(isset($_POST['su_image'])){//???
			$su_image = $_FILES['su_image'];
			$su_image_data_ext = $_FILES['su_image']['type'];
			$su_image_data_size = ($_FILES['su_image']['size'])/(1000*1000);//IN MEGABYTE(MB)
			
			$su_image_data_temp = $su_image['tmp_name'];
			$su_image = base64_encode(file_get_contents($su_image_data_temp,true));
			//-----------------------------------------------------------------------------------------------//
			if($su_image_data_size > 3){
				echo '
					<script>
						alert("IMAGE SIZE OVERSIZE : '.$su_image_data_size.' MB");
						window.location.href = "'.site_url('md_product').'";
					</script>
				';
				exit();
			}
			//-----------------------------------------------------------------------------------------------//
			$filter_image = array('image/jpeg','image/jpg','image/png');
			if(!in_array($su_image_data_ext,$filter_image,true)){
				echo '
					<script>
						alert("WRONG IMAGE FORMAT");
						window.location.href = "'.site_url('md_product').'";
					</script>
				';
				exit();
			}
		}else{
			$su_image = $this->input->post('su_image_lastest');
		}
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'PT_ID' => $su_id,
			'PT_NAME' => $su_name,
			'PT_UNIT' => $su_unit,
			'PT_UNIT_MAX' => $su_unit_max,
			'PT_UNIT_MAX_EXT' => $su_unit_max_ext,
			'PT_DIMENSION' => $su_dimension,
			'PT_WEIGHT' => $su_weight,
			'PT_VOLUME' => $su_volume,
			'PT_TYPE' => $su_type,
			'PT_IS_MANUFDATE' => $su_is_manufdate,
			'PTCY_ID' => $su_category_id,
			'SR_ID' => $su_supplier_id,
			'PT_IMAGE_TYPE' => $su_image_type,
			'PT_IMAGE' => $su_image
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_PRODUCT($su_id,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "UPDATE PRODUCT",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("UPDATE SUCCESS");
					window.location.href = "'.site_url('md_product').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("UPDATE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_product').'";
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
					window.location.href = "'.site_url('md_product').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$sd_id = trim($this->input->post('sd_id'));
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_DELETE_DATA_PRODUCT($sd_id);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT LOG
			$data_log = array(
				'LG_ID' => $this->M_library_module->GENERATOR_REFF(),
				'UR_ID' => $this->session->userdata("session_mursmedic_id"),
				'LG_DESC' => "DELETE PRODUCT",
				'LG_DATE' => date('Y-m-d H:i:s')
			);
			$is_log = $this->M_library_database->DB_INSERT_DATA_LOG($data_log);
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("DELETE SUCCESS");
					window.location.href = "'.site_url('md_product').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("DELETE FAILED, PLEASE TRY AGAIN");
					window.location.href = "'.site_url('md_product').'";
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
