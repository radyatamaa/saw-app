<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	//membuat atribut alert 
	private $alert = '';

	public $js_default = 'js_datatable';
	public $css_default = 'css_datatable';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('UserModel');
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

		$this->load->view('template', $data);
	}

	public function index()
	{
		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}
		$data['users'] = $this->UserModel->all();
		$this->template('user/list', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
			);

			$this->form_validation->set_rules('name', 'Nama', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

			if ($this->input->post('id') == '') {
				$this->form_validation->set_rules('password', 'Password', 'required');
				$post_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
			} else {
				$this->form_validation->set_rules('password', '');
			}

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					// Kalau ga ada id insert data
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->UserModel->insert($post_data)) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data user berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('user');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data user..");
					}
				} else {
					// Kalau ada id update data
					$post_data['updated_at'] = date('Y-m-d H:i:s');
					if (!empty($this->input->post('password'))) {
						$post_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
					}

					if ($this->UserModel->update($post_data, array('id' => $this->input->post('id')))) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data user berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('user');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate data user..");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}

		}

		$data = array(
			'data' => $this->UserModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
		);

		$this->template('user/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->UserModel->delete(array('id' => $this->uri->segment(3)))) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data pengguna berhasil dihapus..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);

				redirect('user');
			}
		}
	}
}
