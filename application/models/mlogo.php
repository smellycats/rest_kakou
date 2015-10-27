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
		return $this->logo_db->get('hpys');
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
		$this->logo_db->select('*');
		return $this->logo_db->get('fxbh');
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
		$this->logo_db->where('banned', 0);
		$this->logo_db->where('id <', 1000);
		return $this->logo_db->get('ppdm_list');
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
		$this->logo_db->where('ppdm', $code);
		$this->logo_db->where('banned', 0);
		return $this->logo_db->get('ppdm_list');
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
		$this->logo_db->select('s.name as hpys');
		$this->logo_db->select('s.code as hpys_code');
		$this->logo_db->select('i.cllx as cllx_code');
		$this->logo_db->select('c.name as cllx');
		$this->logo_db->select('i.cltx_dire as fxbh_id');
		$this->logo_db->select('d.name as fxbh');
		$this->logo_db->select('d.code as fxbh_code');
		$this->logo_db->select('i.hpzl as hpzl_code');
		$this->logo_db->select('i.csys as csys_code');
		$this->logo_db->select('y.name as csys');

		$this->logo_db->join('ppdm as m', 'i.ppdm = m.code');
		$this->logo_db->join('places as p', 'i.cltx_place = p.id', 'left');
		$this->logo_db->join('cllx as c', 'i.cllx = c.code', 'left');
		$this->logo_db->join('hpys as s', 'i.cltx_color = s.id', 'left');
		$this->logo_db->join('fxbh as d', 'i.cltx_dire = d.id', 'left');
		$this->logo_db->join('csys as y','i.csys = y.code', 'left');
		$this->logo_db->where('i.id', $id);
		return $this->logo_db->get('carinfo as i');
	}

    /**
     * 根据条件获取车辆信息
     * 
     * @param array $q 查询条件数组
     * @param int   $page 页数
     * @param int   $per_page 每页行数
     * @param int   $sort 排序字段
     * @param int   $order 排序方向
     * @return object
     */
	public function getCarinfos($q, $page, $per_page, $sort, $order)
	{
		$this->logo_db->join('ppdm as m', 'i.ppdm = m.code');
		$this->logo_db->join('places as p', 'i.cltx_place = p.id', 'left');
		$this->logo_db->join('cllx as c', 'i.cllx = c.code', 'left');
		$this->logo_db->join('hpys as s', 'i.cltx_color = s.id', 'left');
		$this->logo_db->join('fxbh as d', 'i.cltx_dire = d.id', 'left');
		$this->logo_db->join('csys as y','i.csys = y.code', 'left');

		$this->logo_db->where('i.passtime >=', $q['st']);  //开始时间
		$this->logo_db->where('i.passtime <=', $q['et']);  //结束时间
		// 品牌代码
		if (isset($q['ppdm'])) {
			$this->logo_db->like('i.ppdm2', $q['ppdm'], 'after');
		}
		// 卡口地点
		if (isset($q['place'])) {
			$this->logo_db->where('i.cltx_place', $q['place']);
		}
		// 方向
		if (isset($q['fxbh'])) {
			$this->logo_db->where('i.cltx_dire', $q['fxbh']);
		}
		// 号牌颜色
		if (isset($q['hpys'])) {
			switch ($q['hpys']) {
				case 'other':
				case '其他':
				case 'QT':
				case '1':
					$this->logo_db->where('i.cltx_color', 1);
					break;
				case 'blue':
				case '蓝':
				case 'BU':
				case '2':
					$this->logo_db->where('i.cltx_color', 2);
					break;
				case 'yellow':
				case '黄':
				case 'YL':
				case '3':
					$this->logo_db->where('i.cltx_color', 3);
					break;
				case 'white':
				case '白':
				case 'WT':
				case '4':
					$this->logo_db->where('i.cltx_color', 4);
					break;
				case 'black':
				case '黑':
				case 'BK':
				case '5':
					$this->logo_db->where('i.cltx_color', 5);
					break;
				default:
					break;
			}
		}
		// 号牌号码
		if (isset($q['hphm'])) {
			$hphm = strtoupper($q['hphm']);
			if ($hphm != 'NULL' and $q['hphm'] != '') {
				$this->logo_db->where('i.cltx_hphm like ', $hphm . '%');
			}
		}

		if ($per_page == 0){
			$this->logo_db->select('count(*) as sum');
			
			return $this->logo_db->get('carinfo as i');
		} else {
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
			$this->logo_db->select('s.name as hpys');
			$this->logo_db->select('s.code as hpys_code');
			$this->logo_db->select('i.cllx as cllx_code');
			$this->logo_db->select('c.name as cllx');
			$this->logo_db->select('i.cltx_dire as fxbh_id');
			$this->logo_db->select('d.name as fxbh');
			$this->logo_db->select('d.code as fxbh_code');
			$this->logo_db->select('i.hpzl as hpzl_code');
			$this->logo_db->select('i.csys as csys_code');
			$this->logo_db->select('y.name as csys');

			switch ($sort) {
				case 'id':
					$s = 'i.id';
					break;
				case 'ppdm':
					$s = 'i.ppdm2';
					break;
				case 'jgsj':
					$s = 'i.passtime';
					break;
				default:
					$s = 'i.id';
			}
			switch ($order) {
				case 'desc':
					$o = 'desc';
					break;
				case 'asc':
					$o = 'asc';
					break;
				default:
					$o = 'desc';
			}
			$this->logo_db->order_by($s, $o);
			
			return $this->logo_db->get('carinfo as i', $per_page, ($page - 1) * $per_page);
		}
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
		$this->logo_db->select('s.name as hpys');
		$this->logo_db->select('s.code as hpys_code');
		$this->logo_db->select('i.cllx as cllx_code');
		$this->logo_db->select('c.name as cllx');
		$this->logo_db->select('i.cltx_dire as fxbh_id');
		$this->logo_db->select('d.name as fxbh');
		$this->logo_db->select('d.code as fxbh_code');
		$this->logo_db->select('i.hpzl as hpzl_code');
		$this->logo_db->select('i.csys as csys_code');
		$this->logo_db->select('y.name as csys');

		$this->logo_db->join('ppdm as m', 'i.ppdm = m.code');
		$this->logo_db->join('places as p', 'i.cltx_place = p.id', 'left');
		$this->logo_db->join('cllx as c', 'i.cllx = c.code', 'left');
		$this->logo_db->join('hpys as s', 'i.cltx_color = s.id', 'left');
		$this->logo_db->join('fxbh as d', 'i.cltx_dire = d.id', 'left');
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

