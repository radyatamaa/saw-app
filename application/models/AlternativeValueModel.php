<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlternativeValueModel extends CI_Model
{
	const ORDER_DIRECTION_ASC = "asc";
	const ORDER_DIRECTION_DESC = "desc";

	const ORDER_COLUMN_ALTERNATIVE_NAME = "alternative_name";
	const ORDER_COLUMN_ID = "id";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getAllByPeriodID($period_id, $order_column_req = "", $order_direction_req = "")
	{
		$order_by = "av.id asc";
		if ($order_column_req != "" && $order_column_req == self::ORDER_COLUMN_ID) {
			if ($order_direction_req == self::ORDER_DIRECTION_ASC) {
				$order_by = "av.id asc";
			} else if ($order_direction_req == self::ORDER_DIRECTION_DESC) {
				$order_by = "av.id desc";
			} else {
				$order_by = "av.id asc";
			}
		}

		if ($order_column_req != "" && $order_column_req == self::ORDER_COLUMN_ALTERNATIVE_NAME) {
			if ($order_direction_req == self::ORDER_DIRECTION_ASC) {
				$order_by = "a.name asc";
			} else if ($order_direction_req == self::ORDER_DIRECTION_DESC) {
				$order_by = "a.name desc";
			} else {
				$order_by = "av.id asc";
			}
		}

		$alternative_values = $this->db->select('av.*, a.name `alternative_name`')
			->join('alternative a', 'a.id = av.alternative_id')
			->where('av.period_id = ', $period_id)
			->where('av.deleted_at is null')
			->order_by($order_by)
			->get('alternative_value av')
			->result();

		return $alternative_values;
	}

	public function getAlternativeDetails($criterias, $alternative_value_details, $alternative_value_id)
	{
		$response = array();
		foreach ($alternative_value_details as $key => $value) {
			if ($value->alternative_value_id == $alternative_value_id) {

				$response[$value->id]['id'] = $value->id;
				$response[$value->id]['alternative_value_id'] = $value->alternative_value_id;
				$response[$value->id]['criteria_id'] = $value->criteria_id;
				$response[$value->id]['criteria_name'] = $value->criteria_name;
				$response[$value->id]['weight_criteria'] = $value->weight_criteria;
				$response[$value->id]['sub_criteria_id'] = $value->sub_criteria_id;
				$response[$value->id]['sub_criteria_name'] = $value->sub_criteria_name;
				$response[$value->id]['point_sub_criteria'] = $value->point_sub_criteria;
			}
		}
		return $response;
	}


	public function getAlternativeValueWithDetail($alternative_value_id)
	{
		$data = array();

		$alternative_value = $this->db->select('av.*, a.name `alternative_name`')
			->join('alternative a', 'a.id = av.alternative_id')
			->where('av.id = ', $alternative_value_id)
			->where('av.deleted_at is null')
			->get('alternative_value av');

		$alternative_value_details = $this->db
			->where('avd.deleted_at is null')
			->where('avd.alternative_value_id = ' . $alternative_value_id)
			->get('alternative_value_detail avd')
			->result();

		$data = $alternative_value->row_array();
		foreach ($alternative_value_details as $key => $value) {
			$data['criteria_details'][$value->criteria_id] = $value->sub_criteria_id;
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

	public function getAllWhereDeletedIsNull()
	{
		return $this->db->select('av.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('alternative_value av');
	}

	public function all($start_date = "", $end_date = "", $period_id = "", $alternative_name = "", $alternative_email = "", $alternative_phone = "")
	{
		$where = "av.deleted_at is null ";
		if ($start_date && $end_date != "") {
			$where .= "AND 
					DATE(av.created_at) BETWEEN '$start_date' AND '$end_date' ";
		}
		if ($alternative_name != "") {
			$where .= "AND a.name like '%$alternative_name%'";
		}
		if ($alternative_email != "") {
			$where .= "AND a.email like '%$alternative_email%'";
		}
		if ($alternative_phone != "") {
			$where .= "AND a.phone_number like '%$alternative_phone%'";
		}
		if ($period_id != "") {
			$where .= "AND av.period_id = $period_id";
		}

		return $this->db->select('av.*, a.email, a.phone_number, a.name `alternative_name`, u.name `user_name`')
			->join('alternative a', 'a.id = av.alternative_id')
			->join('users u', 'u.id = av.user_id')
			->where($where)
			->order_by('av.id asc')
			->get('alternative_value av');
	}

	public function get_detail($id)
	{
		$where = "av.deleted_at is null ";
		if ($id && $id != "") {
			$where .= "AND av.id = $id";
		}

		return $this->db->select('av.*, a.name `alternative_name`, a.previous_company `alternative_previous_company`,a.current_job_position `alternative_current_job_position`, a.phone_number `alternative_phone_number`, a.email `alternative_email`, u.name `user_name`, a.previous_company')
			->join('alternative a', 'a.id = av.alternative_id')
			->join('users u', 'u.id = av.user_id')
			->where($where)
			->order_by('av.id desc')
			->get('alternative_value av');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('alternative_value');
	}

	public function insert($data)
	{
		$this->db->insert('alternative_value', $data);
		return $this->db->insert_id();
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		$this->db->update('alternative_value', $data);
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
		return $this->db->update('alternative_value', $data);
	}
}
