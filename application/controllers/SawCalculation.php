<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SawCalculation extends CI_Controller
{

	public $js_default = 'js_datatable';
	public $css_default = 'css_datatable';

	private $alert = '';

	const ORDER_DIRECTION_ASC = "asc";
	const ORDER_DIRECTION_DESC = "desc";

	const ORDER_COLUMN_RANK = "rank";
	const ORDER_COLUMN_ALTERNATIVE_NAME = "alternative_name";
	const ORDER_COLUMN_ID = "id";

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library(array('excel', 'session'));
		$this->load->library('form_validation');
		$this->load->model('AlternativeValueModel');
		$this->load->model('AlternativeValueDetailModel');
		$this->load->model('AlternativeModel');
		$this->load->model('PeriodModel');
		$this->load->model('CriteriaModel');
		$this->load->model('SubCriteriaModel');

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

	public function print_result_saw_calculation_with_detail($period_id, $order_column = "", $order_direction = "")
	{
		if ($period_id != "" || !empty($period_id)) {
			$data = array();
			$period = $this->PeriodModel->getWhere(array('id' => $this->uri->segment(3)))->row();
			$detail = $this->getResultSAWCalculationByPeriodID($period_id, $order_column, $order_direction);

			$data['alternative_value_detail'] = $detail;
			$data['period'] = $period;
			return $this->load->view('saw-calculation/print_pdf', $data);
		}

		redirect('alternative-value');
	}

	public function getResultSAWCalculationByPeriodID($period_id, $order_column_req = "", $order_direction_req = "")
	{
		// criteria data
		$criterias = $this->CriteriaModel->getAllActiveCriteria($period_id);

		// alternative value data
		$alternative_values = array();
		if ($period_id != "" || $period_id > 0) {
			$alternative_values_tmp = $this->AlternativeValueModel->getAllByPeriodID($period_id, $order_column_req, $order_direction_req);
			foreach ($alternative_values_tmp as $key => $value) {
				$alternative_values[$key]['id'] = $value->id;
				$alternative_values[$key]['user_id'] = $value->user_id;
				$alternative_values[$key]['alternative_id'] = $value->alternative_id;
				$alternative_values[$key]['alternative_name'] = $value->alternative_name;
				$alternative_values[$key]['period_id'] = $value->period_id;
				$alternative_values[$key]['period_name'] = $value->period_name;
				$alternative_values[$key]['created_at'] = $value->created_at;
				$alternative_values[$key]['details'] = $this->getAlternativeValueDetails($value->id, $criterias);
			}
		}

		// calculate value, weight_value, total
		foreach ($alternative_values as $id => $alternative) {
			$total = 0;
			foreach ($alternative["details"] as $key => $sub_criteria) {
				$type = $criterias[$sub_criteria["criteria_id"]]["type"];
				$min = $criterias[$sub_criteria["criteria_id"]]["min_point_sub_criteria"];
				$max = $criterias[$sub_criteria["criteria_id"]]["max_point_sub_criteria"];
				$weight = $criterias[$sub_criteria["criteria_id"]]["weight"];

				$value = 0;
				if ($type == CriteriaModel::TYPE_BENEFIT && $sub_criteria["point_sub_criteria"] > 0) {
					$value = $sub_criteria["point_sub_criteria"] / $max;
				} else if ($type == CriteriaModel::TYPE_COST && $sub_criteria["point_sub_criteria"] > 0) {
					$value = $min / $sub_criteria["point_sub_criteria"];
				}
				$alternative_values[$id]["details"][$key]["value"] = round($value, 2);

				$weight_value = $weight * $value;
				$alternative_values[$id]["details"][$key]["weight_value"] = round($weight_value, 2);

				$total += $weight_value;
			}
			$alternative_values[$id]["total"] = round($total, 2);
		}

		// calculate rank
		$map_alternatif_rank = array();
		foreach ($alternative_values as $id => $alternative) {
			$map_alternatif_rank[$id] = $alternative["total"];
		}
		arsort($map_alternatif_rank);

		$rank = 1;
		foreach ($map_alternatif_rank as $id => $total) {
			$alternative_values[$id]["rank"] = $rank;
			$rank++;
		}

		if ($order_column_req == self::ORDER_COLUMN_RANK) {
			$alternative_value_with_rank = array();
			foreach ($alternative_values as $key) {
				$alternative_value_with_rank[$key['rank']] = $key;
			}

			if ($order_direction_req == self::ORDER_DIRECTION_ASC) {
				ksort($alternative_value_with_rank);
			}
			if ($order_direction_req == self::ORDER_DIRECTION_DESC) {
				krsort($alternative_value_with_rank);
			}

			return $alternative_value_with_rank;
		}

		return $alternative_values;
	}

	public function getAlternativeValueDetails($alternative_value_id, $criterias)
	{
		$details = array();
		foreach ($criterias as $key => $value) {
			$details[$key]['criteria_id'] = $value['id'];
			$details[$key]['criteria_name'] = $value['name'];
			$details[$key]['weight_criteria'] = $value['weight'];

			$detail = $this->AlternativeValueDetailModel->getWithCriteriaByAlternativeValueID($alternative_value_id, $value['id'])->row();

			$alternative_value_detail_id = empty($detail->id) ? null : $detail->id;
			$alternative_val_id = empty($detail->alternative_value_id) ? null : $detail->alternative_value_id;
			$sub_criteria_id = empty($detail->sub_criteria_id) ? null : $detail->sub_criteria_id;
			$sub_criteria_name = empty($detail->sub_criteria_name) ? '-' : $detail->sub_criteria_name;
			$point_sub_criteria = empty($detail->point_sub_criteria) ? 0 : $detail->point_sub_criteria;

			$details[$key]['id'] = $alternative_value_detail_id;
			$details[$key]['alternative_value_id'] = $alternative_val_id;
			$details[$key]['sub_criteria_id'] = $sub_criteria_id;
			$details[$key]['sub_criteria_name'] = $sub_criteria_name;
			$details[$key]['point_sub_criteria'] = $point_sub_criteria;
		}

		return $details;
	}

	public function index()
	{
		$data = array();
		$period_id = isset($_REQUEST["period_id"]) ? $_REQUEST["period_id"] : "";
		$order_column_req = isset($_REQUEST["order_column"]) ? $_REQUEST["order_column"] : "";
		$order_direction_req = isset($_REQUEST["order_direction"]) ? $_REQUEST["order_direction"] : "";
		$user_data_save = $this->session->flashdata('data');
		if (!empty($user_data_save)) {
			$data['user_save'] = $user_data_save;
		}

		// period data
		$periods = $this->PeriodModel->getActivePeriod();
		$periods_detail[0] = '-Pilih Periode-';
		foreach ($periods as $i => $v) {
			$periods_detail[$i] = $v;
		}
		$periods = $periods_detail;

		// criteria data
		$criterias = $this->CriteriaModel->getAllActiveCriteria($period_id);

		// get result SAW Calculation
		$result_calculation = $this->getResultSAWCalculationByPeriodID($period_id, $order_column_req, $order_direction_req);

		$order_column_opt = array(
			'empty' => 'Urutkan berdasarkan..',
			'rank' => 'Ranking',
			'alternative_name' => 'Nama Alternatif',
			'id' => 'ID',
		);

		$order_direction_opt = array(
			'empty' => 'Urutkan secara...',
			'asc' => 'Ascending',
			'desc' => 'Descending',
		);

		$data['order_column'] = $order_column_opt;
		$data['order_direction'] = $order_direction_opt;
		$data['periods'] = $periods;
		$data['criterias'] = $criterias;
		$data['alternative_values'] = $result_calculation;
		$this->template('saw-calculation/index', $data);
	}

}

