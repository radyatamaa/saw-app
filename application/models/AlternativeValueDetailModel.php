<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlternativeValueDetailModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function all()
	{
		return $this->db->select('avd.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('alternative_value_detail avd');
	}

	public function getWithCriteriaByAlternativeValueID($alternative_value_id, $criteria_id)
	{
		return $this->db->select(' avd.*, IF(c.type=1,"Benefit","Cost") as criteria_type')
			->join('criteria c', 'avd.criteria_id = c.id')
			->where("avd.deleted_at is null")
			->where("avd.alternative_value_id = ", $alternative_value_id)
			->where("avd.criteria_id = ", $criteria_id)
			->get('alternative_value_detail avd');
	}

	public function getByAlternativeValueIDAndCriteriaID($alternative_value_id, $criteria_id)
	{
		return $this->db->select(' avd.*')
			->where("avd.deleted_at is null")
			->where("avd.alternative_value_id = ", $alternative_value_id)
			->where("avd.criteria_id = ", $criteria_id)
			->get('alternative_value_detail avd');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('alternative_value_detail');
	}

	public function insert($data)
	{
		return $this->db->insert('alternative_value_detail', $data);
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		$this->db->update('alternative_value_detail', $data);
		$affected_rows = $this->db->affected_rows();

		if ($affected_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function delete($where)
	{
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('alternative_value_detail', $data);
	}
}
