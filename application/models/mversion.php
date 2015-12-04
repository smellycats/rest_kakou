<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mversion extends CI_Model
{
	private $v_db;
    /**
     * Construct a mcgs instance
     *
     */
	public function __construct()
	{
		parent::__construct();

		$this->v_db = $this->load->database('v_db', TRUE);
	}
	

	//添加版本信息
	public function addVersion($data)
	{
		return $this->v_db->insert('file_version', $data);
	}

	//获取最新版本信息
	public function getLatestVersion()
	{
		return $this->v_db->query('SELECT * FROM file_version ORDER BY id DESC LIMIT 1');
	}

}
?>