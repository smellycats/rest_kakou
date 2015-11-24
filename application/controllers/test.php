<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
#require APPPATH.'/libraries/REST_Controller.php';

class Test extends CI_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        #$this->load->model('Mcgs');
        // Configure limits on our controller methods. Ensure
        // you have created the 'limits' table and enabled 'limits'
        // within application/config/rest.php
        #$this->methods['user_get']['limit'] = 500; //500 requests per hour per user/key
        #$this->methods['user_post']['limit'] = 100; //100 requests per hour per user/key
        #$this->methods['user_delete']['limit'] = 50; //50 requests per hour per user/key
    }

    function index()
    {
        echo 'test';
    }

    function man()
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache');
        header('Pragma: no-cache');
        //header("HTTP/1.1 200 OK");
        echo json_encode([array('name' =>'jack', 'age'=>10),array('name' =>'ken', 'age'=>21)]);
    }
    
    function vehicles_get()
    {
        #$p = $this->input->get('p');
        #var_dump($p);
        #var_dump($_GET);
        var_dump($_SERVER['QUERY_STRING']);
        #$url = parse_str($_SERVER["QUERY_STRING"]);
        $str = str_replace('+', '%2B', $_SERVER['QUERY_STRING']);
        #$str = urldecode($new);
        #var_dump($str);
        parse_str($str, $output);
        var_dump(empty(@$output['p2']));
        var_dump($output);
        $r = explode(':', 'am');
        var_dump(@$data['hpys']);
        var_dump(['02','03']);
        #var_dump(explode(':', $r));
    }
    
    function user_post()
    {
        //$this->some_model->updateUser( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function user_delete()
    {
    	//$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function users_get()
    {
        //$users = $this->some_model->getSomething( $this->get('limit') );
        $users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
		);
        
        if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }


	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}

    public function test()
    {
        $this->load->driver('cache', ['adapter'=>'redis']);
        #$this->cache->redis->save('foo', 'bar', 120);
        //$data = array('hpys'=>'蓝', '车辆类型'=>'大型');
        #echo json_encode($data);
        $this->cache->redis->save('粤L12345,01', 1, 120);
        $this->cache->redis->save('粤L12345,03', 0, 120);
    }

    public function redis_get()
    {
        $this->load->driver('cache', ['adapter'=>'redis']);
        $data = $this->cache->redis->get('粤L12345,01');
        var_dump($data);
    }

    public function test2()
    {
        $email = 'yuxiaoxiao!example.com';
        $domain = strstr($email, '@');
        var_dump($domain);
        echo substr($domain, 1);
        //echo $domain; // 打印 @example.com
        $user = strstr($email, '@', true); // 从 PHP 5.3.0 起
        //echo $user; // 打印 yuxiaoxiao 
    }
}