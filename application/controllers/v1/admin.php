<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is logo carinfo rest
 *
 * @package		CodeIgniter
 * @subpackage	Kakou Rest Server
 * @category	Controller
 * @author		Fire
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
#require APPPATH . '/libraries/REST_Controller.php';

class Admin extends Parsing_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Madmin');

        $this->load->helper('url');

        //header('Cache-Control:public, max-age=60, s-maxage=60');
        header('Content-Type: application/json');
    }

    /**
     * post user
     * 用户登录
     *
     * @return json
     */
    function login_post()
    {
        $query = $this->Madmin->getUserByName($this->post('username'));
        if ($query->num_rows() > 0) {
            $user = $query->row();
            if (sha1($this->post('password')) == $user->password and @$user->r_banned == 0 and @$user->u_banned == 0) {
                $this->response(array('user_id'=>$user->user_id, 'username'=>$user->user_name, 'role_id'=>$user->role_id, 'rolename'=>$user->role_name), 201);
            }
        }
        $this->response(array('username'=>$this->post('username'), 'message'=>'Unauthorized'), 401);
    }

    function test_post()
    {
        var_dump($this->input->post());
        var_dump('123');
        var_dump($this->post('username'));
    }

}