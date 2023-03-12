<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalaryReport extends CI_Controller
{
	private $alert = '';
	public $js_default = 'js_datatable';
	public $css_default = 'css_datatable';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('SalaryTypeModel');
		$this->load->model('SalaryReportModel');
		$this->load->model('SalaryReportDetailModel');
		$this->load->model('EmployeeModel');
		$this->load->model('UserModel');
		if (empty($this->session->userdata("id"))) {
			redirect('login/index');
		}
	}

	private function alert($open_tag = null, $close_tag = null, $data = null)
	{
		if ($data != null) $data = $open_tag . $data . $close_tag;

		return $data;
	}

	private function template($content, $data = null)
	{
		$data['user_name'] = $this->session->userdata("name");
		$data['content'] = $this->load->view($content, $data, true);
		$data['access'] = $this->session->userdata("access");

		$this->load->view('template', $data);
	}

	public function get_detail_json()
	{
		header('Content-Type: application/json');

		$salary_id = $this->input->get('id');
		$employee_mapping = $this->UserModel->mapping_user_position();
		$salary_report_detail = $this->SalaryReportModel->get_detail($salary_id)->row();

		// $salary_report_detail_increase = $this->SalaryReportDetailModel->getDetailSalaryTypeIncrease($salary_id);
		$salary_report_detail_increase = $this->SalaryTypeModel->all_increase_salary_type()->result_array();
		foreach ($salary_report_detail_increase as $key => $value) {
			// get
			$salary_type_detail = $this->SalaryReportDetailModel->getBySalaryTypeIDAndSalaryReportID($value['id'], $salary_id);
			// assign
			$salary_report_id = empty($salary_type_detail->salary_report_id) ? null : $salary_type_detail->salary_report_id;
			$salary_report_detail_amount = empty($salary_type_detail->amount) ? 0 : $salary_type_detail->amount;
			$salary_report_detail_id = empty($salary_type_detail->id) ? null : $salary_type_detail->id;
			$salary_report_detail_installment = empty($salary_type_detail->installment) ? null : $salary_type_detail->installment;

			$salary_report_detail_increase[$key]['salary_report_id'] = $salary_report_id;
			$salary_report_detail_increase[$key]['salary_type_amount'] = 'Rp. ' . number_format($salary_report_detail_amount) . ',-';
			$salary_report_detail_increase[$key]['salary_type_amount_int'] = $salary_report_detail_amount;
			$salary_report_detail_increase[$key]['salary_report_detail_id'] = $salary_report_detail_id;
			$salary_report_detail_increase[$key]['salary_type_installment'] = $salary_report_detail_installment;
		}

		// sum total salary increase
		$total_salary_increase = 0;
		foreach ($salary_report_detail_increase as $val) {
			$total_salary_increase += $val['salary_type_amount_int'];

		}

		// $salary_report_detail_decrease = $this->SalaryReportDetailModel->getDetailSalaryTypeDecrease($salary_id);
		$salary_report_detail_decrease = $this->SalaryTypeModel->all_decrease_salary_type()->result_array();
		foreach ($salary_report_detail_decrease as $key => $value) {
			// get
			$salary_type_detail = $this->SalaryReportDetailModel->getBySalaryTypeIDAndSalaryReportID($value['id'], $salary_id);
			// assign
			$salary_report_id = empty($salary_type_detail->salary_report_id) ? null : $salary_type_detail->salary_report_id;
			$salary_report_detail_amount = empty($salary_type_detail->amount) ? 0 : $salary_type_detail->amount;
			$salary_report_detail_id = empty($salary_type_detail->id) ? null : $salary_type_detail->id;
			$salary_report_detail_installment = empty($salary_type_detail->installment) ? null : $salary_type_detail->installment;

			$salary_report_detail_decrease[$key]['salary_report_id'] = $salary_report_id;
			$salary_report_detail_decrease[$key]['salary_type_amount'] = 'Rp. ' . number_format($salary_report_detail_amount) . ',-';
			$salary_report_detail_decrease[$key]['salary_type_amount_int'] = $salary_report_detail_amount;
			$salary_report_detail_decrease[$key]['salary_report_detail_id'] = $salary_report_detail_id;
			$salary_report_detail_decrease[$key]['salary_type_installment'] = $salary_report_detail_installment;
		}

		// sum total salary decrease
		$total_salary_decrease = 0;
		foreach ($salary_report_detail_decrease as $val) {
			$total_salary_decrease += $val['salary_type_amount_int'];

		}

		$data_array = array(
			'salary_report_id' => $salary_report_detail->id,
			'salary_report_month' => date('F', strtotime($salary_report_detail->created_at)),
			'employee_name' => $salary_report_detail->employee_name,
			'employee_status' => $salary_report_detail->employee_status,
			'gross_salary' => number_format($salary_report_detail->salary),
			'salary_type_increase' => $salary_report_detail_increase,
			'salary_type_increase_total' => number_format($total_salary_increase),
			'salary_type_decrease' => $salary_report_detail_decrease,
			'salary_type_decrease_total' => number_format($total_salary_decrease),
			'net_salary' => number_format(($salary_report_detail->salary + $total_salary_increase) - $total_salary_decrease),
			'employee_mapping' => $employee_mapping,
			'date_now' => date('Y-m-d'),
		);

		$data_json = json_encode($data_array);
		echo $data_json;
	}

	public function get_detail($salary_id)
	{
		$employee_mapping = $this->UserModel->mapping_user_position();
		$salary_report_detail = $this->SalaryReportModel->get_detail($salary_id)->row();

		// $salary_report_detail_increase = $this->SalaryReportDetailModel->getDetailSalaryTypeIncrease($salary_id);
		$salary_report_detail_increase = $this->SalaryTypeModel->all_increase_salary_type()->result_array();
		foreach ($salary_report_detail_increase as $key => $value) {
			// get
			$salary_type_detail = $this->SalaryReportDetailModel->getBySalaryTypeIDAndSalaryReportID($value['id'], $salary_id);
			// assign
			$salary_report_id = empty($salary_type_detail->salary_report_id) ? null : $salary_type_detail->salary_report_id;
			$salary_report_detail_amount = empty($salary_type_detail->amount) ? 0 : $salary_type_detail->amount;
			$salary_report_detail_id = empty($salary_type_detail->id) ? null : $salary_type_detail->id;
			$salary_report_detail_installment = empty($salary_type_detail->installment) ? null : $salary_type_detail->installment;

			$salary_report_detail_increase[$key]['salary_report_id'] = $salary_report_id;
			$salary_report_detail_increase[$key]['salary_type_amount'] = $salary_report_detail_amount;
			$salary_report_detail_increase[$key]['salary_report_detail_id'] = $salary_report_detail_id;
			$salary_report_detail_increase[$key]['salary_type_installment'] = $salary_report_detail_installment;
		}

		// sum total salary increase
		$total_salary_increase = 0;
		foreach ($salary_report_detail_increase as $val) {
			$total_salary_increase += $val['salary_type_amount'];

		}

		// $salary_report_detail_decrease = $this->SalaryReportDetailModel->getDetailSalaryTypeDecrease($salary_id);
		$salary_report_detail_decrease = $this->SalaryTypeModel->all_decrease_salary_type()->result_array();
		foreach ($salary_report_detail_decrease as $key => $value) {
			// get
			$salary_type_detail = $this->SalaryReportDetailModel->getBySalaryTypeIDAndSalaryReportID($value['id'], $salary_id);
			// assign
			$salary_report_id = empty($salary_type_detail->salary_report_id) ? null : $salary_type_detail->salary_report_id;
			$salary_report_detail_amount = empty($salary_type_detail->amount) ? 0 : $salary_type_detail->amount;
			$salary_report_detail_id = empty($salary_type_detail->id) ? null : $salary_type_detail->id;
			$salary_report_detail_installment = empty($salary_type_detail->installment) ? null : $salary_type_detail->installment;

			$salary_report_detail_decrease[$key]['salary_report_id'] = $salary_report_id;
			$salary_report_detail_decrease[$key]['salary_type_amount'] = $salary_report_detail_amount;
			$salary_report_detail_decrease[$key]['salary_report_detail_id'] = $salary_report_detail_id;
			$salary_report_detail_decrease[$key]['salary_type_installment'] = $salary_report_detail_installment;
		}

		// sum total salary decrease
		$total_salary_decrease = 0;
		foreach ($salary_report_detail_decrease as $val) {
			$total_salary_decrease += $val['salary_type_amount'];

		}

		$data_array = array(
			'salary_report_id' => $salary_report_detail->id,
			'salary_report_month' => date('F', strtotime($salary_report_detail->created_at)),
			'employee_name' => $salary_report_detail->employee_name,
			'employee_status' => $salary_report_detail->employee_status,
			'gross_salary' => $salary_report_detail->salary,
			'salary_type_increase' => $salary_report_detail_increase,
			'salary_type_increase_total' => $total_salary_increase,
			'salary_type_decrease' => $salary_report_detail_decrease,
			'salary_type_decrease_total' => $total_salary_decrease,
			'net_salary' => ($salary_report_detail->salary + $total_salary_increase) - $total_salary_decrease,
			'employee_mapping' => $employee_mapping,
			'date_now' => date('d-m-Y'),
		);

		// if want in format json, uncomment this code..
		//$data_json = json_encode($data_array);
		//echo $data_json;
		return $data_array;
	}

	public function index()
	{
		$start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "";
		$end_date = isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : "";
		$employee_name = isset($_REQUEST["employee_name"]) ? $_REQUEST["employee_name"] : "";

		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}

		$data['salary_report'] = $this->SalaryReportModel->all($start_date, $end_date, $employee_name);
		$data['access'] = $this->session->userdata("access");

		$this->template('salaryreport/list', $data);
	}

	public function get_report_list()
	{
		$start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "";
		$end_date = isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : "";
		$employee_name = isset($_REQUEST["employee_name"]) ? $_REQUEST["employee_name"] : "";

		$employee_mapping = $this->UserModel->mapping_user_position();
		$salary_report = $this->SalaryReportModel->all($start_date, $end_date, $employee_name);
		$salary_report_list = $salary_report->result_array();
		$salary_report_detail_list = array();
		foreach ($salary_report_list as $key => $value) {
			$salary_report_detail_list[$key] = $this->get_detail($value['id']);
		}

		$start_date_format = $start_date;
		if ($start_date != "" || !empty($start_date)) {
			$start_date_format = date('d-m-Y', strtotime($start_date));
		}

		$end_date_format = $end_date;
		if ($end_date != "" || !empty($end_date)) {
			$end_date_format = date('d-m-Y', strtotime($end_date));
		}

		$data['date_now'] = date('d-m-Y');
		$data['start_date'] = $start_date_format;
		$data['end_date'] = $end_date_format;
		$data['employee_name_request'] = $employee_name;
		$data['employee_mapping'] = $employee_mapping;
		$data['salary_report_list'] = $salary_report_detail_list;
		$data['all_increase_salary_type'] = $this->SalaryTypeModel->all_increase_salary_type()->result_array();
		$data['all_decrease_salary_type'] = $this->SalaryTypeModel->all_decrease_salary_type()->result_array();

		$this->load->view('salaryreport/print_all_pdf', $data);
	}

	public function get_detail_salary($id)
	{
		if ($id != "" || !empty($id)) {
			$data['salary_report_detail'] = $this->get_detail($id);
			return $this->load->view('salaryreport/print_pdf', $data);
		}

		redirect('salaryreport');
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'employee_id' => $this->input->post('employee_id'),
				'user_id' => $this->input->post('user_id'),
				'salary' => $this->input->post('salary'),
				'salary_type_id' => $this->input->post('salary_type_id'),
				'salary_type_amount' => $this->input->post('salary_type_amount'),
				'salary_type_installment' => $this->input->post('salary_type_installment'),
			);

			$this->form_validation->set_rules('employee_id', 'Nama Karyawan', 'required');
			$this->form_validation->set_rules('salary', 'Gaji', 'required');
			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					$salary_report_insert = array(
						'employee_id' => $this->input->post('employee_id'),
						'user_id' => $this->session->userdata('id'),
						'salary' => $this->input->post('salary'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),

					);
					$salary_report_id = $this->SalaryReportModel->insert($salary_report_insert);
					if (!empty($salary_report_id) || $salary_report_id != 0 || $salary_report_id != "") {

						foreach ($post_data['salary_type_amount'] as $key => $value) {
							if ($value) {
								$salary_report_detail_insert = array(
									'salary_report_id ' => $salary_report_id,
									'salary_type_id' => $post_data['salary_type_id'][$key],
									'amount' => $value,
									'installment' => empty($post_data['salary_type_installment'][$key]) ? null : $post_data['salary_type_installment'][$key],
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s'),

								);
								if (!$this->SalaryReportDetailModel->insert($salary_report_detail_insert)) {
									$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan Laporan gaji..");

									$data = array(
										'alert' => $this->alert,
									);
									$this->session->set_flashdata('data', $data);
									redirect('salaryreport');
								}
							}
						}
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Laporan gaji berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('salaryreport');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan Laporan gaji..");
					}
				}

			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}

		}

		$status = array(
			'1' => 'Active',
			'2' => 'Nonactive',
		);

		$data = array(
			'data' => $this->SalaryReportModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'status' => $status,
			'employee' => $this->EmployeeModel->getActiveEmployee(),
			'salary_type_increase' => $this->SalaryTypeModel->getIncreaseSalaryType(),
			'salary_type_decrease' => $this->SalaryTypeModel->getDecreaseSalaryType(),
		);

		$this->template('salaryreport/form', $data);
	}

	public function update()
	{
		if ($this->input->post('update')) {
			$post_data = array(
				'employee_id' => $this->input->post('employee_id'),
				'user_id' => $this->input->post('user_id'),
				'salary' => $this->input->post('salary'),
				'salary_type_id' => $this->input->post('salary_type_id'),
				'salary_report_detail_id' => $this->input->post('salary_report_detail_id'),
				'salary_type_amount' => $this->input->post('salary_type_amount'),
				'salary_type_installment' => $this->input->post('salary_type_installment'),
			);

			$this->form_validation->set_rules('employee_id', 'Nama Karyawan', 'required');
			$this->form_validation->set_rules('salary', 'Gaji', 'required');

			if ($this->form_validation->run()) {
				if ($this->input->post('id') != '') {
					$salary_report_update = array(
						'employee_id' => $this->input->post('employee_id'),
						'user_id' => $this->session->userdata('id'),
						'salary' => $this->input->post('salary'),
						'updated_at' => date('Y-m-d H:i:s'),

					);
					$this->SalaryReportModel->update($salary_report_update, array('id' => $this->input->post('id')));
					$salary_report_id = $this->input->post('id');
					if (!empty($salary_report_id) || $salary_report_id != 0 || $salary_report_id != "") {

						foreach ($post_data['salary_type_amount'] as $key => $value) {
							$salary_report_detail_update = array(
								'salary_report_id ' => $salary_report_id,
								'id ' => $post_data['salary_report_detail_id'][$key],
								'salary_type_id' => $post_data['salary_type_id'][$key],
								'amount' => $value,
								'installment' => empty($post_data['salary_type_installment'][$key]) ? null : $post_data['salary_type_installment'][$key],
								'updated_at' => date('Y-m-d H:i:s'),

							);
							// if empty salary report id then insert
							if (empty($post_data['salary_report_detail_id'][$key]) || $post_data['salary_report_detail_id'][$key] == "") {
								$salary_report_detail_insert = array(
									'salary_report_id ' => $salary_report_id,
									'salary_type_id' => $post_data['salary_type_id'][$key],
									'amount' => $value,
									'installment' => empty($post_data['salary_type_installment'][$key]) ? null : $post_data['salary_type_installment'][$key],
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s'),

								);
								$this->SalaryReportDetailModel->insert($salary_report_detail_insert);
							}
							if (!$this->SalaryReportDetailModel->update($salary_report_detail_update, array('id' => $post_data['salary_report_detail_id'][$key]))) {
								$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate Laporan gaji..");
							}
						}

						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Laporan gaji berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('salaryreport');

					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate Laporan gaji..");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}
		}

		$status = array(
			'1' => 'Active',
			'2' => 'Nonactive',
		);

		$salary_report_detail_increase = $this->SalaryTypeModel->all_increase_salary_type()->result_array();
		foreach ($salary_report_detail_increase as $key => $value) {
			// get
			$salary_type_detail = $this->SalaryReportDetailModel->getBySalaryTypeIDAndSalaryReportID($value['id'], $this->uri->segment(3));
			// assign
			$salary_report_id = empty($salary_type_detail->salary_report_id) ? null : $salary_type_detail->salary_report_id;
			$salary_report_detail_amount = empty($salary_type_detail->amount) ? 0 : $salary_type_detail->amount;
			$salary_report_detail_id = empty($salary_type_detail->id) ? null : $salary_type_detail->id;
			$salary_report_detail_installment = empty($salary_type_detail->installment) ? null : $salary_type_detail->installment;

			$salary_report_detail_increase[$key]['salary_report_id'] = $salary_report_id;
			$salary_report_detail_increase[$key]['salary_type_amount'] = $salary_report_detail_amount;
			$salary_report_detail_increase[$key]['salary_report_detail_id'] = $salary_report_detail_id;
			$salary_report_detail_increase[$key]['salary_type_installment'] = $salary_report_detail_installment;
		}

		$salary_report_detail_decrease = $this->SalaryTypeModel->all_decrease_salary_type()->result_array();
		foreach ($salary_report_detail_decrease as $key => $value) {
			// get
			$salary_type_detail = $this->SalaryReportDetailModel->getBySalaryTypeIDAndSalaryReportID($value['id'], $this->uri->segment(3));
			// assign
			$salary_report_id = empty($salary_type_detail->salary_report_id) ? null : $salary_type_detail->salary_report_id;
			$salary_report_detail_amount = empty($salary_type_detail->amount) ? 0 : $salary_type_detail->amount;
			$salary_report_detail_id = empty($salary_type_detail->id) ? null : $salary_type_detail->id;
			$salary_report_detail_installment = empty($salary_type_detail->installment) ? null : $salary_type_detail->installment;

			$salary_report_detail_decrease[$key]['salary_report_id'] = $salary_report_id;
			$salary_report_detail_decrease[$key]['salary_type_amount'] = $salary_report_detail_amount;
			$salary_report_detail_decrease[$key]['salary_report_detail_id'] = $salary_report_detail_id;
			$salary_report_detail_decrease[$key]['salary_type_installment'] = $salary_report_detail_installment;
		}

		$data = array(
			'data' => $this->SalaryReportModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'status' => $status,
			'employee' => $this->EmployeeModel->getActiveEmployee(),
			'salary_type_increase' => $salary_report_detail_increase,
			'salary_type_decrease' => $salary_report_detail_decrease
		);

		$this->template('salaryreport/form_edit', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			$this->SalaryReportModel->delete(array('id' => $this->uri->segment(3)));
			$this->SalaryReportDetailModel->delete(array('salary_report_id' => $this->uri->segment(3)));

			$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data laporan gaji berhasil dihapus..");
			$data = array(
				'alert' => $this->alert,
			);
			$this->session->set_flashdata('data', $data);
			redirect('salaryreport');
		}
	}
}

