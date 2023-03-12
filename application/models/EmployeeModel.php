<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmployeeModel extends CI_Model
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getActiveEmployee()
	{
		$data = array();

		$employee = $this->db
			->where('status', 1)
			->where('deleted_at is null')
			->get('employee')
			->result();

		foreach ($employee as $value) {
			$data[$value->id] = $value->name;
		}

		return $data;
	}

	public function all()
	{
		return $this->db->select('e.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('employee e');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('employee');
	}

	public function insert($data)
	{
		return $this->db->insert('employee', $data);
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		return $this->db->update('employee', $data);
	}

	public function delete($where)
	{
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'status' => self::STATUS_INACTIVE,
		);

		$this->db->where($where);
		return $this->db->update('employee', $data);
	}
}
