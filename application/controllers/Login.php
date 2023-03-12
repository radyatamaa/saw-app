<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

 public $js_default = 'js_dashboard';

 public $css_default = 'css_dashboard';


	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		$this->load->view('login/index');
	}

	public function in()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$query = $this->db->get("users WHERE email = '$email' AND deleted_at is null");
		$result = $query->row();

		if (empty($result)) {
			$data['message'] = 'Data user tidak di temukan..';
			return $this->load->view('login/index', $data);
		}

		if (!password_verify($password, $result->password)) {
			$data['message'] = 'Password tidak sesuai..';
			return $this->load->view('login/index', $data);
		}

		$this->session->set_userdata("id", $result->id);
		$this->session->set_userdata("name", $result->name);
		$this->session->set_userdata("email", $result->email);
		redirect('defaults/index');
	}

	public function out()
	{
		$this->session->sess_destroy();
		$this->load->view('login/index');
	}
}
