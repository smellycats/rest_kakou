<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is vehicle info rest
 *
 * @package		CodeIgniter
 * @subpackage	Cgs Rest Server
 * @category	Controller
 * @author		Fire
*/


class Index extends CI_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();

        $this->load->helper('url');

        header('Cache-Control:public, max-age=60, s-maxage=60');
        header('Content-Type: application/json');
    }
    
    /**
     * vehicle get method
     * 
     * @return json
     */
    function index()
    {
        $url_array = [
            'v1_url' => site_url('v1')
        ];

        $json = json_encode($url_array, true);
        echo str_replace("\/", "/", $json);
    }

}