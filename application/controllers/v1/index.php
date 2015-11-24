<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Index
 *
 * This is v1 index
 *
 * @package     CodeIgniter
 * @subpackage  Index Rest Server
 * @category    Controller
 * @author      Fire
*/


class Index extends CI_Controller
{
    function __construct()
    {
        // Construct our parent class
        parent::__construct();

        $this->load->helper('url');

        header('Cache-Control:public, max-age=60, s-maxage=60');
        header('Content-Type: application/json; charset=utf-8');
    }
    
    /**
     * vehicle get method
     * 
     * @return json
     */
    function index()
    {
        $url_array = [
            'login_url' => site_url('v1/admin/login'),
            'hpys_url' => site_url('v1/logo/hpys'),
            'csys_url' => site_url('v1/logo/csys'),
            'hpzl_url' => site_url('v1/logo/hpzl'),
            'cllx_url' => site_url('v1/logo/cllx'),
            'fxbh_url' => site_url('v1/logo/fxbh'),
            'place_url' => site_url('v1/logo/place'),
            'kkdd_url' => site_url('v1/logo/kkdd'),
            'ppdm_url' => site_url('v1/logo/ppdm{/code}'),
            'carinfo_url' => site_url('v1/logo/carinfo{/id}'),
            'carinfos_url' => site_url('v1/logo/carinfos/q={query}{&page,per_page,sort,order}'),
            'fresh_url' => site_url('v1/logo/fresh?q={query}')
        ];

        $json = json_encode($url_array, true);
        echo str_replace("\/", "/", $json);
    }

}