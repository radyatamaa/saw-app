<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SalaryType extends CI_Controller
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
		if (empty($this->session->userdata("id"))) {
			redirect('login/index');
		}
	}

	private function alert($open_tag = null, $close_tag = null, $data = null)
	{
		//buat nampilin alert
		if ($data != null) $data = $open_tag . $data . $close_tag;

		return $data;
		//contoh : $this->alert('<h1>','</h1>','Hello world'); Output : <h1>Hello World</h1>
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
		$data['salary_types'] = $this->SalaryTypeModel->all();
		$this->template('salarytype/list', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'name' => $this->input->post('name'),
				'status' => $this->input->post('status'),
				'type' => $this->input->post('type'),
			);

			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			$this->form_validation->set_rules('type', 'Tipe Gaji', 'required');

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					// Kalau ga ada id insert data
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->SalaryTypeModel->insert($post_data)) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Tipe gaji berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('salarytype');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan Tipe gaji..");
					}
				} else {
					// Kalau ada id update data
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->SalaryTypeModel->update($post_data, array('id' => $this->input->post('id')))) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Tipe gaji berhasil di update..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('salarytype');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate Tipe gaji..");
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

		$salary_type = array(
			'1' => 'Penambahan',
			'2' => 'Pengurangan',
		);

		$data = array(
			'data' => $this->SalaryTypeModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'status' => $status,
			'type' => $salary_type
		);

		$this->template('salarytype/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->SalaryTypeModel->delete(array('id' => $this->uri->segment(3)))) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data potongan/tambahan gaji berhasil dihapus..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);

				redirect('salarytype');
			}
		}
	}
}

