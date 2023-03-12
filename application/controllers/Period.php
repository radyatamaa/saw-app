<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Period extends CI_Controller
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
		$this->load->model('PeriodModel');
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

	public function export_template_excel()
	{
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "No");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "Periode");

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "1");
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Contoh Nama Periode");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Template Excel Input Periode.xlsx"');
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
					$period = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$temp_data[] = array(
						'name' => $period,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					);
				}
			}

			if ($this->PeriodModel->insert_batch($temp_data)) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data periode berhasil disimpan..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);
				redirect('period');
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data periode..");
			}
		} else {
			$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Tidak ada file excel yang di upload..");

			$data = array(
				'alert' => $this->alert,
			);
			$this->session->set_flashdata('data', $data);
			redirect('period');
		}
	}

	public function index()
	{
		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}
		$data['periods'] = $this->PeriodModel->all();
		$this->template('period/list', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'name' => $this->input->post('name'),
			);

			$this->form_validation->set_rules('name', 'Nama', 'required');

			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->PeriodModel->insert($post_data)) {
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data periode berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('period');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data periode..");
					}
				} else {
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->PeriodModel->update($post_data, array('id' => $this->input->post('id')))) {
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data periode berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('period');
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate data periode..");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}
		}

		$data = array(
			'data' => $this->PeriodModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
		);

		$this->template('period/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->PeriodModel->delete(array('id' => $this->uri->segment(3)))) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data periode berhasil dihapus..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);

				redirect('period');
			}
		}
	}
}

