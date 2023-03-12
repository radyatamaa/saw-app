<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CriteriaModel extends CI_Model
{
	const TYPE_BENEFIT = 1;
	const TYPE_COST = 2;

	const MAX_WEIGHT = 100;

	public function __construct()
	{
		parent::__construct();
		//melakukan koneksi database
		$this->load->database();
	}

	private function getCriteriaStrType($type_id)
	{
		switch ($type_id) {
			case self::TYPE_BENEFIT :
				return "Benefit";
			case self::TYPE_COST :
				return "Cost";
		}
	}

	public function getAllActiveCriteria($period_id = '')
	{
		$data = array();

		$criterias = $this->db
			->where('deleted_at is null')
			->get('criteria')
			->result();

		foreach ($criterias as $value) {
			$max_min_point_sub_criteria = $this->getMinMaxCriteriaAlternativeByIDAndPeriodID($period_id, $value->id);

			$data[$value->id]['id'] = $value->id;
			$data[$value->id]['name'] = $value->name;
			$data[$value->id]['description'] = $value->description;
			$data[$value->id]['weight'] = $value->weight;
			$data[$value->id]['type'] = $value->type;
			$data[$value->id]['type_str'] = $this->getCriteriaStrType($value->type);
			$data[$value->id]['max_point_sub_criteria'] = empty($max_min_point_sub_criteria->max_point_sub_criteria) ? 0 : $max_min_point_sub_criteria->max_point_sub_criteria;
			$data[$value->id]['min_point_sub_criteria'] = empty($max_min_point_sub_criteria->min_point_sub_criteria) ? 0 : $max_min_point_sub_criteria->min_point_sub_criteria;
			$data[$value->id]['created_at'] = $value->created_at;
			$data[$value->id]['updated_at'] = $value->updated_at;
		}

		return $data;
	}

	public function getMinMaxCriteriaAlternativeByIDAndPeriodID($period_id, $criteria_id)
	{
		$criterias = $this->db->select('max(avd.point_sub_criteria) as max_point_sub_criteria, min(point_sub_criteria) as min_point_sub_criteria')
			->join('alternative_value_detail avd', 'av.id = avd.alternative_value_id')
			->where('av.deleted_at is null')
			->where('av.period_id = ', $period_id)
			->where('avd.criteria_id = ', $criteria_id)
			->get('alternative_value av')
			->row();

		return $criterias;
	}

	public function getActiveCriteria()
	{
		$data = array();

		$criterias = $this->db
			->where('deleted_at is null')
			->get('criteria')
			->result();

		foreach ($criterias as $value) {
			$data[$value->id] = $value->name;
		}

		return $data;
	}

	public function getSubCriteria($sub_criteria, $criteria_id)
	{
		$response = array();
		foreach ($sub_criteria as $key => $value) {
			if ($value->criteria_id == $criteria_id) {
				$response[$value->id] = $value->name;
			}
		}
		return $response;
	}

	public function getActiveCriteriaWithSubCriteria()
	{
		$data = array();

		$criterias = $this->db
			->where('deleted_at is null')
			->get('criteria')
			->result();

		$criteria_id_arr = array();
		foreach ($criterias as $key => $val) {
			$criteria_id_arr[$key] = $val->id;
		}
		$criteria_ids = implode(',', $criteria_id_arr);

		$sub_criterias = $this->db
			->where('sc.deleted_at is null')
			->where('sc.criteria_id in (' . $criteria_ids . ')')
			->get('sub_criteria sc')
			->result();

		foreach ($criterias as $key => $value) {
			$data[$key]['id'] = $value->id;
			$data[$key]['name'] = $value->name . ' - (' . $this->getCriteriaStrType($value->type) . ')';
			$data[$key]['sub_criterias'] = $this->getSubCriteria($sub_criterias, $value->id);
		}

		return $data;
	}

	public function getActiveCriteriaDetailForUpdate()
	{
		$data = array();

		$criterias = $this->db
			->where('deleted_at is null')
			->get('criteria')
			->result();

		$criteria_id_arr = array();
		foreach ($criterias as $key => $val) {
			$criteria_id_arr[$key] = $val->id;
		}
		$criteria_ids = implode(',', $criteria_id_arr);

		$sub_criterias = $this->db
			->where('sc.deleted_at is null')
			->where('sc.criteria_id in (' . $criteria_ids . ')')
			->get('sub_criteria sc')
			->result();

		foreach ($criterias as $key => $value) {

			$data[$value->id]['id'] = $value->id;
			$data[$value->id]['name'] = $value->name . ' - (' . $this->getCriteriaStrType($value->type) . ')';
			$data[$value->id]['sub_criterias'] = $this->getSubCriteria($sub_criterias, $value->id);
		}

		return $data;
	}

	public function all()
	{
		return $this->db->select('c.*')
			->where('deleted_at is null')
			->get('criteria c');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('criteria');
	}

	public function insert_batch($data)
	{
		$insert = $this->db->insert_batch('criteria', $data);
		if ($insert) {
			return true;
		}
	}

	public function insert($data)
	{
		// melakukan insert ke tabel users
		return $this->db->insert('criteria', $data);
	}

	public function update($data, $where)
	{
		//melakukan update ke tabel users
		$this->db->where($where);
		return $this->db->update('criteria', $data);
	}

	public function delete($where)
	{
		//menghapus data pada tabel users sesuai kriteria
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('criteria', $data);
	}

}
