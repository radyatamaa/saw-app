<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{

	public $js_default = 'js_datatable';

	public $css_default = 'css_datatable';


	private $alert = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('EmployeeModel');
		if (empty($this->session->userdata("id"))) {
			redirect('login/index');
		}
	}

	private function alert($open_tag = null, $close_tag = null, $data = null)
	{
		if ($data != null) $data = $open_tag . $data . $close_tag;
		return $data;
	}

	public function get_by_id()
	{
		header('Content-Type: application/json');

		$id = $this->input->get('id');
		$employee = $this->EmployeeModel->getWhere(array('id' => $id))->row();
		$employee->salary = (float)$employee->salary;

		$data_array = array(
			'employee' => $employee,
		);

		$data_json = json_encode($data_array);
		echo $data_json;
	}

	private function template($content, $data = null)
	{
		$data['user_name'] = $this->session->userdata("name");
		$data['content'] = $this->load->view($content, $data, true);
		$data['access'] = $this->session->userdata("access");

		$this->load->view('template', $data);
	}

	public function index()
	{
		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}
		$data['employees'] = $this->EmployeeModel->all();
		$this->template('employee/list', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'name' => $this->input->post('name'),
				'salary' => $this->input->post('salary'),
				'age' => $this->input->post('age'),
				'position' => $this->input->post('position'),
				'domisili' => $this->input->post('domisili'),
				'status' => $this->input->post('status'),
			);

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('salary', 'Salary', 'required');
			$this->form_validation->set_rules('position', 'Position', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->EmployeeModel->insert($post_data)) {
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data karyawan berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('employee');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data karyawan..");
					}
				} else {
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->EmployeeModel->update($post_data, array('id' => $this->input->post('id')))) {
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data karyawan berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('employee');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate data karyawan..");
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
			'data' => $this->EmployeeModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'status' => $status
		);

		$this->template('employee/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->EmployeeModel->delete(array('id' => $this->uri->segment(3)))) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data karyawan berhasil dihapus..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);

				redirect('employee');
			}
		}
	}
}

