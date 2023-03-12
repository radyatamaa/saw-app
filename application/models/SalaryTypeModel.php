<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalaryTypeModel extends CI_Model
{
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;

	const TYPE_INCREASE = 1;
	const TYPE_DECREASE = 2;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getIncreaseSalaryType()
	{
		$data = array();

		$st = $this->db
			->where('status', self::STATUS_ACTIVE)
			->where('type', self::TYPE_INCREASE)
			->where('deleted_at is null')
			->get('salary_type')->result();

		foreach ($st as $value) {
			$data[$value->id] = $value->name;
		}

		return $data;
	}

	public function getDecreaseSalaryType()
	{
		$data = array();

		$st = $this->db
			->where('status', self::STATUS_ACTIVE)
			->where('type', self::TYPE_DECREASE)
			->where('deleted_at is null')
			->get('salary_type')->result();

		foreach ($st as $value) {
			$data[$value->id] = $value->name;
		}

		return $data;
	}

	public function all_increase_salary_type()
	{
		return $this->db->select('st.*')
			->where('type', self::TYPE_INCREASE)
			->where('deleted_at is null')
			->order_by('id desc')
			->get('salary_type st');
	}

	public function all_decrease_salary_type()
	{
		return $this->db->select('st.*')
			->where('type', self::TYPE_DECREASE)
			->where('deleted_at is null')
			->order_by('id desc')
			->get('salary_type st');
	}


	public function all()
	{
		return $this->db->select('st.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('salary_type st');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('salary_type');
	}

	public function insert($data)
	{
		return $this->db->insert('salary_type', $data);
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		return $this->db->update('salary_type', $data);
	}

	public function delete($where)
	{
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'status' => self::STATUS_INACTIVE,
		);

		$this->db->where($where);
		return $this->db->update('salary_type', $data);
	}

}
