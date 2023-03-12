<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alternative extends CI_Controller
{

	public $js_default = 'js_datatable';

	public $css_default = 'css_datatable';


	private $alert = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library(array('excel', 'session'));
		$this->load->library('form_validation');
		$this->load->model('AlternativeModel');
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

	public function index()
	{
		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}
		$data['alternatives'] = $this->AlternativeModel->all();
		$this->template('alternative/list', $data);
	}

	public function export_template_excel()
	{
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "No");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "Nama");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "Perusahaan Sebelumnya");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "Jabatan Terakhir");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "No HP");
		$excel->setActiveSheetIndex(0)->setCellValue('F1', "Email");

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "1");
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Contoh Nama Alternative");
		$excel->setActiveSheetIndex(0)->setCellValue('C2', "Pt Bla Bla Bla");
		$excel->setActiveSheetIndex(0)->setCellValue('D2', "Direktur");
		$excel->setActiveSheetIndex(0)->setCellValue('E2', "085426857915");
		$excel->setActiveSheetIndex(0)->setCellValue('F2', "blablabla@gmail.com");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Template Excel Input Alternatif.xlsx"');
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}

	public function import_excel()
	{
		if (isset($_FILES["fileExcel"]["name"]) && $_FILES["fileExcel"]["name"] != "") {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			$temp_data = array();
			foreach ($object->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for ($row = 2; $row <= $highestRow; $row++) {
					$name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$previous_company = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$current_job_position = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$phone_number = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$email = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$temp_data[] = array(
						'name' => $name,
						'previous_company' => $previous_company,
						'phone_number' => $phone_number,
						'email' => $email,
						'current_job_position' => $current_job_position,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					);
				}
			}

			if ($this->AlternativeModel->insert_batch($temp_data)) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data alternatif berhasil disimpan..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);
				redirect('alternative');
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data alternatif..");
			}
		} else {
			$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Tidak ada file excel yang di upload..");

			$data = array(
				'alert' => $this->alert,
			);
			$this->session->set_flashdata('data', $data);
			redirect('alternative');
		}
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'name' => $this->input->post('name'),
				'previous_company' => $this->input->post('previous_company'),
				'phone_number' => $this->input->post('phone_number'),
				'email' => $this->input->post('email'),
				'current_job_position' => $this->input->post('current_job_position'),
			);

			$this->form_validation->set_rules('name', 'Nama', 'required');
			$this->form_validation->set_rules('previous_company', 'Perusahaan Sebelumnya', 'required');
			$this->form_validation->set_rules('phone_number', 'No HP', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('current_job_position', 'Jabatan Terakhir', 'required');

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->AlternativeModel->insert($post_data)) {
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data alternatif berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('alternative');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data alternatif..");
					}
				} else {
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->AlternativeModel->update($post_data, array('id' => $this->input->post('id')))) {
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data alternatif berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('alternative');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate data alternatif..");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}
		}

		$data = array(
			'data' => $this->AlternativeModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
		);

		$this->template('alternative/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->AlternativeModel->delete(array('id' => $this->uri->segment(3)))) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data alternatif berhasil dihapus..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);

				redirect('alternative');
			}
		}
	}
}

