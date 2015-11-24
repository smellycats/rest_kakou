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

class Cpbk extends Parsing_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Mcpbk');
        $this->load->model('Mlogo');

        $this->load->helper('url');
        $this->load->helper('date');

        #header('Cache-Control: public, max-age=60, s-maxage=60');
        header('Content-Type: application/json; charset=utf-8');
    }

    function test_get()
    {
        echo json_encode(array('test'=> '123'));
    }

    /**
     * get bkcp
     * 获取最新车辆信息
     *
     * @return json
     */
    function bkcp_get()
    {
        $cltx_id = $this->uri->segment(4);
        $i = 0;
        while ($i < 300){
            $query = $this->Mcpbk->getBkcp($cltx_id);
            if ($query->num_rows() == 0){
                $i ++;
            } else {
                $carinfo_id = $query->row()->carinfo_id;
                $query2 = $this->Mlogo->getCarinfoById($carinfo_id);
                #var_dump($query2->num_rows());
                if ($query2->num_rows() == 0) {
                    break;
                } else {
                    $result = $query2->row_array();
                    $result['kkdd_id'] = (int)$result['place_id'];
                    $result['kkdd'] = $result['place'];
                    unset($result['img_ip']);
                    unset($result['img_disk']);
                    unset($result['img_path']);
                    header('HTTP/1.1 200 OK');
                    echo json_encode($result);
                    return;
                }
            }
            # 休眠100毫秒
            usleep(100000);
        }
        $this->response(array('error' => 'Cpbk could not be found'), 404);
    }
}