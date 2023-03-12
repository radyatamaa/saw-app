<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalaryReportDetailModel extends CI_Model
{
	const SALARY_TYPE_INCREASE = 1;
	const SALARY_TYPE_DECREASE = 2;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function all()
	{
		return $this->db->select('st.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('salary_report_detail st');
	}

	public function getBySalaryTypeIDAndSalaryReportID($st_id, $sr_id)
	{
		return $this->db->select('srd.*, st.name `salary_type_name`,  st.type `salary_type_id`, sr.id `salary_report_id`')
			->join('salary_type st', 'st.id = srd.salary_type_id')
			->join('salary_report sr', 'sr.id = srd.salary_report_id')
			->where('srd.deleted_at is null')
			->where('st.id = ', $st_id)
			->where('sr.id = ', $sr_id)
			->get('salary_report_detail srd')
			->row();
	}

	public function getBySalaryReportID($id)
	{
		return $this->db->select('srd.*, st.name `salary_type_name`,  st.type `salary_type_id`')
			->join('salary_type st', 'st.id = srd.salary_type_id')
			->join('salary_report sr', 'sr.id = srd.salary_report_id')
			->where('srd.deleted_at is null')
			->where('sr.id = ', $id)
			->get('salary_report_detail srd')
			->result();
	}

	public function getDetailSalaryTypeIncrease($salary_report_id)
	{
		$data = $this->db->select('st.*, srd.amount `salary_type_amount`, srd.id `salary_report_detail_id`, srd.installment `salary_type_installment`')
			->join('salary_report_detail srd', 'srd.salary_type_id = st.id', 'left')
			->join('salary_report sr', 'sr.id = srd.salary_report_id', 'left')
			->where('st.type', self::SALARY_TYPE_INCREASE)
			->where('srd.deleted_at is null')
			->where('sr.id = ', $salary_report_id)
			->get('salary_type st')
			->result();

		return $data;
	}

	public function getDetailSalaryTypeDecrease($salary_report_id)
	{
		$data = $this->db->select('st.*, srd.amount `salary_type_amount`, srd.id `salary_report_detail_id`, srd.installment `salary_type_installment`')
			->join('salary_report_detail srd', 'srd.salary_type_id = st.id')
			->join('salary_report sr', 'sr.id = srd.salary_report_id')
			->where('st.type', self::SALARY_TYPE_DECREASE)
			->where('srd.deleted_at is null')
			->where('sr.id = ', $salary_report_id)
			->get('salary_type st')
			->result();

		return $data;
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('salary_report_detail');
	}

	public function insert($data)
	{
		return $this->db->insert('salary_report_detail', $data);
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		return $this->db->update('salary_report_detail', $data);
	}

	public function delete($where)
	{
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('salary_report_detail', $data);
	}

}
