<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is vehicle info rest
 *
 * @package		CodeIgniter
 * @subpackage	Kakou Rest Server
 * @category	Controller
 * @author		Fire
 */

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . '/libraries/REST_Controller.php';

class Cltx extends Parsing_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Mcltx');

        //header('Cache-Control: public, max-age=60, s-maxage=60');
        header('Content-Type: application/json');
        header("HTTP/1.1 200 OK");
    }
    
    /**
     * vehicle get method
     * 
     * @return json
     */
    function infos_get()
    {
        $data = $this->input->get(NULL, true);

        if (empty(@$data['q'])) {
            $e = [array('resource'=>'Search', 'field'=>'q', 'code'=>'missing')];
            $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
        }
        $q = @json_decode($data['q'], true);
        if (empty($q)) {
            $e = [array('resource'=>'Search', 'field'=>'q', 'code'=>'invalid')];
            $this->response(array('message' => 'Body should be a JSON object', 'errors' => $e), 422);
        } else {
            if (empty(@$q['id'])) {
                $e = [array('resource'=>'Search', 'field'=>'q.id', 'code'=>'missing')];
                $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
            }
        }

        $result = $this->Mcgs->getCltx($q);
        if ($result) {
            $this->response(array('total_count'=> $result->num_rows(),
                                  'items'=> $result->result_array()), 200); // 200 being the HTTP response code
        } else {
            $this->response(array('message' => 'Database error'), 500);
        }
    }

    /**
     * 根据id获取车辆信息
     * 
     * @return json
     */
    function cltx_get()
    {
        $id = $this->url->segment(4);
        
        $query = $this->Mcltx->getCltxById($id);
        $row = $query->row_array();
        $result = array();
        $result['id']   = (int)$row['ID'];
        $result['hphm'] = $row['HPHM'];
        $result['jgsj'] = $row['PASSTIME'];
        $result['hpys'] = $row['HPYS'];
        $result['wzdd'] = $row['WZDD'];
        $result['fxbh'] = $row['FXBH'];
        $result['cdbh'] = (int)$row['CDBH'];
        $result['kkbh'] = $row['KKBH'];
        $result['clbj'] = $row['CLBJ'];
        $result['imgurl'] = "http://10.47.187.166/$row[QMTP]/"
                          . str_replace('\\', '/', $row['TJTP']);

        $json = json_encode($result);
        echo str_replace("\/", "/", $json);
    }

    /**
     * 根据id获取车辆信息
     * 
     * @return json
     */
    function cltxs_get()
    {
        $data['id'] = $this->uri->segment(4);
        $data['last_id'] = $this->uri->segment(5);
        
        $query = $this->Mcltx->getCltx($data);
        $results = $query->result_array();
        $items = [];
        foreach($results as $id => $row) {
            $items[$id]['id']   = (int)$row['ID'];
            $items[$id]['hphm'] = $row['HPHM'];
            $items[$id]['jgsj'] = $row['PASSTIME'];
            $items[$id]['hpys'] = $row['HPYS'];
            $items[$id]['wzdd'] = $row['WZDD'];
            $items[$id]['fxbh'] = $row['FXBH'];
            $items[$id]['cdbh'] = (int)$row['CDBH'];
            $items[$id]['kkbh'] = $row['KKBH'];
            $items[$id]['fxbh'] = $row['FXBH'];
            $items[$id]['clbj'] = $row['CLBJ'];
            $items[$id]['imgurl'] = "http://10.47.187.166/$row[QMTP]/"
                                  . str_replace('\\', '/', $row['TJTP']);
        }
        $json = json_encode(array('total_count' => $query->num_rows(), 'items' => $items));

        echo str_replace("\/", "/", $json);
    }


    /**
     * 获取cltx表最大ID
     * 
     * @return json
     */
    function cltxmaxid_get()
    {
        $query = $this->Mcltx->getCltxMaxId();
        $result = array('maxid' => (int)$query->row()->MAXID);

        echo json_encode($result);
    }

    /**
     * 根据条件获取车流量
     * 
     * @return json
     */
    function cltxmaxid2_get()
    {
        $data = $this->input->get(NULL, true);

        if (empty(@$data['q'])) {
            $e = [array('resource'=>'Search', 'field'=>'q', 'code'=>'missing')];
            $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
        }
        $q = @json_decode($data['q'], true);
        if (empty($q)) {
            $e = [array('resource'=>'Search', 'field'=>'q', 'code'=>'invalid')];
            $this->response(array('message' => 'Body should be a JSON object', 'errors' => $e), 422);
        } else {
            # 检测开始时间
            if (empty(@$q['st'])) {
                $e = [array('resource'=>'Search', 'field'=>'q.st', 'code'=>'missing')];
                $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
            }
            # 检测结束时间
            if (empty(@$q['et'])) {
                $e = [array('resource'=>'Search', 'field'=>'q.et', 'code'=>'missing')];
                $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
            }
        }
        $query = $this->Mcltx->getCltxNum($q);
        $result = array('num' => (int)$query->row()->SUM);

        $this->response($result, 200);
        #header("HTTP/1.1 200 OK");
        #echo json_encode($result);
    }
}