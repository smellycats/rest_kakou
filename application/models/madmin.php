<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Madmin extends CI_Model
{
	private $kakou_db;
    /**
     * Construct a madmin instance
     *
     */
	public function __construct()
	{
		parent::__construct();

		$this->kakou_db = $this->load->database('kakou_db', TRUE);
	}
	
    /**
     * 查询IP限制
     * 
     * @return object
     */
	public function getIpAccess()
	{	
		$this->kakou_db->where('del', 0);
		$this->kakou_db->where('banned', 0);
		
		return $this->kakou_db->get('ip_access2');
	}

    /**
     * 根据用户名获取用户信息
     * 
     * @param string $username 用户名
     * @return object
     */
	function getUserByName($username)
	{
		$this->kakou_db->select('u.id as user_id');
		$this->kakou_db->select('u.username as user_name');
		$this->kakou_db->select('u.password');
		$this->kakou_db->select('r.id as role_id');
		$this->kakou_db->select('r.name as role_name');
		$this->kakou_db->select('r.rights as role_right');
		$this->kakou_db->select('r.openkakou as role_openkk');
		$this->kakou_db->select('u.banned as u_banned');
		$this->kakou_db->select('u.disabled as u_del');
		$this->kakou_db->select('r.disable as r_banned');
		$this->kakou_db->select('r.del as r_del');
		
		$this->kakou_db->where('u.disabled', 0);
		$this->kakou_db->where('r.del', 0);
		$this->kakou_db->where('u.username',$username);

		$this->kakou_db->from('users as u');
		$this->kakou_db->join('roles as r','u.role_id = r.id', 'inner');
		
		return $this->kakou_db->get();
	}

    /**
     * 修改用户登录信息
     * 
     * @param array $data 用户信息
     * @return object
     */
	function loginPlus($id, $data)
	{
		return $this->kakou_db->query("UPDATE users SET last_ip = '$data[last_ip]',last_login = '$data[last_login]',access_count = access_count + 1 WHERE id = $id");
	}

    /**
     * 添加用户登录日志
     * 
     * @param array $data 用户登录信息
     * @return object
     */
	function addAccessLog($data)
	{
		return $this->kakou_db->insert('access_log', $data);
	}
	
}
?>

