<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
	//membuat atribut alert
	private $alert = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('UserModel');
	}

	public function index()
	{
		$this->load->model('ProvinceModel');
		$this->load->model('CityModel');

		if ($this->input->post('simpan')) {

			$post_data = array(
				'province_id' => $this->input->post('province_id'),
				'city_id' => $this->input->post('city_id'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'name' => $this->input->post('name'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'birthdate' => $this->input->post('birthdate'),
				'status' => 1,
			);

			$this->form_validation->set_rules('province_id', 'Province', 'required');
			$this->form_validation->set_rules('city_id', 'City', 'required');
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('username', 'Name', 'required');

			if ($this->input->post('id') == '') {
				$this->form_validation->set_rules('password', 'Password', 'required');
			} else {
				$this->form_validation->set_rules('password', 'Password', '');
			}

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					// Kalau ga ada id insert data

					$post_data['created_at'] = date('Y-m-d');

					if ($this->UserModel->insert($post_data)) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "You Have Registered! Please login");
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Cannot Insert Data");
					}
				} else {
					// Kalau ada id update data

					$post_data['updated_at'] = date('Y-m-d');

					if ($this->UserModel->update($post_data, array('id' => $this->input->post('id')))) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "You Have Registered!");
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Cannot Registered");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Validataion Error");
			}

		}

		$data = array(
			'data' => $this->UserModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'provinces' => $this->ProvinceModel->get_ds(),
			'citys' => $this->CityModel->get_ds(),
		);

		$this->load->view('login/register', $data);
	}

	private function template($content, $data = null)
	{
		//method ini digunakan untuk memanggil template yang telah dibuat
		// untuk dapat digunakan pada method lainnya
		//parameter $content = lokasi file view pada folder View
		//parameter $data = data yang akan dimasukkan ke file view

		$data['content'] = $this->load->view($content, $data, true);

		$this->load->view('template', $data);
	}

	private function alert($open_tag = null, $close_tag = null, $data = null)
	{
		//buat nampilin alert
		if ($data != null) $data = $open_tag . $data . $close_tag;

		return $data;
		//contoh : $this->alert('<h1>','</h1>','Hello world'); Output : <h1>Hello World</h1>
	}
}
