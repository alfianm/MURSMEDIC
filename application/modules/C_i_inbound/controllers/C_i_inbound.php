<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_i_inbound extends CI_Controller{
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
		$this->load->view('V_i_inbound');
	}

	function update()
	{
		$si_detail_id = $this->input->post("si_detail_id");
		$si_product_detail_id = $this->input->post("si_product_detail_id");
		$rack_id = $this->input->post("rack_id");
		$si_label = $this->input->post("si_label");
		$si_product_detail_rack = $this->input->post("si_product_detail_rack");
		$si_product_detail_name = $this->input->post("si_product_detail_name");
		$si_product_receive = $this->input->post("si_product_receive");
		$si_product_detail_qty_good = $this->input->post("si_product_detail_qty_good");
		$si_product_detail_no = $this->input->post("si_product_detail_no");
		$si_product_id = $this->input->post("si_product_id");

		$si_detail_id_lenght = count($si_detail_id);
		
		
		$data_update = array();
		for ($i=0; $i < $si_detail_id_lenght; $i++) { 
		
		if ($si_product_detail_no == "") {
			$barcode = substr($si_product_detail_id[$i], 0, 6) . "NONE" . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_product_receive[$i], 0, 6)) . rand(111, 999);
		} else {
			$barcode = substr($si_product_detail_id[$i], 0, 6) . substr($si_product_detail_no[$i], 0, 4) . date('Ymd') . $this->M_library_module->CLEAN_STRING(substr($si_product_receive[$i], 0, 6)) . rand(111, 999);
		}
		// print_r($barcode);
		$GENERATOR_LABEL = $si_product_detail_id[$i] . "[]" . $si_product_detail_name[$i] . "[]" . $rack_id[$i] . "[]" . $si_product_receive[$i] . "[]" . $si_product_detail_qty_good[$i] . "[]" . $barcode;
		// print_r($GENERATOR_LABEL);
		// echo "<br>";
		$data_update[] = array(
			'PTIDDL_ID' => $si_detail_id[$i],
			'RK_ID' => $rack_id[$i],
			'PTIDDL_LABEL' => $GENERATOR_LABEL
		);

		}
		// print_r($data_update);
		// die;
		$this->db->update_batch('tb_product_inbound_detail', $data_update, 'PTIDDL_ID');

		$this->load->view('V_i_inbound_print');
		// redirect('C_i_inbound','refresh');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
