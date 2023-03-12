<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlternativeValue extends CI_Controller
{

	public $js_default = 'js_datatable';

	public $css_default = 'css_datatable';


	private $alert = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('AlternativeValueModel');
		$this->load->model('AlternativeValueDetailModel');
		$this->load->model('AlternativeModel');
		$this->load->model('PeriodModel');
		$this->load->model('CriteriaModel');
		$this->load->model('SubCriteriaModel');
		$this->load->model('DBTransactionModel');
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
		$start_date = isset($_REQUEST["start_date"]) ? $_REQUEST["start_date"] : "";
		$end_date = isset($_REQUEST["end_date"]) ? $_REQUEST["end_date"] : "";
		$period_id = isset($_REQUEST["period_id"]) ? $_REQUEST["period_id"] : "";
		$alternative_name = isset($_REQUEST["alternative_name"]) ? $_REQUEST["alternative_name"] : "";
		$alternative_email = isset($_REQUEST["alternative_email"]) ? $_REQUEST["alternative_email"] : "";
		$alternative_phone = isset($_REQUEST["alternative_phone"]) ? $_REQUEST["alternative_phone"] : "";

		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}

		$periods = $this->PeriodModel->getActivePeriod();

		$periods_detail[0] = '-Pilih Periode-';
		foreach ($periods as $i => $v) {
			$periods_detail[$i] = $v;
		}

		$periods = $periods_detail;

		$data['alternative_values'] = $this->AlternativeValueModel->all($start_date, $end_date, $period_id, $alternative_name, $alternative_email, $alternative_phone);
		$data['periods'] = $periods;
		$this->template('alternative-value/list', $data);
	}

	public function get_detail_json()
	{
		header('Content-Type: application/json');

		$alternative_value_id = $this->input->get('id');

		$data = $this->get_detail_by_id($alternative_value_id);
		$data_json = json_encode($data);
		echo $data_json;
	}

	public function print_alternative_value_with_detail($alternative_value_id)
	{
		if ($alternative_value_id != "" || !empty($alternative_value_id)) {
			$data = $this->get_detail_by_id($alternative_value_id);
			return $this->load->view('alternative-value/print', $data);
		}

		redirect('alternative-value');
	}

	private function get_detail_by_id($alternative_value_id) {
		$data = array();
		$alternative_value_detail = array();

		$alternative_value = $this->AlternativeValueModel->get_detail($alternative_value_id)->row();
		$criterias = $this->CriteriaModel->all()->result();
		foreach ($criterias as $key => $value) {
			$alternative_value_detail[$key]['criteria_id'] = $value->id;
			$alternative_value_detail[$key]['criteria_name'] = $value->name;
			$alternative_value_detail[$key]['criteria_type'] = $value->type;
			$criteria_type_str = 'Benefit';
			if ($value->type == CriteriaModel::TYPE_COST) {
				$criteria_type_str = 'Cost';
			}
			$alternative_value_detail[$key]['criteria_type_str'] = $criteria_type_str;
			$alternative_value_detail[$key]['weight_criteria'] = $value->weight;

			$detail = $this->AlternativeValueDetailModel->getWithCriteriaByAlternativeValueID($alternative_value_id, $value->id)->row();

			$alternative_value_detail_id = empty($detail->id) ? null : $detail->id;
			$alternative_val_id =  empty($detail->alternative_value_id) ? null : $detail->alternative_value_id;
			$sub_criteria_id = empty($detail->sub_criteria_id) ? null : $detail->sub_criteria_id;
			$sub_criteria_name = empty($detail->sub_criteria_name) ? '-' : $detail->sub_criteria_name;
			$point_sub_criteria = empty($detail->point_sub_criteria) ? null : $detail->point_sub_criteria;

			$alternative_value_detail[$key]['id'] = $alternative_value_detail_id;
			$alternative_value_detail[$key]['alternative_value_id'] = $alternative_val_id;
			$alternative_value_detail[$key]['sub_criteria_id'] = $sub_criteria_id;
			$alternative_value_detail[$key]['sub_criteria_name'] = $sub_criteria_name;
			$alternative_value_detail[$key]['point_sub_criteria'] = $point_sub_criteria;
		}

		$data['alternative_value'] = $alternative_value;
		$data['alternative_value_detail'] = $alternative_value_detail;

		return $data;
	}

	public function update()
	{
		if ($this->input->post('update')) {
			$post_data = array(
				'criteria_ids' => $this->input->post('criteria_ids'),
				'sub_criteria_ids' => $this->input->post('sub_criteria_ids'),
			);

			$alternative_value_id = $this->input->post('id');
			if ($alternative_value_id != '') {
				$this->DBTransactionModel->startDBTransaction();

				$alternative_value_update = array(
					'user_id' => $this->session->userdata('id'),
					'updated_at' => date('Y-m-d H:i:s'),
				);

				if ($this->AlternativeValueModel->update($alternative_value_update, array('id' => $alternative_value_id))) {
					foreach ($post_data['criteria_ids'] as $key => $value) {
						$criteria_detail = $this->CriteriaModel->getWhere(array('id' => $value))->result();

						if ($value) {
							if ($post_data['sub_criteria_ids'][$key] == 0) {
								$this->DBTransactionModel->rollbackDBTransaction();

								$criteria_name = $criteria_detail[0]->name;
								$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Nilai Crips dari Kriteria '$criteria_name' belum di isi..");

								$data = array(
									'alert' => $this->alert,
								);
								$this->session->set_flashdata('data', $data);
								redirect('alternativevalue');
							}
						}

						$sub_criteria_detail = $this->SubCriteriaModel->getWhere(array('id' => $post_data['sub_criteria_ids'][$key]))->result();

						$alternative_value_detail = $this->AlternativeValueDetailModel->getByAlternativeValueIDAndCriteriaID($alternative_value_id, $value)->row_array();
						if (!empty($alternative_value_detail)) {
							// update alternative value detail
							if (!empty($sub_criteria_detail)) {
								$alternative_value_detail_update = array(
									'criteria_id' => $value,
									'criteria_name' => empty($criteria_detail[0]->name) ? '' : $criteria_detail[0]->name,
									'weight_criteria' => empty($criteria_detail[0]->weight) ? 0 : $criteria_detail[0]->weight,
									'sub_criteria_id' => empty($post_data['sub_criteria_ids'][$key]) ? null : $post_data['sub_criteria_ids'][$key],
									'sub_criteria_name' => empty($sub_criteria_detail[0]->name) ? '' : $sub_criteria_detail[0]->name,
									'point_sub_criteria' => empty($sub_criteria_detail[0]->point) ? '' : $sub_criteria_detail[0]->point,
									'updated_at' => date('Y-m-d H:i:s'),
								);
								if (!$this->AlternativeValueDetailModel->update($alternative_value_detail_update, array('id' => $alternative_value_detail['id']))) {
									$this->DBTransactionModel->rollbackDBTransaction();
									$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal Mengubah Nilai Crips Alternatif..");

									$data = array(
										'alert' => $this->alert,
									);
									$this->session->set_flashdata('data', $data);
									redirect('alternativevalue');
								}

							} else {
								$this->DBTransactionModel->rollbackDBTransaction();

								$criteria_name = $criteria_detail[0]->name;
								$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Data Crips dari Kriteria $criteria_name tidak ditemukan..");

								$data = array(
									'alert' => $this->alert,
								);
								$this->session->set_flashdata('data', $data);
								redirect('alternativevalue');
							}
						} else {
							// insert alternative value detail
							if (!empty($sub_criteria_detail)) {
								$alternative_value_detail_insert = array(
									'alternative_value_id ' => $alternative_value_id,
									'criteria_id' => $value,
									'criteria_name' => empty($criteria_detail[0]->name) ? '' : $criteria_detail[0]->name,
									'weight_criteria' => empty($criteria_detail[0]->weight) ? 0 : $criteria_detail[0]->weight,
									'sub_criteria_id' => empty($post_data['sub_criteria_ids'][$key]) ? null : $post_data['sub_criteria_ids'][$key],
									'sub_criteria_name' => empty($sub_criteria_detail[0]->name) ? '' : $sub_criteria_detail[0]->name,
									'point_sub_criteria' => empty($sub_criteria_detail[0]->point) ? '' : $sub_criteria_detail[0]->point,
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s'),

								);
								if (!$this->AlternativeValueDetailModel->insert($alternative_value_detail_insert)) {
									$this->DBTransactionModel->rollbackDBTransaction();
									$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal Menyimpan Nilai Crips Alternatif..");

									$data = array(
										'alert' => $this->alert,
									);
									$this->session->set_flashdata('data', $data);
									redirect('alternativevalue');
								}
							} else {
								$this->DBTransactionModel->rollbackDBTransaction();

								$criteria_name = $criteria_detail[0]->name;
								$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Data Crips dari Kriteria $criteria_name tidak ditemukan..");

								$data = array(
									'alert' => $this->alert,
								);
								$this->session->set_flashdata('data', $data);
								redirect('alternativevalue');
							}
						}
					}

					if (!$this->DBTransactionModel->checkDBTransaction()) {
						$this->DBTransactionModel->rollbackDBTransaction();
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal Mengubah Nilai Alternatif pada Database..");
					} else {
						$this->DBTransactionModel->commitDBTransaction();

						$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Nilai Alternatif berhasil diubah..");

						$data = array(
							'alert' => $this->alert,
						);
						$this->session->set_flashdata('data', $data);
						redirect('alternativevalue');
					}
				} else {
					$this->DBTransactionModel->rollbackDBTransaction();
					$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal Mengubah Nilai Alternatif...");
				}
			}
		}

		$criteria = $this->CriteriaModel->getActiveCriteriaDetailForUpdate();

		foreach ($criteria as $key => $value) {
			$sub_criterias = $value['sub_criterias'];

			$sub_criterias_detail = array();
			$sub_criterias_detail[0] = '-Pilih Nilai Crips-';
			foreach ($sub_criterias as $i => $v) {
				$sub_criterias_detail[$i] = $v;
			}

			$criteria[$key]['sub_criterias'] = $sub_criterias_detail;
		}

		$data = array(
			'data' => $this->AlternativeValueModel->getAlternativeValueWithDetail($this->uri->segment(3)),
			'alert' => $this->alert,
			'criterias' => $criteria,
			'alternative' => $this->AlternativeModel->getActiveAlternative(),
			'period' => $this->PeriodModel->getActivePeriod(),
		);

		$this->template('alternative-value/form_edit', $data);
	}

	public function form()
	{
		if ($this->input->post('save')) {
			$post_data = array(
				'period_id' => $this->input->post('period_id'),
				'alternative_id' => $this->input->post('alternative_id'),
				'criteria_ids' => $this->input->post('criteria_ids'),
				'sub_criteria_ids' => $this->input->post('sub_criteria_ids'),
			);

			$this->form_validation->set_rules('period_id', 'Periode', 'required');
			$this->form_validation->set_rules('alternative_id', 'Alternatif', 'required');
			if ($this->form_validation->run()) {
				if ($this->input->post('id') == '') {
					$this->DBTransactionModel->startDBTransaction();
					$period_detail = $this->PeriodModel->getWhere(array('id' => $post_data['period_id']))->result();
					$alternative_value_insert = array(
						'user_id' => $this->session->userdata('id'),
						'alternative_id' => $post_data['alternative_id'],
						'period_id' => $post_data['period_id'],
						'period_name' => empty($period_detail[0]->name) ? '' : $period_detail[0]->name,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),

					);
					$alternative_value_id = $this->AlternativeValueModel->insert($alternative_value_insert);
					if (!empty($alternative_value_id) || $alternative_value_id != 0 || $alternative_value_id != "") {
						foreach ($post_data['criteria_ids'] as $key => $value) {
							$criteria_detail = $this->CriteriaModel->getWhere(array('id' => $value))->result();

							if ($value) {
								if ($post_data['sub_criteria_ids'][$key] == 0) {
									$this->DBTransactionModel->rollbackDBTransaction();

									$criteria_name = $criteria_detail[0]->name;
									$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Nilai Crips dari Kriteria '$criteria_name' belum di isi..");

									$data = array(
										'alert' => $this->alert,
									);
									$this->session->set_flashdata('data', $data);
									redirect('alternativevalue');
								}

								$sub_criteria_detail = $this->SubCriteriaModel->getWhere(array('id' => $post_data['sub_criteria_ids'][$key]))->result();
								if (!empty($sub_criteria_detail)) {
									$alternative_value_detail_insert = array(
										'alternative_value_id ' => $alternative_value_id,
										'criteria_id' => $value,
										'criteria_name' => empty($criteria_detail[0]->name) ? '' : $criteria_detail[0]->name,
										'weight_criteria' => empty($criteria_detail[0]->weight) ? 0 : $criteria_detail[0]->weight,
										'sub_criteria_id' => empty($post_data['sub_criteria_ids'][$key]) ? null : $post_data['sub_criteria_ids'][$key],
										'sub_criteria_name' => empty($sub_criteria_detail[0]->name) ? '' : $sub_criteria_detail[0]->name,
										'point_sub_criteria' => empty($sub_criteria_detail[0]->point) ? '' : $sub_criteria_detail[0]->point,
										'created_at' => date('Y-m-d H:i:s'),
										'updated_at' => date('Y-m-d H:i:s'),

									);
									if (!$this->AlternativeValueDetailModel->insert($alternative_value_detail_insert)) {
										$this->DBTransactionModel->rollbackDBTransaction();
										$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan Nilai Alternatif..");

										$data = array(
											'alert' => $this->alert,
										);
										$this->session->set_flashdata('data', $data);
										redirect('alternativevalue');
									}
								} else {
									$this->DBTransactionModel->rollbackDBTransaction();

									$criteria_name = $criteria_detail[0]->name;
									$this->alert = $this->alert("<p class='alert alert-warning'>", "</p>", "Data Crips dari Kriteria $criteria_name tidak ditemukan..");

									$data = array(
										'alert' => $this->alert,
									);
									$this->session->set_flashdata('data', $data);
									redirect('alternativevalue');
								}
							}
						}

						if (!$this->DBTransactionModel->checkDBTransaction()) {
							$this->DBTransactionModel->rollbackDBTransaction();
							$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal Menyimpan Nilai Alternatif pada Database..");
						} else {
							$this->DBTransactionModel->commitDBTransaction();

							$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Nilai Alternatif berhasil disimpan..");

							$data = array(
								'alert' => $this->alert,
							);
							$this->session->set_flashdata('data', $data);
							redirect('alternativevalue');
						}
					} else {
						$this->DBTransactionModel->rollbackDBTransaction();
						$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal menyimpan Nilai Alternatif...");
					}
				}
			} else {
				$this->alert = $this->alert("<p class='alert alert-danger'>", "</p>", "Gagal validasi..");
			}

		}

		$criteria = $this->CriteriaModel->getActiveCriteriaWithSubCriteria();

		foreach ($criteria as $key => $value) {
			$sub_criterias = $value['sub_criterias'];

			$sub_criterias_detail = array();
			$sub_criterias_detail[0] = '-Pilih Nilai Crips-';
			foreach ($sub_criterias as $i => $v) {
				$sub_criterias_detail[$i] = $v;
			}

			$criteria[$key]['sub_criterias'] = $sub_criterias_detail;
		}

		$data = array(
			'criterias' => $criteria,
			'alternative' => $this->AlternativeModel->getActiveAlternative(),
			'period' => $this->PeriodModel->getActivePeriod(),
			'data' => $this->AlternativeValueModel->getWhere(array('id' => $this->uri->segment(3)))->row_array(),
			'alert' => $this->alert,
		);

		$this->template('alternative-value/form', $data);
	}

	public function delete()
	{
		if ($this->uri->segment(3)) {
			$this->AlternativeValueModel->delete(array('id' => $this->uri->segment(3)));
			$this->AlternativeValueDetailModel->delete(array('alternative_value_id' => $this->uri->segment(3)));

			$this->alert = $this->alert("<p class='alert alert-success'>", "</p>", "Data nilai alternatif berhasil dihapus..");
			$data = array(
				'alert' => $this->alert,
			);
			$this->session->set_flashdata('data', $data);
			redirect('alternativevalue');
		}
	}
}

