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

class Logo extends Parsing_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Mlogo');

        $this->load->helper('url');
        $this->load->helper('date');

        header('Cache-Control:public, max-age=60, s-maxage=60');
        header('Content-Type: application/json');

        $this->imgip = array('1' => '127.0.0.1', '2' => '127.0.0.1');
    }

    /**
     * get hpys
     * 获取号牌颜色列表
     *
     * @return json
     */
    function hpys_get()
    {
        $query = $this->Mlogo->getHpys();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'name'=>$row->color);
        }
        header("HTTP/1.1 200 OK");
        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }
    
    /**
     * get csys
     * 获取车身颜色列表
     *
     * @return json
     */
    function csys_get()
    {
        $query = $this->Mlogo->getCsys();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'code'=>$row->code, 'name'=>$row->name);
        }
        header("HTTP/1.1 200 OK");
        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get hpzl
     * 获取号牌种类列表
     *
     * @return json
     */
    function hpzl_get()
    {
        $query = $this->Mlogo->getHpzl();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'code'=>$row->code, 'name'=>$row->name, 'hpys'=>$row->color, 'ps'=>$row->remark);
        }
        header("HTTP/1.1 200 OK");
        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get cllx
     * 获取车辆类型列表
     *
     * @return json
     */
    function cllx_get()
    {
        $query = $this->Mlogo->getCllx();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'code'=>$row->code, 'name'=>$row->name);
        }
        header("HTTP/1.1 200 OK");
        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get place
     * 获取车辆类型列表
     *
     * @return json
     */
    function place_get()
    {
        $query = $this->Mlogo->getPlace();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'name'=>$row->place, 'config_id'=>(int)$row->config_id, 'kkbh'=>$row->kkbh);
        }
        header("HTTP/1.1 200 OK");
        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get ppdm
     * 获取品牌代码列表
     *
     * @return json
     */
    function ppdm_get()
    {
        header("HTTP/1.1 200 OK");

        $code = $this->uri->segment(4);
        if ($code == Null) {
            $query = $this->Mlogo->getPpdm();
            $result = array();
            foreach($query->result() as $id=>$row) {
                $result[$id] = array('id' => (int)$row->id, 'code' => $row->code, 'name' => $row->name);
            }
            echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
        } else {
            $query = $this->Mlogo->getPpdmByCode($code);
            $result = array();
            foreach($query->result() as $id=>$row) {
                $result[$id] = array('code' => $row->clpp2, 'name' => $row->name2);
            }
            echo json_encode(array('total_count' => $query->num_rows(), 'code' => $code, 'items' => $result));
        }
    }

    /**
     * get carinfo by id
     * 获取车辆类型列表
     *
     * @return json
     */
    function carinfo_get()
    {
        $id = (int)$this->uri->segment(4);
        $query = $this->Mlogo->getCarinfoById($id);
        $result = $query->row_array();
        $result['imgurl'] = 'http://' . $this->imgip[$result['img_ip']] . '/SpreadData' . $result['img_disk']. '/' . str_replace("\\", '/', $result['img_path']);
        unset($result['img_ip']);
        unset($result['img_disk']);
        unset($result['img_path']);
        header("HTTP/1.1 200 OK");
        header('Cache-Control:max-age=0');
        echo json_encode($result);
    }

    /**
     * get fresh carinfo
     * 获取最新车辆信息
     *
     * @return json
     */
    function fresh_get()
    {
        if (empty(@$this->gets['q'])) {
            $e = [array('resource'=>'Search', 'field'=>'q', 'code'=>'missing')];
            $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
        }
        // 解析q参数
        $q_arr = h_convertParam($this->gets['q']);
        $user_id = @$q_arr['q'];
        $fresh = $this->Mlogo->getFreshByUserId($user_id);
        
        if ($fresh->num_rows() == 0) {
            $query = $this->Mlogo->getFresh($q_arr);
            $carinfo_id = $query->num_rows == 0 ? 0 : $query->row()->id;
            $this->Mlogo->addFresh(array('user_id'=>$user_id, 'carinfo_id'=>$carinfo_id, 'modified'=>mdate('%Y-%m-%d %H:%m:%s')));
        } else {
            $q_arr['id'] = $fresh->row()->carinfo_id;
            $i = 0;
            while ($i < 120){
                $query = $this->Mlogo->getFresh($q_arr);
                if ($query->num_rows() == 0){
                    $i ++;
                } else {
                    $carinfo_id = $query->row()->id;
                    $this->Mlogo->setFresh($user_id, array('carinfo_id'=>$carinfo_id, 'modified'=>mdate('%Y-%m-%d %H:%m:%s')));
                    break;
                }
                # 休眠250毫秒
                usleep(250000);
            }
        }
        $result['items'] = $query->result_array();
        $result['total_count'] = $query->num_rows();
        foreach($result['items'] as $id=>$row) {
            $row['imgurl'] = 'http://' . $this->imgip[$row['img_ip']] . '/SpreadData' . $row['img_disk'] . '/' . $row['img_path'];
            unset($row['img_ip']);
            unset($row['img_disk']);
            unset($row['img_path']);
        }
        header("HTTP/1.1 200 OK");
        header('Cache-Control:max-age=0');
        echo json_encode($result);
    }
}