<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DBTransactionModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function startDBTransaction($is_test_mode = false)
	{
		return $this->db->trans_begin();
	}

	public function checkDBTransaction()
	{
		return $this->db->trans_status();
	}

	public function rollbackDBTransaction()
	{
		return $this->db->trans_rollback();
	}

	public function commitDBTransaction()
	{
		return $this->db->trans_commit();
	}
}
