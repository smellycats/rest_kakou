<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlogo extends CI_Model
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
	public function getHpys()
	{	
		$this->logo_db->select('*');
		return $this->logo_db->get('platecolor');
	}

    /**
     * 获取号牌种类
     * 
     * @return object
     */
	public function getHpzl()
	{	
		$this->logo_db->select('hpzl.*');
		$this->logo_db->select('platecolor.color');
		$this->logo_db->join('platecolor', 'platecolor.id = hpzl.color_id');
		return $this->logo_db->get('hpzl');
	}

    /**
     * 获取车身颜色
     * 
     * @return object
     */
	public function getCsys()
	{	
		$this->logo_db->select('*');
		return $this->logo_db->get('csys');
	}

    /**
     * 获取车辆类型
     * 
     * @return object
     */
	public function getCllx()
	{	
		$this->logo_db->select('*');
		return $this->logo_db->get('cllx');
	}

    /**
     * 获取方向编号
     * 
     * @return object
     */
	public function getFxbh()
	{	
		$this->logo_db->select('id, dire as name');
		return $this->logo_db->get('directions');
	}

    /**
     * 获取卡口地点
     * 
     * @return object
     */
	public function getPlace()
	{	
		$this->logo_db->select('*');
		$this->logo_db->where('banned', 0);
		$this->logo_db->where('id >', 1);
		return $this->logo_db->get('places');
	}

    /**
     * 获取品牌代码
     * 
     * @return object
     */
	public function getPpdm()
	{	
		$this->logo_db->select('*');
		return $this->logo_db->get('ppdm');
	}

    /**
     * 获取子品牌代码
     * 
     * @param string $code 主品牌代码（3位）
     * @return object
     */
	public function getPpdmByCode($code)
	{
		$this->logo_db->select('*');
		$this->logo_db->where('clpp1', $code);
		$this->logo_db->where('banned', 0);
		return $this->logo_db->get('clpp2_dict');
	}

    /**
     * 根据id获取车辆信息
     * 
     * @param int $id carinfo表id
     * @return object
     */
	public function getCarinfoById($id)
	{
		$this->logo_db->select('i.id');
		$this->logo_db->select('i.passtime as jgsj');
		$this->logo_db->select('i.cltx_hphm as hphm');
		$this->logo_db->select('i.cltx_id');
		$this->logo_db->select('i.cltx_lane as cdbh');
		$this->logo_db->select('i.ppdm');
		$this->logo_db->select('i.ppdm2');
		$this->logo_db->select('i.kxd');
		$this->logo_db->select('i.img_ip');
		$this->logo_db->select('i.img_disk');
		$this->logo_db->select('i.img_path');
		$this->logo_db->select('m.name as clpp');
		$this->logo_db->select('i.cltx_place as place_id');
		$this->logo_db->select('p.place as place');
		$this->logo_db->select('i.cltx_color as hpys_id');
		$this->logo_db->select('s.color as hpys');
		$this->logo_db->select('i.cllx as cllx_code');
		$this->logo_db->select('c.name as cllx');
		$this->logo_db->select('i.cltx_dire as fxbh_id');
		$this->logo_db->select('d.dire as fxbh');
		$this->logo_db->select('i.hpzl as hpzl_code');
		$this->logo_db->select('i.csys as csys_code');
		$this->logo_db->select('y.name as csys');

		$this->logo_db->join('ppdm as m', 'i.ppdm = m.code');
		$this->logo_db->join('places as p', 'i.cltx_place = p.id', 'left');
		$this->logo_db->join('cllx as c', 'i.cllx = c.code', 'left');
		$this->logo_db->join('platecolor as s', 'i.cltx_color = s.id', 'left');
		$this->logo_db->join('directions as d', 'i.cltx_dire = d.id', 'left');
		$this->logo_db->join('csys as y','i.csys = y.code', 'left');
		$this->logo_db->where('i.id', $id);
		return $this->logo_db->get('carinfo as i');
	}

    /**
     * 获取最新车辆信息
     * 
     * @param array $data 查询条件数组
     * @param int   $offset 偏移量
     * @param int   $limit 行数
     * @return object
     */
	public function getFresh($data, $offset=0, $limit=10)
	{
		$this->logo_db->select('i.id');
		$this->logo_db->select('i.passtime as jgsj');
		$this->logo_db->select('i.cltx_hphm as hphm');
		$this->logo_db->select('i.cltx_id');
		$this->logo_db->select('i.cltx_lane as cdbh');
		$this->logo_db->select('i.ppdm');
		$this->logo_db->select('i.ppdm2');
		$this->logo_db->select('i.kxd');
		$this->logo_db->select('i.img_ip');
		$this->logo_db->select('i.img_disk');
		$this->logo_db->select('i.img_path');
		$this->logo_db->select('m.name as clpp');
		$this->logo_db->select('i.cltx_place as place_id');
		$this->logo_db->select('p.place as place');
		$this->logo_db->select('i.cltx_color as hpys_id');
		$this->logo_db->select('s.color as hpys');
		$this->logo_db->select('i.cllx as cllx_code');
		$this->logo_db->select('c.name as cllx');
		$this->logo_db->select('i.cltx_dire as fxbh_id');
		$this->logo_db->select('d.dire as fxbh');
		$this->logo_db->select('i.hpzl as hpzl_code');
		$this->logo_db->select('i.csys as csys_code');
		$this->logo_db->select('y.name as csys');

		$this->logo_db->join('ppdm as m', 'i.ppdm = m.code');
		$this->logo_db->join('places as p', 'i.cltx_place = p.id', 'left');
		$this->logo_db->join('cllx as c', 'i.cllx = c.code', 'left');
		$this->logo_db->join('platecolor as s', 'i.cltx_color = s.id', 'left');
		$this->logo_db->join('directions as d', 'i.cltx_dire = d.id', 'left');
		$this->logo_db->join('csys as y','i.csys = y.code', 'left');
		if (isset($data['id'])) {
			$this->logo_db->where('i.id >', $data['id']);
		}
		if (isset($data['place'])) {
			$this->logo_db->where('i.cltx_place', $data['place']);
		}
		if (isset($data['fxbh'])) {
			$this->logo_db->where('i.cltx_dire', $data['fxbh']);
		}

		if (isset($data['match'])) {
			if ($data['match'] == 1) {
				$this->logo_db->where('');
			} else {
				$this->logo_db->where('');
			}
		}
		$this->logo_db->order_by('i.id', 'desc');
		return $this->logo_db->get('carinfo as i', $limit, $offset);
	}

    /**
     * 根据用户id获取最新车辆信息
     * 
     * @param int $user_id 用户id
     * @return object
     */
	public function getFreshByUserId($user_id)
	{
		$this->logo_db->select('*');
		$this->logo_db->where('user_id', $user_id);
		return $this->logo_db->get('fresh');
	}

    /**
     * 添加fresh表信息
     * 
     * @param array $data 添加信息
     * @return object
     */
	public function addFresh($data)
	{
		return $this->logo_db->insert('fresh', $data);
	}

    /**
     * 根据用户id修改fresh
     * 
     * @param int   $user_id 用户ID
     * @param array $data 修改信息
     * @return object
     */
	public function setFresh($user_id, $data)
	{
		$this->logo_db->where('user_id', $user_id);
		return $this->logo_db->update('fresh', $data);
	}

}
?>

