<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubCriteriaModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//melakukan koneksi database
		$this->load->database();
	}

	public function all($criteria_id = "")
	{
		$where = "sc.deleted_at is null ";
		if ($criteria_id != "") {
			$where .= "AND sc.criteria_id = $criteria_id";
		}

		return $this->db->select('sc.*, c.name as criteria_name, c.id as criteria_id')
			->join('criteria c', 'c.id = sc.criteria_id')
			->where($where)
			->order_by('sc.id desc')
			->get('sub_criteria sc');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('sub_criteria');
	}

	public function insert_batch($data){
		$insert = $this->db->insert_batch('sub_criteria', $data);
		if($insert){
			return true;
		}
	}

	public function insert($data)
	{
		// melakukan insert ke tabel users
		return $this->db->insert('sub_criteria', $data);
	}

	public function update($data, $where)
	{
		//melakukan update ke tabel users
		$this->db->where($where);
		return $this->db->update('sub_criteria', $data);
	}

	public function delete($where)
	{
		//menghapus data pada tabel users sesuai kriteria
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('sub_criteria', $data);
	}

}
