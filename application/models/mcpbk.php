<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcpbk extends CI_Model
{
	private $logo_db;
    /**
     * Construct a mlogo instance
     *
     */
	public function __construct()
	{
		parent::__construct();

		$this->logo_db = $this->load->database('logo_db', TRUE);
	}
	
    /**
     * 获取号牌颜色
     * 
     * @return object
     */
	public function getBkcp($cltx_id)
	{	
		$this->logo_db->select('*');
		$this->logo_db->where('cltx_id', $cltx_id);
		return $this->logo_db->get('cpbk');
	}
}