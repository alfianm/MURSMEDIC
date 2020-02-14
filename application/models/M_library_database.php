<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') or exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class M_library_database extends CI_Model
{
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//private $tb_example = "tb_example";
	private $tb_distributor = "tb_distributor";
	private $tb_grant = "tb_grant";
	private $tb_log = "tb_log";
	private $tb_product = "tb_product";
	private $tb_product_category = "tb_product_category";
	private $tb_rack = "tb_rack";
	private $tb_supplier = "tb_supplier";
	private $tb_storage = "tb_storage";
	private $tb_user = "tb_user";
	private $tb_ekspedisi = "tb_ekspedisi";
	private $tb_forwarder = "tb_forwarder";

	private $tb_product_inbound = "tb_product_inbound";
	private $tb_product_inbound_detail = "tb_product_inbound_detail";
	private $tb_product_outbound = "tb_product_outbound";
	private $tb_product_outbound_detail = "tb_product_outbound_detail";
	private $tb_product_quarantine = "tb_product_quarantine";
	private $tb_product_sample = "tb_product_sample";
	private $tb_product_return = "tb_product_return";
	private $tb_product_stock = "tb_product_stock";
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//public function DB_GET_DATA_EXAMPLE_ARRAY($ID){
	//	$result = "";
	//	try{
	//		$this->db->select('*');
	//		$this->db->from($this->tb_example);
	//		$this->db->like('ID', $ID);
	//		$query = $this->db->get();
	//		if ($query->num_rows() > 0) {
	//			return $query->result();
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_EXAMPLE_ARRAY]".$error;
	//	}
	//	return $result;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_GET_DATA_EXAMPLE($ID){
	//	$result = "";
	//	try{
	//		$this->db->select('*');
	//		$this->db->from($this->tb_example);
	//		$this->db->where('ID', $ID);
	//		$this->db->limit(1);
	//		$query = $this->db->get();
	//		if ($query->num_rows() > 0) {
	//			return $query->result();
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_EXAMPLE]".$error;
	//	}
	//	return $result;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_INSERT_DATA_EXAMPLE($data){
	//	$status = false;
	//	try{
	//		$this->db->insert($this->tb_example, $data);
	//		if($this->db->affected_rows() == 1){
	//			$status = true;
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_EXAMPLE]".$error;
	//	}
	//	return $status;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_UPDATE_DATA_EXAMPLE($ID,$data){
	//	$status = false;
	//	try{
	//		$this->db->where('ID', $ID);
	//		$this->db->update($this->tb_example, $data);
	//		if($this->db->affected_rows() == 1){
	//			$status = true;
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_EXAMPLE]".$error;
	//	}
	//	return $status;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_DELETE_DATA_EXAMPLE($ID){
	//	$status = false;
	//	try{
	//		$this->db->where('ID', $ID);
	//		$this->db->delete($this->tb_example);
	//		if($this->db->affected_rows() == 1){
	//			$status = true;
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_EXAMPLE]".$error;
	//	}
	//	return $status;
	//}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//log
	// public function GET_PRODUK_BY_ID($id_key)
	// {
	// 	$this->db->select('*');
	// 	$this->db->where('PT_ID', $id_key);
	// 	$query = $this->db->get('tb_product');
	// 	return $query->result();
	// }
	public function DB_INSERT_DATA_LOG($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_log, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_LOG]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_LOG()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_log);
			$this->db->order_by('LG_DATE', 'desc');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_LOG]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_LOG($date_from, $date_to, $userid)
	{
		$result = "";
		try {
			$date_from = $date_from . " 00:00:00";
			$date_to = $date_to . " 23:59:59";

			$query = $this->db->query('
			SELECT * 
			FROM 
			tb_log 
			WHERE tb_log.LG_DATE >= "' . $date_from . '" 
			AND tb_log.LG_DATE <= "' . $date_to . '" 
			AND tb_log.UR_ID LIKE "%' . $userid . '%" 
			ORDER BY tb_log.LG_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_LOG]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_LOGIN($userid, $password)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_user);
			$this->db->where('UR_ID', $userid);
			$this->db->where('UR_PASSWORD', $password);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_LOGIN]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//grant
	public function DB_GET_DATA_ALL_GRANT()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_grant);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_GRANT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_GRANT_SINGLE($GT_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_grant);
			$this->db->where('GT_ID', $GT_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_GRANT_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_GRANT($GT_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_grant);
			$this->db->like('GT_ID', $GT_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_GRANT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_GRANT($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_grant, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_GRANT]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_GRANT($GT_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('GT_ID', $GT_ID);
			$this->db->update($this->tb_grant, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_GRANT]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_GRANT($GT_ID)
	{
		$status = false;
		try {
			$this->db->where('GT_ID', $GT_ID);
			$this->db->delete($this->tb_grant);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_GRANT]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//storage
	public function DB_GET_DATA_ALL_STORAGE()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_storage);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_STORAGE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_STORAGE_SINGLE($SE_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_storage);
			$this->db->where('SE_ID', $SE_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_STORAGE_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_STORAGE($SE_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_storage);
			$this->db->like('SE_ID', $SE_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_STORAGE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_STORAGE($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_storage, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_STORAGE]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_STORAGE($SE_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('SE_ID', $SE_ID);
			$this->db->update($this->tb_storage, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_STORAGE]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_STORAGE($SE_ID)
	{
		$status = false;
		try {
			$this->db->where('SE_ID', $SE_ID);
			$this->db->delete($this->tb_storage);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_STORAGE]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//product_category
	public function DB_GET_DATA_ALL_PRODUCT_CATEGORY()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_product_category);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_CATEGORY]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_CATEGORY_SINGLE($PTCY_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_product_category);
			$this->db->where('PTCY_ID', $PTCY_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_CATEGORY_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_PRODUCT_CATEGORY($PTCY_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_product_category);
			$this->db->like('PTCY_ID', $PTCY_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_PRODUCT_CATEGORY]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_PRODUCT_CATEGORY($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_category, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_CATEGORY]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_PRODUCT_CATEGORY($PTCY_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('PTCY_ID', $PTCY_ID);
			$this->db->update($this->tb_product_category, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_PRODUCT_CATEGORY]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_PRODUCT_CATEGORY($PTCY_ID)
	{
		$status = false;
		try {
			$this->db->where('PTCY_ID', $PTCY_ID);
			$this->db->delete($this->tb_product_category);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_PRODUCT_CATEGORY]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//rack
	public function DB_GET_DATA_ALL_RACK($SE_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->like('SE_ID', $SE_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_RACK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_RACK_SINGLE($RK_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->where('RK_ID', $RK_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_RACK_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_RACK($RK_ID, $RK_TYPE, $SE_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->like('RK_ID', $RK_ID);
			$this->db->like('RK_TYPE', $RK_TYPE);
			$this->db->like('SE_ID', $SE_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_RACK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_STARTING_RACK()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->order_by('RK_ID', 'ASC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_STARTING_RACK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_CONTINUE_RACK($RK_ID_NOT_IN)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->where_not_in('RK_ID', $RK_ID_NOT_IN);
			$this->db->order_by('RK_ID', 'ASC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_CONTINUE_RACK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_RACK($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_rack, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_RACK]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_RACK($RK_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('RK_ID', $RK_ID);
			$this->db->update($this->tb_rack, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_RACK]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_RACK($RK_ID)
	{
		$status = false;
		try {
			$this->db->where('RK_ID', $RK_ID);
			$this->db->delete($this->tb_rack);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_RACK]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//distributor
	public function DB_GET_DATA_ALL_DISTRIBUTOR()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_distributor);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_DISTRIBUTOR]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_DISTRIBUTOR_SINGLE($DR_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_distributor);
			$this->db->where('DR_ID', $DR_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_DISTRIBUTOR_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_DISTRIBUTOR($DR_ID, $DR_NAME)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_distributor);
			$this->db->like('DR_ID', $DR_ID);
			$this->db->like('DR_NAME', $DR_NAME);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_DISTRIBUTOR]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_DISTRIBUTOR_EXT($DR_ID, $DR_NAME, $DR_CITY)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_distributor);
			$this->db->like('DR_ID', $DR_ID);
			$this->db->like('DR_NAME', $DR_NAME);
			$this->db->like('DR_CITY', $DR_CITY);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_DISTRIBUTOR_EXT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_DISTRIBUTOR($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_distributor, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_DISTRIBUTOR]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_DISTRIBUTOR($DR_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('DR_ID', $DR_ID);
			$this->db->update($this->tb_distributor, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_DISTRIBUTOR]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_DISTRIBUTOR($DR_ID)
	{
		$status = false;
		try {
			$this->db->where('DR_ID', $DR_ID);
			$this->db->delete($this->tb_distributor);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_DISTRIBUTOR]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//ekspedisi
	public function DB_GET_DATA_ALL_EKSPEDISI()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_ekspedisi);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_EKSPEDISI]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_EKSPEDISI_SINGLE($EI_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_ekspedisi);
			$this->db->where('EI_ID', $EI_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_EKSPEDISI_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_EKSPEDISI($EI_ID, $EI_NAME)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_ekspedisi);
			$this->db->like('EI_ID', $EI_ID);
			$this->db->like('EI_NAME', $EI_NAME);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_EKSPEDISI]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_EKSPEDISI($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_ekspedisi, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_EKSPEDISI]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_EKSPEDISI($EI_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('EI_ID', $EI_ID);
			$this->db->update($this->tb_ekspedisi, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_EKSPEDISI]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_EKSPEDISI($EI_ID)
	{
		$status = false;
		try {
			$this->db->where('EI_ID', $EI_ID);
			$this->db->delete($this->tb_ekspedisi);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_EKSPEDISI]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//forwarder
	public function DB_GET_DATA_ALL_FORWARDER()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_forwarder);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_FORWARDER]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_FORWARDER_SINGLE($FR_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_forwarder);
			$this->db->where('FR_ID', $FR_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_FORWARDER_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_FORWARDER($FR_ID, $FR_NAME)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_forwarder);
			$this->db->like('FR_ID', $FR_ID);
			$this->db->like('FR_NAME', $FR_NAME);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_FORWARDER]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_FORWARDER($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_forwarder, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_FORWARDER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_FORWARDER($FR_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('FR_ID', $FR_ID);
			$this->db->update($this->tb_forwarder, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_FORWARDER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_FORWARDER($FR_ID)
	{
		$status = false;
		try {
			$this->db->where('FR_ID', $FR_ID);
			$this->db->delete($this->tb_forwarder);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_FORWARDER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//shipper
	public function DB_GET_DATA_ALL_SUPPLIER()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_supplier);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_SUPPLIER]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_SUPPLIER_SINGLE($SR_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_supplier);
			$this->db->where('SR_ID', $SR_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_SUPPLIER_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_SUPPLIER($SR_ID, $SR_NAME)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_supplier);
			$this->db->like('SR_ID', $SR_ID);
			$this->db->like('SR_NAME', $SR_NAME);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_SUPPLIER]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_SUPPLIER_EXT($SR_ID, $SR_NAME, $SR_COUNTRY)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_supplier);
			$this->db->like('SR_ID', $SR_ID);
			$this->db->like('SR_NAME', $SR_NAME);
			$this->db->like('SR_COUNTRY', $SR_COUNTRY);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_SUPPLIER_EXT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_SUPPLIER($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_supplier, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_SUPPLIER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_SUPPLIER($SR_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('SR_ID', $SR_ID);
			$this->db->update($this->tb_supplier, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_SUPPLIER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_SUPPLIER($SR_ID)
	{
		$status = false;
		try {
			$this->db->where('SR_ID', $SR_ID);
			$this->db->delete($this->tb_supplier);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_SUPPLIER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//user
	public function DB_GET_DATA_ALL_USER()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_user);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_USER]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_USER_SINGLE($UR_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_user);
			$this->db->where('UR_ID', $UR_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_USER_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_USER($UR_ID, $UR_NAME, $GT_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_user);
			$this->db->like('UR_ID', $UR_ID);
			$this->db->like('UR_NAME', $UR_NAME);
			$this->db->like('GT_ID', $GT_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_USER]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_USER($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_user, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_USER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_USER($UR_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('UR_ID', $UR_ID);
			$this->db->update($this->tb_user, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_USER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_USER($UR_ID)
	{
		$status = false;
		try {
			$this->db->where('UR_ID', $UR_ID);
			$this->db->delete($this->tb_user);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_USER]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//product
	public function DB_GET_DATA_ALL_PRODUCT()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product.PT_IMAGE_TYPE, 
			tb_product.PT_IMAGE 
			PT_IMAGE
			FROM 
			tb_product 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_SINGLE($PT_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product.PT_IMAGE_TYPE, 
			tb_product.PT_IMAGE 
			FROM 
			tb_product 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product.PT_ID = "' . $PT_ID . '" 
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_PRODUCT($PT_ID, $PT_NAME, $PTCY_ID, $SR_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product.PT_IMAGE_TYPE, 
			tb_product.PT_IMAGE 
			FROM 
			tb_product 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product.PT_ID LIKE "%' . $PT_ID . '%" 
			AND tb_product.PT_NAME LIKE "%' . $PT_NAME . '%" 
			AND tb_product.PTCY_ID LIKE "%' . $PTCY_ID . '%" 
			AND tb_product.SR_ID LIKE "%' . $SR_ID . '%"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_PRODUCT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_FOR_RACK($PT_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product.PT_IMAGE_TYPE, 
			tb_product.PT_IMAGE 
			FROM 
			tb_product 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product.PT_ID = "' . $PT_ID . '" 
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_FOR_RACK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_PRODUCT($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_PRODUCT($PT_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('PT_ID', $PT_ID);
			$this->db->update($this->tb_product, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_PRODUCT]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_PRODUCT($PT_ID)
	{
		$status = false;
		try {
			$this->db->where('PT_ID', $PT_ID);
			$this->db->delete($this->tb_product);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_PRODUCT]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//product_inbound
	public function DB_INSERT_DATA_PRODUCT_INBOUND($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_inbound, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_INBOUND]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_inbound_detail, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_PRODUCT_STOCK_EVO($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_stock, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_STOCK]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_INBOUND()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_inbound.PTID_ID, 
			tb_product_inbound.PTID_DATE, 
			tb_product_inbound.PTID_TGL_TERIMA, 
			tb_product_inbound.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound.PTID_PO_NO, 
			tb_product_inbound.PTID_PACKING_LIST_NO, 
			tb_product_inbound.PTID_PIB_NO, 
			tb_product_inbound.PTID_INVOICE_NO, 
			tb_product_inbound.FR_ID, 
			tb_forwarder.FR_NAME, 
			tb_forwarder.FR_PHONE, 
			tb_forwarder.FR_EMAIL, 
			tb_forwarder.FR_ADDRESS, 
			tb_product_inbound.PTID_CONTAINER_NO, 
			tb_product_inbound.PTID_CONTAINER_PLAT_NO, 
			tb_product_inbound.PTID_SEAL_NO, 
			tb_product_inbound.UR_ID, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_inbound.PTID_STATUS, 
			tb_product_inbound.PTID_APP_BY, 
			tb_product_inbound.PTID_QTY_TOTAL 
			FROM 
			tb_product_inbound 
			INNER JOIN tb_supplier ON tb_product_inbound.SR_ID = tb_supplier.SR_ID 
			INNER JOIN tb_forwarder ON tb_product_inbound.FR_ID = tb_forwarder.FR_ID 
			INNER JOIN tb_user ON tb_product_inbound.UR_ID = tb_user.UR_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_APPROVE()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_inbound.PTID_ID, 
			tb_product_inbound.PTID_DATE, 
			tb_product_inbound.PTID_TGL_TERIMA, 
			tb_product_inbound.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound.PTID_PO_NO, 
			tb_product_inbound.PTID_PACKING_LIST_NO, 
			tb_product_inbound.PTID_PIB_NO, 
			tb_product_inbound.PTID_INVOICE_NO, 
			tb_product_inbound.FR_ID, 
			tb_forwarder.FR_NAME, 
			tb_forwarder.FR_PHONE, 
			tb_forwarder.FR_EMAIL, 
			tb_forwarder.FR_ADDRESS, 
			tb_product_inbound.PTID_CONTAINER_PLAT_NO, 
			tb_product_inbound.PTID_SEAL_NO, 
			tb_product_inbound.UR_ID, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_inbound.PTID_STATUS, 
			tb_product_inbound.PTID_APP_BY, 
			tb_product_inbound.PTID_QTY_TOTAL 
			FROM 
			tb_product_inbound 
			INNER JOIN tb_supplier ON tb_product_inbound.SR_ID = tb_supplier.SR_ID 
			INNER JOIN tb_user ON tb_product_inbound.UR_ID = tb_user.UR_ID 
			INNER JOIN tb_forwarder ON tb_product_inbound.FR_ID = tb_forwarder.FR_ID 
			WHERE tb_product_inbound.PTID_STATUS = "WAITING"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_APPROVE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_APPROVE_SUMMARY()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_inbound.PTID_ID, 
			tb_product_inbound.PTID_DATE, 
			tb_product_inbound.PTID_TGL_TERIMA, 
			tb_product_inbound.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound.PTID_PO_NO, 
			tb_product_inbound.PTID_PACKING_LIST_NO, 
			tb_product_inbound.PTID_PIB_NO, 
			tb_product_inbound.PTID_INVOICE_NO, 
			tb_product_inbound.FR_ID, 
			tb_forwarder.FR_NAME, 
			tb_forwarder.FR_PHONE, 
			tb_forwarder.FR_EMAIL, 
			tb_forwarder.FR_ADDRESS, 
			tb_product_inbound.PTID_CONTAINER_PLAT_NO, 
			tb_product_inbound.PTID_SEAL_NO, 
			tb_product_inbound.UR_ID, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_inbound.PTID_STATUS, 
			tb_product_inbound.PTID_APP_BY, 
			tb_product_inbound.PTID_QTY_TOTAL 
			FROM 
			tb_product_inbound 
			INNER JOIN tb_supplier ON tb_product_inbound.SR_ID = tb_supplier.SR_ID 
			INNER JOIN tb_user ON tb_product_inbound.UR_ID = tb_user.UR_ID 
			INNER JOIN tb_forwarder ON tb_product_inbound.FR_ID = tb_forwarder.FR_ID 
			WHERE tb_product_inbound.PTID_STATUS = "APPROVE"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_APPROVE_SUMMARY]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_SINGLE($PTID_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_inbound.PTID_ID, 
			tb_product_inbound.PTID_DATE, 
			tb_product_inbound.PTID_TGL_TERIMA, 
			tb_product_inbound.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound.PTID_PO_NO, 
			tb_product_inbound.PTID_PACKING_LIST_NO, 
			tb_product_inbound.PTID_PIB_NO, 
			tb_product_inbound.PTID_INVOICE_NO, 
			tb_product_inbound.FR_ID, 
			tb_forwarder.FR_NAME, 
			tb_forwarder.FR_PHONE, 
			tb_forwarder.FR_EMAIL, 
			tb_forwarder.FR_ADDRESS, 
			tb_product_inbound.PTID_CONTAINER_NO, 
			tb_product_inbound.PTID_CONTAINER_PLAT_NO, 
			tb_product_inbound.PTID_SEAL_NO, 
			tb_product_inbound.UR_ID,  
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_inbound.PTID_STATUS, 
			tb_product_inbound.PTID_APP_BY, 
			tb_product_inbound.PTID_QTY_TOTAL
			FROM 
			tb_product_inbound 
			INNER JOIN tb_supplier ON tb_product_inbound.SR_ID = tb_supplier.SR_ID 
			INNER JOIN tb_user ON tb_product_inbound.UR_ID = tb_user.UR_ID 
			INNER JOIN tb_forwarder ON tb_product_inbound.FR_ID = tb_forwarder.FR_ID 
			WHERE tb_product_inbound.PTID_ID = "' . $PTID_ID . '" 
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL_BY_PRODUCT($PTID_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT
			tb_product_inbound_detail.PTIDDL_ID, 
			tb_product_inbound_detail.PTIDDL_DATE, 
			tb_product_inbound_detail.PTID_ID, 
			tb_product_inbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_product.SE_ID,
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound_detail.RK_ID, 
			tb_product_inbound_detail.PTIDDL_LABEL, 
			tb_product_inbound_detail.PTIDDL_NO, 
			tb_product_inbound_detail.PTIDDL_MANUFDATE, 
			tb_product_inbound_detail.PTIDDL_EXPIRED, 
			tb_product_inbound_detail.PTIDDL_QTY, 
			tb_product_inbound_detail.PTIDDL_QTY_GOOD, 
			tb_product_inbound_detail.PTIDDL_QTY_BAD 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product ON tb_product_inbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product_inbound_detail.PTID_ID = "' . $PTID_ID . '"
			ORDER BY tb_product_inbound_detail.RK_ID ASC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL_BY_PRODUCT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT
			tb_product_inbound_detail.PTIDDL_ID, 
			tb_product_inbound_detail.PTIDDL_DATE, 
			tb_product_inbound_detail.PTID_ID, 
			tb_product_inbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound_detail.RK_ID, 
			tb_product_inbound_detail.PTIDDL_LABEL, 
			tb_product_inbound_detail.PTIDDL_NO, 
			tb_product_inbound_detail.PTIDDL_MANUFDATE, 
			tb_product_inbound_detail.PTIDDL_EXPIRED, 
			tb_product_inbound_detail.PTIDDL_QTY, 
			tb_product_inbound_detail.PTIDDL_QTY_GOOD, 
			tb_product_inbound_detail.PTIDDL_QTY_BAD 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product ON tb_product_inbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL_SINGLE($PTIDDL_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT
			tb_product_inbound_detail.PTIDDL_ID, 
			tb_product_inbound_detail.PTIDDL_DATE, 
			tb_product_inbound_detail.PTID_ID, 
			tb_product_inbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound_detail.RK_ID, 
			tb_product_inbound_detail.PTIDDL_LABEL, 
			tb_product_inbound_detail.PTIDDL_NO, 
			tb_product_inbound_detail.PTIDDL_MANUFDATE, 
			tb_product_inbound_detail.PTIDDL_EXPIRED, 
			tb_product_inbound_detail.PTIDDL_QTY, 
			tb_product_inbound_detail.PTIDDL_QTY_GOOD, 
			tb_product_inbound_detail.PTIDDL_QTY_BAD 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product ON tb_product_inbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product_inbound_detail.PTIDDL_ID = "' . $PTIDDL_ID . '" 
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_PRODUCT_INBOUND($PTID_ID)
	{
		$status = false;
		try {
			$this->db->where('PTID_ID', $PTID_ID);
			$this->db->delete($this->tb_product_inbound);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_PRODUCT_INBOUND]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_PRODUCT_INBOUND($PTID_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('PTID_ID', $PTID_ID);
			$this->db->update($this->tb_product_inbound, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_PRODUCT_INBOUND]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_PRODUCT_INBOUND_DETAIL($PTIDDL_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('PTIDDL_ID', $PTIDDL_ID);
			$this->db->update($this->tb_product_inbound_detail, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_PRODUCT_INBOUND_DETAIL]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_CHECK_RACK_INBOUND()
	{
		$result = "";
		try {
			$this->db->select('RK_ID');
			$this->db->from($this->tb_product_inbound_detail);
			$this->db->where('RK_ID !=', '');
			$this->db->group_by('RK_ID');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_INBOUND]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_RACK_INBOUND()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			RK_ID, 
			SUM(PTIDDL_QTY_GOOD) AS RK_TOTAL 
			FROM 
			tb_product_inbound_detail 
			WHERE RK_ID != "" 
			GROUP BY RK_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_RACK_INBOUND]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//product_OUTBOUND
	public function DB_INSERT_DATA_PRODUCT_OUTBOUND($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_outbound, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_OUTBOUND]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_PRODUCT_OUTBOUND_DETAIL($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_outbound_detail, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_OUTBOUND_DETAIL]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_OUTBOUND()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_outbound.PTOD_ID, 
			tb_product_outbound.PTOD_DATE, 
			tb_product_outbound.PTOD_TGL_KIRIM, 
			tb_product_outbound.PTOD_DO_NO, 
			tb_product_outbound.PTOD_ORDER_NO, 
			tb_product_outbound.DR_ID, 
			tb_distributor.DR_NAME, 
			tb_distributor.DR_PHONE, 
			tb_distributor.DR_EMAIL, 
			tb_distributor.DR_ADDRESS, 
			tb_distributor.DR_ADDRESS_SHIPPING, 
			tb_distributor.DR_CITY, 
			tb_product_outbound.PTOD_TRUCK_TYPE, 
			tb_product_outbound.PTOD_TRUCK_NO, 
			tb_product_outbound.PTOD_DRIVER, 
			tb_product_outbound.EI_ID, 
			tb_ekspedisi.EI_NAME, 
			tb_ekspedisi.EI_PHONE, 
			tb_ekspedisi.EI_EMAIL, 
			tb_ekspedisi.EI_ADDRESS, 
			tb_product_outbound.PTOD_SEAL_NO, 
			tb_product_outbound.UR_ID, 
			tb_user.UR_PASSWORD, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_outbound.PTOD_STATUS, 
			tb_product_outbound.PTOD_APP_BY, 
			tb_product_outbound.PTOD_QTY_TOTAL 
			FROM 
			tb_product_outbound 
			INNER JOIN tb_distributor ON tb_product_outbound.DR_ID = tb_distributor.DR_ID 
			INNER JOIN tb_ekspedisi ON tb_product_outbound.EI_ID = tb_ekspedisi.EI_ID 
			INNER JOIN tb_user ON tb_product_outbound.UR_ID = tb_user.UR_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_OUTBOUND]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_OUTBOUND_APPROVE()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_outbound.PTOD_ID, 
			tb_product_outbound.PTOD_DATE, 
			tb_product_outbound.PTOD_TGL_KIRIM, 
			tb_product_outbound.PTOD_DO_NO, 
			tb_product_outbound.PTOD_ORDER_NO, 
			tb_product_outbound.DR_ID, 
			tb_distributor.DR_NAME, 
			tb_distributor.DR_PHONE, 
			tb_distributor.DR_EMAIL, 
			tb_distributor.DR_ADDRESS, 
			tb_distributor.DR_ADDRESS_SHIPPING, 
			tb_distributor.DR_CITY, 
			tb_product_outbound.PTOD_TRUCK_TYPE, 
			tb_product_outbound.PTOD_TRUCK_NO, 
			tb_product_outbound.PTOD_DRIVER, 
			tb_product_outbound.EI_ID, 
			tb_ekspedisi.EI_NAME, 
			tb_ekspedisi.EI_PHONE, 
			tb_ekspedisi.EI_EMAIL, 
			tb_ekspedisi.EI_ADDRESS, 
			tb_product_outbound.PTOD_SEAL_NO, 
			tb_product_outbound.UR_ID, 
			tb_user.UR_PASSWORD, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_outbound.PTOD_STATUS, 
			tb_product_outbound.PTOD_APP_BY, 
			tb_product_outbound.PTOD_QTY_TOTAL 
			FROM 
			tb_product_outbound 
			INNER JOIN tb_distributor ON tb_product_outbound.DR_ID = tb_distributor.DR_ID 
			INNER JOIN tb_ekspedisi ON tb_product_outbound.EI_ID = tb_ekspedisi.EI_ID 
			INNER JOIN tb_user ON tb_product_outbound.UR_ID = tb_user.UR_ID 
			WHERE tb_product_outbound.PTOD_STATUS = "WAITING"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_OUTBOUND_APPROVE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_OUTBOUND_APPROVE_SUMMARY()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_outbound.PTOD_ID, 
			tb_product_outbound.PTOD_DATE, 
			tb_product_outbound.PTOD_TGL_KIRIM, 
			tb_product_outbound.PTOD_DO_NO, 
			tb_product_outbound.PTOD_ORDER_NO, 
			tb_product_outbound.DR_ID, 
			tb_distributor.DR_NAME, 
			tb_distributor.DR_PHONE, 
			tb_distributor.DR_EMAIL, 
			tb_distributor.DR_ADDRESS, 
			tb_distributor.DR_ADDRESS_SHIPPING, 
			tb_distributor.DR_CITY, 
			tb_product_outbound.PTOD_TRUCK_TYPE, 
			tb_product_outbound.PTOD_TRUCK_NO, 
			tb_product_outbound.PTOD_DRIVER, 
			tb_product_outbound.EI_ID, 
			tb_ekspedisi.EI_NAME, 
			tb_ekspedisi.EI_PHONE, 
			tb_ekspedisi.EI_EMAIL, 
			tb_ekspedisi.EI_ADDRESS, 
			tb_product_outbound.PTOD_SEAL_NO, 
			tb_product_outbound.UR_ID, 
			tb_user.UR_PASSWORD, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_outbound.PTOD_STATUS, 
			tb_product_outbound.PTOD_APP_BY, 
			tb_product_outbound.PTOD_QTY_TOTAL,
			tb_product_outbound.UPLOAD_DN 
			FROM 
			tb_product_outbound 
			INNER JOIN tb_distributor ON tb_product_outbound.DR_ID = tb_distributor.DR_ID 
			INNER JOIN tb_ekspedisi ON tb_product_outbound.EI_ID = tb_ekspedisi.EI_ID 
			INNER JOIN tb_user ON tb_product_outbound.UR_ID = tb_user.UR_ID 
			WHERE tb_product_outbound.PTOD_STATUS = "APPROVE"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_OUTBOUND_APPROVE_SUMMARY]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_OUTBOUND_SINGLE($PTOD_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_outbound.PTOD_ID, 
			tb_product_outbound.PTOD_DATE, 
			tb_product_outbound.PTOD_TGL_KIRIM, 
			tb_product_outbound.PTOD_DO_NO, 
			tb_product_outbound.PTOD_ORDER_NO, 
			tb_product_outbound.DR_ID, 
			tb_distributor.DR_NAME, 
			tb_distributor.DR_PHONE, 
			tb_distributor.DR_EMAIL, 
			tb_distributor.DR_ADDRESS, 
			tb_distributor.DR_ADDRESS_SHIPPING, 
			tb_distributor.DR_CITY, 
			tb_product_outbound.PTOD_TRUCK_TYPE, 
			tb_product_outbound.PTOD_TRUCK_NO, 
			tb_product_outbound.PTOD_DRIVER, 
			tb_product_outbound.EI_ID, 
			tb_ekspedisi.EI_NAME, 
			tb_ekspedisi.EI_PHONE, 
			tb_ekspedisi.EI_EMAIL, 
			tb_ekspedisi.EI_ADDRESS, 
			tb_product_outbound.PTOD_SEAL_NO, 
			tb_product_outbound.UR_ID, 
			tb_user.UR_PASSWORD, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_outbound.PTOD_STATUS, 
			tb_product_outbound.PTOD_APP_BY, 
			tb_product_outbound.PTOD_QTY_TOTAL 
			FROM 
			tb_product_outbound 
			INNER JOIN tb_distributor ON tb_product_outbound.DR_ID = tb_distributor.DR_ID 
			INNER JOIN tb_ekspedisi ON tb_product_outbound.EI_ID = tb_ekspedisi.EI_ID 
			INNER JOIN tb_user ON tb_product_outbound.UR_ID = tb_user.UR_ID 
			WHERE tb_product_outbound.PTOD_ID = "' . $PTOD_ID . '" 
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_OUTBOUND_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_OUTBOUND_DETAIL_BY_PRODUCT($PTOD_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT
			tb_product_outbound_detail.PTODDL_ID, 
			tb_product_outbound_detail.PTIDDL_ID, 
			tb_product_outbound_detail.PTODDL_DATE, 
			tb_product_outbound_detail.PTOD_ID, 
			tb_product_outbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_outbound_detail.RK_ID, 
			tb_product_outbound_detail.PTODDL_LABEL, 
			tb_product_outbound_detail.PTODDL_NO, 
			tb_product_outbound_detail.PTODDL_MANUFDATE, 
			tb_product_outbound_detail.PTODDL_EXPIRED, 
			tb_product_outbound_detail.PTODDL_QTY, 
			tb_product_outbound_detail.PTODDL_STOCK_INBOUND, 
			tb_product_outbound_detail.PTODDL_QTY_GOOD, 
			tb_product_outbound_detail.PTODDL_QTY_BAD 
			FROM 
			tb_product_outbound_detail 
			INNER JOIN tb_product ON tb_product_outbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product_outbound_detail.PTOD_ID = "' . $PTOD_ID . '"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_OUTBOUND_DETAIL_BY_PRODUCT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_OUTBOUND_DETAIL()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT
			tb_product_outbound_detail.PTODDL_ID, 
			tb_product_outbound_detail.PTODDL_DATE, 
			tb_product_outbound_detail.PTOD_ID, 
			tb_product_outbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_outbound_detail.RK_ID, 
			tb_product_outbound_detail.PTODDL_LABEL, 
			tb_product_outbound_detail.PTODDL_NO, 
			tb_product_outbound_detail.PTODDL_MANUFDATE, 
			tb_product_outbound_detail.PTODDL_EXPIRED, 
			tb_product_outbound_detail.PTODDL_QTY, 
			tb_product_outbound_detail.PTODDL_QTY_GOOD, 
			tb_product_outbound_detail.PTODDL_QTY_BAD 
			FROM 
			tb_product_outbound_detail 
			INNER JOIN tb_product ON tb_product_outbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_OUTBOUND_DETAIL]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_OUTBOUND_DETAIL_SINGLE($PTODDL_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT
			tb_product_outbound_detail.PTODDL_ID, 
			tb_product_outbound_detail.PTODDL_DATE, 
			tb_product_outbound_detail.PTOD_ID, 
			tb_product_outbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_outbound_detail.RK_ID, 
			tb_product_outbound_detail.PTODDL_LABEL, 
			tb_product_outbound_detail.PTODDL_NO, 
			tb_product_outbound_detail.PTODDL_MANUFDATE, 
			tb_product_outbound_detail.PTODDL_EXPIRED, 
			tb_product_outbound_detail.PTODDL_QTY, 
			tb_product_outbound_detail.PTODDL_QTY_GOOD, 
			tb_product_outbound_detail.PTODDL_QTY_BAD 
			FROM 
			tb_product_outbound_detail 
			INNER JOIN tb_product ON tb_product_outbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product_outbound_detail.PTODDL_ID = "' . $PTODDL_ID . '" 
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_OUTBOUND_DETAIL_SINGLE]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_PRODUCT_OUTBOUND($PTOD_ID)
	{
		$status = false;
		try {
			$this->db->where('PTOD_ID', $PTOD_ID);
			$this->db->delete($this->tb_product_outbound);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_PRODUCT_OUTBOUND]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_PRODUCT_OUTBOUND_DETAIL($PTODDL_ID)
	{
		$status = false;
		try {
			$this->db->where('PTODDL_ID', $PTODDL_ID);
			$this->db->delete($this->tb_product_outbound_detail);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_PRODUCT_OUTBOUND_DETAIL]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_PRODUCT_OUTBOUND($PTOD_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('PTOD_ID', $PTOD_ID);
			$this->db->update($this->tb_product_outbound, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_PRODUCT_OUTBOUND]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_PRODUCT_OUTBOUND_DETAIL($PTODDL_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('PTODDL_ID', $PTODDL_ID);
			$this->db->update($this->tb_product_outbound_detail, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_PRODUCT_OUTBOUND_DETAIL]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_CHECK_RACK_OUTBOUND()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			RK_ID 
			FROM 
			tb_product_outbound_detail 
			WHERE RK_ID != "" 
			GROUP BY RK_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_OUTBOUND]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_RACK_OUTBOUND()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			RK_ID, 
			SUM(PTODDL_QTY_GOOD) AS RK_TOTAL 
			FROM 
			tb_product_outbound_detail 
			WHERE RK_ID != "" 
			GROUP BY RK_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_OUTBOUND]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_STOCK(){
		$result = "";
		try{
			$query = $this->db->query('
			SELECT 
			tb_product_inbound_detail.PTIDDL_ID, 
			tb_product_inbound_detail.PTIDDL_DATE, 
			tb_product_inbound_detail.PTID_ID, 
			tb_product_inbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_product_inbound_detail.RK_ID, 
			tb_rack.RK_TYPE, 
			tb_rack.RK_SUBRACK, 
			tb_rack.RK_LEVEL, 
			tb_rack.SE_ID, 
			tb_product_inbound_detail.PTIDDL_LABEL, 
			tb_product_inbound_detail.PTIDDL_NO, 
			tb_product_inbound_detail.PTIDDL_MANUFDATE, 
			SUM(tb_product_inbound_detail.PTIDDL_QTY) AS TOTAL, 
			SUM(tb_product_inbound_detail.PTIDDL_QTY_GOOD) AS TOTAL_GOOD, 
			SUM(tb_product_inbound_detail.PTIDDL_QTY_BAD) AS TOTAL_BAD 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product ON tb_product_inbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_rack ON tb_product_inbound_detail.RK_ID = tb_rack.RK_ID 
			GROUP BY tb_product_inbound_detail.PT_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_STOCK]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_PRODUCT_STOCK_SINGLE($PT_ID){
		$result = "";
		try{
			$query = $this->db->query('
			SELECT 
			tb_product_inbound_detail.PTIDDL_ID, 
			tb_product_inbound_detail.PTIDDL_DATE, 
			tb_product_inbound_detail.PTID_ID, 
			tb_product_inbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_product_inbound_detail.RK_ID, 
			tb_rack.RK_TYPE, 
			tb_rack.RK_SUBRACK, 
			tb_rack.RK_LEVEL, 
			tb_rack.SE_ID, 
			tb_product_inbound_detail.PTIDDL_LABEL, 
			tb_product_inbound_detail.PTIDDL_NO, 
			tb_product_inbound_detail.PTIDDL_MANUFDATE, 
			tb_product_inbound_detail.PTIDDL_EXPIRED, 
			tb_product_inbound_detail.PTIDDL_QTY, 
			tb_product_inbound_detail.PTIDDL_QTY_GOOD, 
			tb_product_inbound_detail.PTIDDL_QTY_BAD 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product ON tb_product_inbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_rack ON tb_product_inbound_detail.RK_ID = tb_rack.RK_ID 
			WHERE tb_product_inbound_detail.PT_ID = "'.$PT_ID.'" 
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_STOCK_SINGLE]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_PRODUCT_STOCK($PT_ID, $PTCY_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY 
			FROM 
			tb_product 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product.PT_ID LIKE "%' . $PT_ID . '%" 
			AND tb_product.PTCY_ID LIKE "%' . $PTCY_ID . '%"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_PRODUCT_STOCK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_DETAIL_PRODUCT_STOCK($PT_ID){
		$result = "";
		try{
			$query = $this->db->query('
			SELECT 
			PROCESS_STOCK.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			SUM(PROCESS_STOCK.STOCK_QTY) AS STOCK 
			FROM ( 
			SELECT 
			tb_product_inbound_detail.PT_ID, 
			tb_product_inbound_detail.PTIDDL_QTY_GOOD AS STOCK_QTY 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product_inbound ON tb_product_inbound_detail.PTID_ID = tb_product_inbound.PTID_ID 
			WHERE tb_product_inbound.PTID_STATUS = "APPROVE" 
			AND tb_product_inbound_detail.PT_ID = "'.$PT_ID.'"
			
			UNION ALL 
			
			SELECT 
			tb_product_outbound_detail.PT_ID, 
			-tb_product_outbound_detail.PTODDL_QTY_GOOD AS STOCK_QTY 
			FROM 
			tb_product_outbound_detail 
			INNER JOIN tb_product_outbound ON tb_product_outbound_detail.PTOD_ID = tb_product_outbound.PTOD_ID 
			WHERE tb_product_outbound.PTOD_STATUS = "APPROVE" 
			AND tb_product_outbound_detail.PT_ID = "'.$PT_ID.'"
			) AS PROCESS_STOCK 
			INNER JOIN tb_product ON PROCESS_STOCK.PT_ID = tb_product.PT_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_DETAIL_PRODUCT_STOCK]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_RACK_STOCK($RK_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->like('RK_ID', $RK_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_RACK_STOCK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_DETAIL_RACK_STOCK($RK_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			PROCESS_STOCK.RK_ID, 
			PROCESS_STOCK.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			SUM(PROCESS_STOCK.STOCK_QTY) AS STOCK 
			FROM ( 
			SELECT 
			tb_product_inbound_detail.RK_ID, 
			tb_product_inbound_detail.PT_ID, 
			tb_product_inbound_detail.PTIDDL_QTY_GOOD AS STOCK_QTY 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product_inbound ON tb_product_inbound_detail.PTID_ID = tb_product_inbound.PTID_ID 
			WHERE tb_product_inbound.PTID_STATUS = "APPROVE" 
			AND tb_product_inbound_detail.RK_ID = "' . $RK_ID . '"
			
			UNION ALL 
			
			SELECT 
			tb_product_outbound_detail.RK_ID, 
			tb_product_outbound_detail.PT_ID, 
			-tb_product_outbound_detail.PTODDL_QTY_GOOD AS STOCK_QTY 
			FROM 
			tb_product_outbound_detail 
			INNER JOIN tb_product_outbound ON tb_product_outbound_detail.PTOD_ID = tb_product_outbound.PTOD_ID 
			WHERE tb_product_outbound.PTOD_STATUS = "APPROVE" 
			AND tb_product_outbound_detail.RK_ID = "' . $RK_ID . '"
			) AS PROCESS_STOCK 
			INNER JOIN tb_product ON PROCESS_STOCK.PT_ID = tb_product.PT_ID
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_DETAIL_RACK_STOCK]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_INBOUND_REPORT()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_inbound.PTID_ID, 
			tb_product_inbound.PTID_DATE, 
			tb_product_inbound.PTID_TGL_TERIMA, 
			tb_product_inbound.SR_ID, 
			tb_product_inbound.PTID_PO_NO, 
			tb_product_inbound.PTID_PACKING_LIST_NO, 
			tb_product_inbound.PTID_PIB_NO, 
			tb_product_inbound.PTID_INVOICE_NO, 
			tb_product_inbound.FR_ID, 
			tb_product_inbound.PTID_CONTAINER_NO, 
			tb_product_inbound.PTID_CONTAINER_PLAT_NO, 
			tb_product_inbound.PTID_SEAL_NO, 
			tb_product_inbound.UR_ID, 
			tb_product_inbound.PTID_STATUS, 
			tb_product_inbound.PTID_APP_BY, 
			tb_product_inbound.PTID_QTY_TOTAL 
			FROM 
			tb_product_inbound 
			ORDER BY tb_product_inbound.PTID_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_INBOUND_REPORT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_DETAIL_INBOUND_REPORT($SDATEF, $SDATET, $PTID_ID)
	{
		$result = "";
		try {
			$date_from = $SDATEF . " 00:00:00";
			$date_to = $SDATET . " 23:59:59";

			$query = $this->db->query('
			SELECT 
			tb_product_inbound.PTID_ID, 
			tb_product_inbound.PTID_DATE, 
			tb_product_inbound.PTID_TGL_TERIMA, 
			tb_product_inbound.SR_ID, 
			tb_product_inbound.PTID_PO_NO, 
			tb_product_inbound.PTID_PACKING_LIST_NO, 
			tb_product_inbound.PTID_PIB_NO, 
			tb_product_inbound.PTID_INVOICE_NO, 
			tb_product_inbound.FR_ID, 
			tb_product_inbound.PTID_CONTAINER_NO, 
			tb_product_inbound.PTID_CONTAINER_PLAT_NO, 
			tb_product_inbound.PTID_SEAL_NO, 
			tb_product_inbound.UR_ID, 
			tb_product_inbound.PTID_STATUS, 
			tb_product_inbound.PTID_APP_BY, 
			tb_product_inbound.PTID_QTY_TOTAL 
			FROM 
			tb_product_inbound 
			WHERE tb_product_inbound.PTID_DATE >= "' . $date_from . '" 
			AND tb_product_inbound.PTID_DATE <= "' . $date_to . '" 
			AND tb_product_inbound.PTID_ID LIKE "%' . $PTID_ID . '%" 
			ORDER BY tb_product_inbound.PTID_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_DETAIL_INBOUND_REPORT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_OUTBOUND_REPORT()
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_outbound.PTOD_ID, 
			tb_product_outbound.PTOD_DATE, 
			tb_product_outbound.PTOD_TGL_KIRIM, 
			tb_product_outbound.PTOD_DO_NO, 
			tb_product_outbound.PTOD_ORDER_NO, 
			tb_product_outbound.DR_ID, 
			tb_product_outbound.PTOD_TRUCK_TYPE, 
			tb_product_outbound.PTOD_TRUCK_NO, 
			tb_product_outbound.PTOD_DRIVER, 
			tb_product_outbound.EI_ID, 
			tb_product_outbound.PTOD_SEAL_NO, 
			tb_product_outbound.UR_ID, 
			tb_product_outbound.PTOD_STATUS, 
			tb_product_outbound.PTOD_APP_BY, 
			tb_product_outbound.PTOD_QTY_TOTAL 
			FROM 
			tb_product_outbound 
			ORDER BY tb_product_outbound.PTOD_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_OUTBOUND_REPORT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_DETAIL_OUTBOUND_REPORT($SDATEF, $SDATET, $PTOD_ID)
	{
		$result = "";
		try {
			$date_from = $SDATEF . " 00:00:00";
			$date_to = $SDATET . " 23:59:59";

			$query = $this->db->query('
			SELECT 
			tb_product_outbound.PTOD_ID, 
			tb_product_outbound.PTOD_DATE, 
			tb_product_outbound.PTOD_TGL_KIRIM, 
			tb_product_outbound.PTOD_DO_NO, 
			tb_product_outbound.PTOD_ORDER_NO, 
			tb_product_outbound.DR_ID, 
			tb_product_outbound.PTOD_TRUCK_TYPE, 
			tb_product_outbound.PTOD_TRUCK_NO, 
			tb_product_outbound.PTOD_DRIVER, 
			tb_product_outbound.EI_ID, 
			tb_product_outbound.PTOD_SEAL_NO, 
			tb_product_outbound.UR_ID, 
			tb_product_outbound.PTOD_STATUS, 
			tb_product_outbound.PTOD_APP_BY, 
			tb_product_outbound.PTOD_QTY_TOTAL 
			FROM 
			tb_product_outbound 
			WHERE tb_product_outbound.PTOD_DATE >= "' . $date_from . '" 
			AND tb_product_outbound.PTOD_DATE <= "' . $date_to . '" 
			AND tb_product_outbound.PTOD_ID LIKE "%' . $PTOD_ID . '%" 
			ORDER BY tb_product_outbound.PTOD_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_DETAIL_OUTBOUND_REPORT]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_CHECK_RACK_INBOUND_DETAIL_EVO($RK_ID)
	{
		$result = "";
		try {
			$this->db->select('RK_ID');
			$this->db->from($this->tb_product_inbound_detail);
			$this->db->where('RK_ID', $RK_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_INBOUND_DETAIL_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_CHECK_RACK_OUTBOUND_DETAIL_EVO($RK_ID)
	{
		$result = "";
		try {
			$this->db->select('RK_ID');
			$this->db->from($this->tb_product_outbound_detail);
			$this->db->where('RK_ID', $RK_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_OUTBOUND_DETAIL_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_SEARCH_PRODUCT_FOR_RACK_EVO($PT_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_product.SE_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product.PT_IMAGE_TYPE, 
			tb_product.PT_IMAGE 
			FROM 
			tb_product 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product.PT_ID = "' . $PT_ID . '" 
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_PRODUCT_FOR_RACK_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_PRODUCT_INBOUND_DETAIL_EVO($PTIDDL_ID)
	{
		$status = false;
		try {
			$this->db->where('PTIDDL_ID', $PTIDDL_ID);
			$this->db->delete($this->tb_product_inbound_detail);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_PRODUCT_INBOUND_DETAIL_EVO]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_inbound_detail, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_INBOUND_DETAIL_EVO]" . $error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_PRODUCT_INBOUND_DETAIL_SINGLE_EVO($PTIDDL_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_product_inbound_detail);
			$this->db->where('PTIDDL_ID', $PTIDDL_ID);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_PRODUCT_INBOUND_DETAIL_SINGLE_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_PRODUCT_INBOUND_DETAIL_SINGLE_EVO_BAD($PTIDDL_ID_BAD)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_product_inbound_detail);
			$this->db->where('PTIDDL_ID', $PTIDDL_ID_BAD);
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_PRODUCT_INBOUND_DETAIL_SINGLE_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ALL_RACK_DRIVE_IN_EVO($RK_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->like('RK_ID', $RK_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_RACK_DRIVE_IN_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_CHECK_RACK_INBOUND_DETAIL_DRIVE_IN_EVO($SE_ID)
	{
		$result = "";
		try {
			$this->db->select('SE_ID');
			$this->db->from($this->tb_product_inbound_detail);
			$this->db->like('SE_ID', $SE_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_INBOUND_DETAIL_DRIVE_IN_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_CHECK_RACK_OUTBOUND_DETAIL_DRIVE_IN_EVO($SE_ID)
	{
		$result = "";
		try {
			$this->db->select('SE_ID');
			$this->db->from($this->tb_product_outbound_detail);
			$this->db->like('SE_ID', $SE_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_OUTBOUND_DETAIL_DRIVE_IN_EVO]" . $error;
		}
		return $result;
	}


	public function DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_1()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->where('RK_TYPE', 'SINGLE');
			$this->db->where('RK_LEVEL', '1');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_1]" . $error;
		}
		return $result;
	}
	public function DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_2()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->where('RK_TYPE', 'SINGLE');
			$this->db->where('RK_LEVEL', '2');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_2]" . $error;
		}
		return $result;
	}
	public function DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_3()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->where('RK_TYPE', 'DRIVE IN');
			$this->db->where('RK_LEVEL', '1');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_3]" . $error;
		}
		return $result;
	}
	public function DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_4()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->where('RK_TYPE', 'DRIVE IN');
			$this->db->where('RK_LEVEL', '2');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_RACK_WHERE_TYPE_LEVEL_4]" . $error;
		}
		return $result;
	}

	public function DB_CHECK_RACK_QUARANTINE_DRIVE_IN_EVO($RK_ID)
	{
		$result = "";
		try {
			$this->db->select('RK_ID');
			$this->db->from($this->tb_product_quarantine);
			$this->db->like('RK_ID', $RK_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_QUARANTINE_DRIVE_IN_EVO]" . $error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_RACK_WHERE_QUARANTINE()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			$this->db->where('RK_TYPE', 'SINGLE');
			$this->db->where('RK_LEVEL', '1');
			$this->db->where('SE_ID', 'QUARANTINE');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_RACK_WHERE_QUARANTINE]" . $error;
		}
		return $result;
	}

	public function DB_INSERT_DATA_PRODUCT_QUARANTINE($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_quarantine, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_PRODUCT_QUARANTINE]" . $error;
		}
		return $status;
	}

	public function UPDATE_QUARANTINE($PTQE_ID, $data)
	{
		$status = false;
		try {
			$this->db->where('PTQE_ID', $PTQE_ID);
			$this->db->update($this->tb_product_quarantine, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][UPDATE_QUARANTINE]" . $error;
		}
		return $status;
	}

	function DELETE_PRODUCT_IN_QUARANTINE($PTQE_ID)
	{
		$status = false;
		try {
			$this->db->where('PTQE_ID', $PTQE_ID);
			$this->db->delete($this->tb_product_quarantine);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DELETE_PRODUCT_IN_QUARANTINE]" . $error;
		}
		return $status;
	}

	public function INSERT_SAMPLE($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_sample, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][INSERT_SAMPLE]" . $error;
		}
		return $status;
	}

	public function DB_GET_DATA_SEARCH_QUARANTINE($SDATEF, $SDATET)
	{
		$result = "";
		try {
			$date_from = $SDATEF . " 00:00:00";
			$date_to = $SDATET . " 23:59:59";

			$query = $this->db->query('
			SELECT 
			tb_product_quarantine.PTQE_ID,
			tb_product_quarantine.PTID_ID,
			tb_product_quarantine.PTQE_NAME,  
			tb_product_quarantine.PTQE_DATE,
			tb_product_quarantine.PT_ID, 
			tb_product_quarantine.PTQE_NO, 
			tb_product_quarantine.PTQE_EXPIRED, 
			tb_product_quarantine.PTQE_QTY, 
			tb_product_quarantine.PTQE_STATUS 
			FROM 
			tb_product_quarantine 
			WHERE tb_product_quarantine.PTQE_DATE >= "' . $date_from . '" 
			AND tb_product_quarantine.PTQE_DATE <= "' . $date_to . '" 
			ORDER BY tb_product_quarantine.PTQE_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_QUARANTINE]" . $error;
		}
		return $result;
	}

	public function DB_GET_DATA_SEARCH_SAMPLE($SDATEF, $SDATET)
	{
		$result = "";
		try {
			$date_from = $SDATEF . " 00:00:00";
			$date_to = $SDATET . " 23:59:59";

			$query = $this->db->query('
			SELECT 
			tb_product_sample.PTSP_ID,
			tb_product_sample.PTID_ID,
			tb_product_sample.PTSP_NAME,  
			tb_product_sample.PTSP_DATE,
			tb_product_sample.PT_ID, 
			tb_product_sample.PTSP_NO,
			tb_product_sample.PTSP_EXPIRED, 
			tb_product_sample.PTSP_QTY, 
			tb_product_sample.PTSP_STATUS 
			FROM 
			tb_product_sample 
			WHERE tb_product_sample.PTSP_DATE >= "' . $date_from . '" 
			AND tb_product_sample.PTSP_DATE <= "' . $date_to . '" 
			ORDER BY tb_product_sample.PTSP_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_SAMPLE]" . $error;
		}
		return $result;
	}

	public function DB_GET_DATA_SEARCH_RETURN($SDATEF, $SDATET)
	{
		$result = "";
		try {
			$date_from = $SDATEF . " 00:00:00";
			$date_to = $SDATET . " 23:59:59";

			$query = $this->db->query('
			SELECT 
			tb_product_return.PTRN_ID,
			tb_product_return.PTID_ID,
			tb_product_return.PTRN_NAME,  
			tb_product_return.PTRN_DATE,
			tb_product_return.PT_ID, 
			tb_product_return.PTRN_NO,
			tb_product_return.PTRN_EXPIRED, 
			tb_product_return.PTRN_QTY, 
			tb_product_return.PTRN_STATUS 
			FROM 
			tb_product_return 
			WHERE tb_product_return.PTRN_DATE >= "' . $date_from . '" 
			AND tb_product_return.PTRN_DATE <= "' . $date_to . '" 
			ORDER BY tb_product_return.PTRN_DATE DESC
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_SEARCH_RETURN]" . $error;
		}
		return $result;
	}

	public function INSERT_RETURN($data)
	{
		$status = false;
		try {
			$this->db->insert($this->tb_product_return, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][INSERT_RETURN]" . $error;
		}
		return $status;
	}


	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_Q($PTID_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT 
			tb_product_inbound.PTID_ID, 
			tb_product_inbound.PTID_DATE, 
			tb_product_inbound.PTID_TGL_TERIMA, 
			tb_product_inbound.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound.PTID_PO_NO, 
			tb_product_inbound.PTID_PACKING_LIST_NO, 
			tb_product_inbound.PTID_PIB_NO, 
			tb_product_inbound.PTID_INVOICE_NO, 
			tb_product_inbound.FR_ID, 
			tb_forwarder.FR_NAME, 
			tb_forwarder.FR_PHONE, 
			tb_forwarder.FR_EMAIL, 
			tb_forwarder.FR_ADDRESS, 
			tb_product_inbound.PTID_CONTAINER_NO, 
			tb_product_inbound.PTID_CONTAINER_PLAT_NO, 
			tb_product_inbound.PTID_SEAL_NO, 
			tb_product_inbound.UR_ID, 
			tb_user.UR_NAME, 
			tb_user.UR_PHONE, 
			tb_user.UR_EMAIL, 
			tb_user.GT_ID, 
			tb_product_inbound.PTID_STATUS, 
			tb_product_inbound.PTID_APP_BY, 
			tb_product_inbound.PTID_QTY_TOTAL 
			FROM 
			tb_product_inbound 
			INNER JOIN tb_supplier ON tb_product_inbound.SR_ID = tb_supplier.SR_ID 
			INNER JOIN tb_forwarder ON tb_product_inbound.FR_ID = tb_forwarder.FR_ID 
			INNER JOIN tb_user ON tb_product_inbound.UR_ID = tb_user.UR_ID
			WHERE tb_product_inbound.PTID_ID = "' . $PTID_ID . '" 
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_Q]" . $error;
		}
		return $result;
	}


	public function DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL_BY_PRODUCT_Q($PTID_ID)
	{
		$result = "";
		try {
			$query = $this->db->query('
			SELECT
			tb_product_inbound_detail.PTIDDL_ID, 
			tb_product_inbound_detail.PTIDDL_DATE, 
			tb_product_inbound_detail.PTID_ID, 
			tb_product_inbound_detail.PT_ID, 
			tb_product.PT_NAME, 
			tb_product.PT_UNIT, 
			tb_product.PT_UNIT_MAX, 
			tb_product.PT_UNIT_MAX_EXT, 
			tb_product.PT_DIMENSION, 
			tb_product.PT_WEIGHT, 
			tb_product.PT_VOLUME, 
			tb_product.PT_TYPE, 
			tb_product.PT_IS_MANUFDATE, 
			tb_product.PTCY_ID, 
			tb_product.SR_ID, 
			tb_supplier.SR_NAME, 
			tb_supplier.SR_PHONE, 
			tb_supplier.SR_EMAIL, 
			tb_supplier.SR_ADDRESS, 
			tb_supplier.SR_ADDRESS_MANUFACTURING, 
			tb_supplier.SR_COUNTRY, 
			tb_product_inbound_detail.RK_ID, 
			tb_product_inbound_detail.PTIDDL_LABEL, 
			tb_product_inbound_detail.PTIDDL_NO, 
			tb_product_inbound_detail.PTIDDL_MANUFDATE, 
			tb_product_inbound_detail.PTIDDL_EXPIRED, 
			tb_product_inbound_detail.PTIDDL_QTY, 
			tb_product_inbound_detail.PTIDDL_QTY_GOOD, 
			tb_product_inbound_detail.PTIDDL_QTY_BAD 
			FROM 
			tb_product_inbound_detail 
			INNER JOIN tb_product ON tb_product_inbound_detail.PT_ID = tb_product.PT_ID 
			INNER JOIN tb_supplier ON tb_product.SR_ID = tb_supplier.SR_ID 
			WHERE tb_product_inbound_detail.PTID_ID = "' . $PTID_ID . '"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_PRODUCT_INBOUND_DETAIL_BY_PRODUCT_Q]" . $error;
		}
		return $result;
	}

	public function DB_GET_DATA_ALL_RACK_BY_STORAGE()
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_rack);
			// $this->db->where('SE_ID', $SE_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_RACK_BY_STORAGE]" . $error;
		}
		return $result;
	}

	public function DB_UPDATE_DATA_RACK_INBOUND($id, $data)
	{
		$status = false;
		try {
			$this->db->where('PTIDDL_ID', $id);
			$this->db->update($this->tb_product_inbound, $data);
			if ($this->db->affected_rows() == 1) {
				$status = true;
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_RACK_INBOUND]" . $error;
		}
		return $status;
	}

	public function DB_ALL_RACK($SE_ID)
	{
		$result = "";
		try {
			$this->db->select('SE_ID');
			$this->db->from($this->tb_rack);
			$this->db->like('SE_ID', $SE_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_CHECK_RACK_INBOUND_DETAIL_DRIVE_IN_EVO]" . $error;
		}
		return $result;
	}

	public function DB_GET_DATA_ALL_INBOUND_DETAIL($RK_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from($this->tb_product_inbound_detail);
			$this->db->join('tb_product', 'tb_product.PT_ID = tb_product_inbound_detail.PT_ID', 'left');	
			$this->db->where('RK_ID', $RK_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ALL_INBOUND_DETAIL]" . $error;
		}
		return $result;
	}

	public function DB_GET_DATA_PRODUCT_OUTBOUND()
	{
		$result = "";
		try {
			$this->db->select('ID_P_OUTBOUND');
			$this->db->from($this->tb_product_outbound_detail);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_PRODUCT_INBOUND_DETAIL_SINGLE_EVO]" . $error;
		}
		return $result;
	}

	 function simpan_upload($su_id_lastest,$su_id,$diterima,$kembali,$file){
        $data = array(
                'PTOD_DO_NO' => $su_id,
                'UPLOAD_DN' => $file,
                'TGL_DITERIMA' => $diterima,
                'TGL_KEMBALI' => $kembali
            );  
        $this->db->where('PTOD_DO_NO', $su_id_lastest);
        $result= $this->db->update('tb_product_outbound',$data);
        return $result;
    }


	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//