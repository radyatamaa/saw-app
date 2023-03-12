<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Criteria extends CI_Controller
{
	//membuat atribut alert 
	private $alert = '';

	public $js_default = 'js_datatable';
	public $css_default = 'css_datatable';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library(array('excel', 'session'));
		$this->load->library('form_validation');
		$this->load->model('CriteriaModel');
		$this->load->model('SubCriteriaModel');
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

	public function export_template_excel()
	{
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "No");
		$excel->setActiveSheetIndex(0)->setCellValue('B1', "Nama Kriteria");
		$excel->setActiveSheetIndex(0)->setCellValue('C1', "Deskripsi Kriteria");
		$excel->setActiveSheetIndex(0)->setCellValue('D1', "Bobot Kriteria");
		$excel->setActiveSheetIndex(0)->setCellValue('E1', "Tipe Kriteria (benefit / cost)");

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "1");
		$excel->setActiveSheetIndex(0)->setCellValue('B2', "Contoh Nama Kriteria");
		$excel->setActiveSheetIndex(0)->setCellValue('C2', "Contoh Deskripsi Kriteria");
		$excel->setActiveSheetIndex(0)->setCellValue('D2', "10");
		$excel->setActiveSheetIndex(0)->setCellValue('E2', "benefit");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Template Excel Input Kriteria.xlsx"');
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
					$description = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$weight = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$type_req = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					if ($type_req == 'benefit') {
						$type = CriteriaModel::TYPE_BENEFIT;
					} else if ($type_req == 'cost') {
						$type = CriteriaModel::TYPE_COST;
					} else {
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Tipe Kriteria tidak diketahui..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('criteria');
					}

					$temp_data[] = array(
						'name' => $name,
						'description' => $description,
						'weight' => $weight,
						'type' => $type,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s')
					);

					// Prevent Total Weight All Criteria more than 100
					$criterias = $this->CriteriaModel->all();
					$total_weight = 0;
					foreach ($criterias->result_array() as $c) {
						$total_weight += $c['weight'];
					}

					if ($total_weight == CriteriaModel::MAX_WEIGHT) {
						$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Total Bobot sudah mencapai 100.");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('criteria');
					} else if ($total_weight + $weight > CriteriaModel::MAX_WEIGHT) {
						$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Input Total Bobot melebihi 100.");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('criteria');
					}
				}
			}

			if ($this->CriteriaModel->insert_batch($temp_data)) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data Kriteria berhasil disimpan..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);
				redirect('criteria');
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data kriteria..");
			}
		} else {
			$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Tidak ada file excel yang di upload..");

			$data = array(
				'alert' => $this->alert,
			);
			$this->session->set_flashdata('data', $data);
			redirect('criteria');
		}
	}

	public function index()
	{
		$data_save = $this->session->flashdata('data');
		if (!empty($data_save)) {
			$data['criteria_save'] = $data_save;
		}

		$criterias = $this->CriteriaModel->all();

		$total_weight = 0;
		foreach ($criterias->result_array() as $c) {
			$total_weight += $c['weight'];
		}

		$data['criterias'] = $criterias;
		$data['total_weight'] = $total_weight;
		$this->template('criteria/list', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'name' => $this->input->post('name'),
				'weight' => $this->input->post('weight'),
				'type' => $this->input->post('type'),
				'description' => $this->input->post('description'),
			);

			$this->form_validation->set_rules('name', 'Nama Kriteria', 'required');
			$this->form_validation->set_rules('weight', 'Bobot', 'required');

			if ($this->input->post('id') == '') {
				// Prevent Total Weight All Criteria more than 100
				$criterias = $this->CriteriaModel->all();
				$total_weight = 0;
				foreach ($criterias->result_array() as $c) {
					$total_weight += $c['weight'];
				}

				if ($total_weight == CriteriaModel::MAX_WEIGHT) {
					$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Total Bobot sudah mencapai 100.");

					$data = array(
						'alert' => $this->alert,
					);
					$this->session->set_flashdata('data', $data);
					redirect('criteria');
				} else if ($total_weight + $post_data['weight'] > CriteriaModel::MAX_WEIGHT) {
					$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Input Total Bobot melebihi 100.");
				}
			} else {
				// Prevent Total Weight All Criteria more than 100
				$criterias = $this->CriteriaModel->getWhere(array('id != ' => $this->input->post('id'), 'deleted_at is NULL' => null));
				$total_weight = 0;
				foreach ($criterias->result_array() as $c) {
					$total_weight += $c['weight'];
				}

				if ($total_weight + $post_data['weight'] > CriteriaModel::MAX_WEIGHT) {
					$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Input Total Bobot melebihi 100.");
				}
			}

			if ($this->form_validation->run() && $this->alert == '' || empty($this->alert)) {
				if ($this->input->post('id') == '') {
					// Kalau ga ada id insert data
					$post_data['created_at'] = date('Y-m-d H:i:s');
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->CriteriaModel->insert($post_data)) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data kriteria berhasil disimpan..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('criteria');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan data kriteria..");
					}
				} else {
					// Kalau ada id update data
					$post_data['updated_at'] = date('Y-m-d H:i:s');

					if ($this->CriteriaModel->update($post_data, array('id' => $this->input->post('id')))) {
						// Kalau sukses
						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data kriteria berhasil diupdate..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('criteria');
					} else {
						// Kalau gagal
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal mengupdate data kriteria..");
					}
				}
			} else if (!$this->form_validation->run()) {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}

		}

		$type = array(
			'1' => 'Benefit',
			'2' => 'Cost',
		);

		$data = array(
			'data' => $this->CriteriaModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
			'type' => $type
		);

		$this->template('criteria/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			if ($this->CriteriaModel->delete(array('id' => $this->uri->segment(3))) && $this->SubCriteriaModel->delete(array('criteria_id' => $this->uri->segment(3)))) {
				$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data kriteria berhasil dihapus..");

				$data = array(
					'alert' => $this->alert,
				);
				$this->session->set_flashdata('data', $data);

				redirect('criteria');
			}
		}
	}
}
