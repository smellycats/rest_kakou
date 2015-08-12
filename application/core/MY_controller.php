<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

/**
 * CodeIgniter Parsing Controller
 * 
 * url请求参数解析
 *
 * @package     CodeIgniter
 * @subpackage  Core
 * @category    Core
 * @author      Fire
*/
class Parsing_Controller extends REST_Controller
{
 
    public function __construct()
    {
        parent::__construct();
         
        $this->load->helper('kakou');

        $this->gets = $this->_getParams();
    }
     
    /**
     * 获取ulr请求参数
     *
     * @access private
     * @return void
     */
     private function _getParams()
     {
        $query_str = urldecode(str_replace('+', '%2B', $_SERVER["QUERY_STRING"]));

        return h_convertUrlQuery($query_str);
     }

 }