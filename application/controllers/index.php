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
    }
    
    /**
     * vehicle get method
     * 
     * @return json
     */
    function index()
    {
        $url_array = ['cgs_url' => site_url('cgs/vehicles?q={query}')];
        echo json_encode($url_array, true);
    }

}