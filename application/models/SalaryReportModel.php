<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalaryReportModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getReportByLastMonth()
	{
		$sql = "SELECT
					e.name,
					e.position,
					 sr.salary as gross_salary, 
					(
                        SELECT sum(srd.amount)
                        FROM salary_report_detail srd
                        JOIN salary_type st ON srd.salary_type_id = st.id
                        JOIN salary_report srt ON srd.salary_report_id = srt.id
                        WHERE st.type = 2 
                      	AND srt.employee_id = e.id
						AND srt.deleted_at is null
                        AND srd.salary_report_id = sr.id
                        AND srt.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
                    ) as salary_decrease,
					(
                        SELECT sum(srd.amount)
                        FROM salary_report_detail srd
                        JOIN salary_type st ON srd.salary_type_id = st.id
                        JOIN salary_report srt ON srd.salary_report_id = srt.id
                        WHERE st.type = 1
                        AND srt.employee_id = e.id
                        AND srt.deleted_at is null
                        AND srd.salary_report_id = sr.id
                        AND srt.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
                    ) as salary_increase
				FROM employee e
				JOIN salary_report sr ON sr.employee_id = e.id
				WHERE sr.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
				AND sr.deleted_at is null
				ORDER BY sr.id DESC
				LIMIT 10;";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function all($start_date = "", $end_date = "", $employee_name = "")
	{
		$where = "sr.deleted_at is null ";
		if ($start_date && $end_date != "") {
			$where .= "AND 
					DATE(sr.created_at) BETWEEN '$start_date' AND '$end_date' ";
		}
		if ($employee_name != "") {
			$where .= "AND e.name like '%$employee_name%'";
		}

		return $this->db->select('sr.*, e.name `employee_name`, e.status `employee_status`, u.name `user_name`')
			->join('employee e', 'e.id = sr.employee_id')
			->join('users u', 'u.id = sr.user_id')
			->where($where)
			->order_by('sr.id desc')
			->get('salary_report sr');
	}

	public function get_detail($id)
	{
		return $this->db->select('sr.*, e.name `employee_name`, e.status `employee_status`, u.name `user_name`')
			->join('employee e', 'e.id = sr.employee_id')
			->join('users u', 'u.id = sr.user_id')
			->where('sr.id =', $id)
			->get('salary_report sr');
	}

	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('salary_report');
	}

	public function insert($data)
	{
		$this->db->insert('salary_report', $data);
		return $this->db->insert_id();
	}

	public function update($data, $where)
	{
		$this->db->where($where);
		return $this->db->update('salary_report', $data);
	}

	public function delete($where)
	{
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('salary_report', $data);
	}

}
