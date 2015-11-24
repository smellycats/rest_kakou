<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcltx extends CI_Model
{
	private $orc_db;
    /**
     * Construct a mcgs instance
     *
     */
	public function __construct()
	{
		parent::__construct();

		$this->orc_db = $this->load->database('orc_db', TRUE);
	}
	

	//根据条件获取车辆信息
	public function getCltx($data)
	{
		return $this->orc_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss') AS passtime FROM cltx t WHERE id > $data[id] AND id <= $data[last_id] ORDER BY id" );
	}

	//根据条件获取车辆信息
	public function getCltx2($data, $limit = 20)
	{
		$maxid = $data[id] + $limit;

		return $this->orc_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss') AS passtime FROM cltx WHERE id >= $data[id] AND id < $maxid" );

	}

	//根据条件获取车辆信息
	public function getLastCltx($limit = 20)
	{
		return $this->orc_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss') AS passtime FROM cltx WHERE ROWNUM <= $limit ORDER BY id DESC" );
	}

    /**
     * 根据id获取车辆信息
     * 
     * @param int $id cltx表ID
     * @return object
     */
	public function getCltxById($id)
	{
		return $this->orc_db->query("SELECT t.*, to_char(jgsj, 'yyyy-mm-dd hh24:mi:ss') AS passtime FROM cltx t WHERE id = $id");
	}


    /**
     * 获取cltx表最大ID
     * 
     * @return object
     */
	public function getCltxMaxId()
	{
		return $this->orc_db->query("SELECT max(id) as maxid FROM cltx");
	}

    /**
     * 获取车流量
     * 
     * @return object
     */
	public function getCltxNum($data)
	{
		$sqlstr = '';
		// 最小速度
		if (isset($data['fxbh'])) {
			$sqlstr = $sqlstr . " AND fxbh = '$data[fxbh]'";
		}
		return $this->orc_db->query("SELECT count(*) AS sum FROM cltx WHERE jgsj >= to_date('$data[st]','yyyy-mm-dd hh24:mi:ss') AND jgsj < to_date('$data[et]','yyyy-mm-dd hh24:mi:ss') AND kkdd = '$data[kkdd]'" . $sqlstr);
	}

}
?>

