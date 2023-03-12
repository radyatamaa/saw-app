<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//melakukan koneksi database
		$this->load->database();
	}

	public function all()
	{
		return $this->db->select('u.*')
			->where('deleted_at is null')
			->order_by('id desc')
			->get('users u');
	}

	public function mapping_user_position()
	{
		$sql = "SELECT
				(
						SELECT u.name
						FROM users u
						WHERE u.access = 1
						AND u.status = 1
						ORDER BY u.created_at desc
						LIMIT 1
				) as ketua,
				(
						SELECT u.name
						FROM users u
						WHERE u.access = 2
						AND u.status = 1
						ORDER BY u.created_at desc
						LIMIT 1
				) as wakil_ketua,
				(
						SELECT u.name
						FROM users u
						WHERE u.access = 3
						AND u.status = 1
						ORDER BY u.created_at desc
						LIMIT 1
				) as bendahara;";
		$query = $this->db->query($sql);
		return $query->row();
	}


	public function getWhere($where)
	{
		$this->db->where($where);
		return $this->db->get('users');
	}

	public function insert($data)
	{
		// melakukan insert ke tabel users
		return $this->db->insert('users', $data);
	}

	public function update($data, $where)
	{
		//melakukan update ke tabel users
		$this->db->where($where);
		return $this->db->update('users', $data);
	}

	public function delete($where)
	{
		//menghapus data pada tabel users sesuai kriteria
		$data = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		$this->db->where($where);
		return $this->db->update('users', $data);
	}

}
