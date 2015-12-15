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
	  public function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Mlogo');

        $this->load->helper('url');
        $this->load->helper('date');

        header('Cache-Control: public, max-age=60, s-maxage=60');
        header('Content-Type: application/json; charset=utf-8');
        header("HTTP/1.1 200 OK");

        #$this->methods['hpys_get']['limit'] = 5000; //50 requests per hour per user/key

        $this->imgip = array(
            '1' => '127.0.0.1',
            '2' => '127.0.0.1'
        );

        $this->kkdd_id = array(
            '14' => '441323001',
            '7' => '441323002',
            '2' => '441323003',
            '6' => '441323004',
            '5' => '441323005',
            '8' => '441323006',
            '4' => '441323007',
            '12' => '441323008',
            '3' => '441323009',
            '9' => '441323010',
            '10' => '441323011',
            '11' => '441323012',
            '13' => '441323013',  #广惠高速入口白花卡哨
            '15' => '441323014'   #大岭镇(潮莞高速路口)往惠州
        );
    }

    public function test_get()
    {
        echo json_encode(array('test'=> '123'));
    }
    /**
     * get hpys
     * 获取号牌颜色列表
     *
     * @return json
     */
    public function hpys_get()
    {
        $query = $this->Mlogo->getHpys();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'code'=>$row->code, 'name'=>$row->name);
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }
    
    /**
     * get csys
     * 获取车身颜色列表
     *
     * @return json
     */
    public function csys_get()
    {
        $query = $this->Mlogo->getCsys();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'code'=>$row->code, 'name'=>$row->name);
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get hpzl
     * 获取号牌种类列表
     *
     * @return json
     */
    public function hpzl_get()
    {
        $query = $this->Mlogo->getHpzl();
        $items = array();
        foreach($query->result_array() as $id => $row) {
            $items[$id] = array(
                'id' => (int)$row['id'],
                'code' => $row['code'],
                'name' => $row['name'],
                'hpys' => $row['hpys'],
                'hpys_code' => $row['hpys_code'],
                'ps'=> $row['remark']
            );
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $items));
    }

    /**
     * get cllx
     * 获取车辆类型列表
     *
     * @return json
     */
    public function cllx_get()
    {
        $query = $this->Mlogo->getCllx();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'code'=>$row->code, 'name'=>$row->name);
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get fxbh
     * 获取方向编号列表
     *
     * @return json
     */
    public function fxbh_get()
    {
        $query = $this->Mlogo->getFxbh();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'code'=>$row->code, 'name'=>$row->name);
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get place
     * 获取车辆类型列表
     *
     * @return json
     */
    public function place_get()
    {
        $query = $this->Mlogo->getPlace();
        $result = array();
        foreach($query->result() as $id=>$row) {
            $result[$id] = array('id'=>(int)$row->id, 'name'=>$row->place, 'config_id'=>(int)$row->config_id, 'kkbh'=>$row->kkbh);
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
    }

    /**
     * get kkdd
     * 获取卡口地点列表
     *
     * @return json
     */
    public function kkdd_get()
    {
        $query = $this->Mlogo->getPlace();
        $items = array();
        foreach ($query->result_array() as $id=>$row) {
            $items[$id]['id'] = array_key_exists($row['id'], $this->kkdd_id) ? $this->kkdd_id[$row['id']] : null;
            $items[$id]['name'] = $row['place'];
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $items));
    }

    /**
     * get ppdm
     * 获取品牌代码列表
     *
     * @return json
     */
    public function ppdm_get()
    {
        $code = $this->uri->segment(4);
        if ($code == Null) {
            $query = $this->Mlogo->getPpdm();
            $result = array();
            foreach($query->result() as $id=>$row) {
                $result[$id] = array('id' => (int)$row->id, 'code' => $row->ppdm, 'name' => $row->name);
            }
            echo json_encode(array('total_count' => $query->num_rows(), 'items' => $result));
        } else {
            $query = $this->Mlogo->getPpdmByCode($code);
            $result = array();
            foreach($query->result() as $id=>$row) {
                $result[$id] = array('code' => $row->ppdm2, 'name' => $row->name);
            }

            echo json_encode(array('total_count' => $query->num_rows(), 'code' => $code, 'items' => $result));
        }
    }


    /**
     * get ppdmall
     * 获取全部品牌代码列表
     *
     * @return json
     */
    public function ppdmall_get()
    {
        $query = $this->Mlogo->getPpdm();
        $items = array();
        foreach ($query->result_array() as $id => $row) {
            $items[$id]['id'] = (int)$row['id'];
            $items[$id]['code'] = $row['ppdm'];
            $items[$id]['name'] = $row['name'];
            $query2 = $this->Mlogo->getPpdmByCode($row['ppdm']);
            $items[$id]['count'] = $query2->num_rows();
            foreach ($query2->result_array() as $id2 => $row2) {
                $items[$id]['items'][$id2] = array(
                    'id' => (int)$row2['id'],
                    'code' => $row2['ppdm2'],
                    'name' => $row2['name']
                );
            }
        }

        echo json_encode(array('total_count' => $query->num_rows(), 'items' => $items));
    }

    /**
     * get carinfo by id
     * 获取车辆类型列表
     *
     * @return json
     */
    public function carinfo_get()
    {
        $id = (int)$this->uri->segment(4);
        $query = $this->Mlogo->getCarinfoById($id);
        $result = $query->row_array();
        $result['imgurl'] = 'http://'
                          . $this->imgip[$result['img_ip']]
                          . '/SpreadData'
                          . $result['img_disk']
                          . '/'
                          . str_replace("\\", '/', $result['img_path']);
        $result['thumb_url'] = 'http://'
                             . $this->imgip[$result['img_ip']]
                             . '/rest_kakou/index.php/v1/img/thumb?id='
                             . $result['id'];
        $result['kkdd_id'] = array_key_exists($result['place_id'], $this->kkdd_id) ? $this->kkdd_id[$result['place_id']] : null;
        $result['kkdd'] = $result['place'];
        unset($result['img_ip']);
        unset($result['img_disk']);
        unset($result['img_path']);

        header('Cache-Control:max-age=0');
        echo json_encode($result);
    }

    /**
     * get carinfo by cltx_id
     * 获取车辆类型列表
     *
     * @return json
     */
    public function carinfoByCltxId_get()
    {
        $id = (int)$this->uri->segment(4);
        $query = $this->Mlogo->getCarinfoByCltxId($id);
        $result = $query->row_array();
        $result['imgurl'] = 'http://'
                          . $this->imgip[$result['img_ip']]
                          . '/SpreadData'
                          . $result['img_disk']
                          . '/'
                          . str_replace("\\", '/', $result['img_path']);
        $result['thumb_url'] = 'http://'
                             . $this->imgip[$result['img_ip']]
                             . '/rest_kakou/index.php/v1/img/thumb?id='
                             . $result['id'];
        $result['kkdd_id'] = array_key_exists($result['place_id'], $this->kkdd_id) ? $this->kkdd_id[$result['place_id']] : null;
        $result['kkdd'] = $result['place'];
        unset($result['img_ip']);
        unset($result['img_disk']);
        unset($result['img_path']);

        header('Cache-Control:max-age=0');
        echo json_encode($result);
    }

    /**
     * get carinfo maxid
     * 获取车辆类型列表最大ID
     *
     * @return json
     */
    public function maxid_get()
    {
        $query = $this->Mlogo->getCarinfoMaxId();

        echo json_encode(array('maxid' => $query->row_array()['maxid']));
    }

    /**
     * get carinfos
     * 获取车辆类型列表
     *
     * @return json
     */
    public function carinfos_get()
    {
        if (empty(@$this->gets['q'])) {
            $e = [array('resource'=>'Search', 'field'=>'q', 'code'=>'missing')];
            $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
        }
        // 解析q参数
        $q_arr = h_convert_param3($this->gets['q']);
        if (empty(@$q_arr['st'])) {
            $q_arr['st'] = mdate("%Y-%m-%d %H:%i:%s", strtotime("-2 hours"));
        }
        if (empty(@$q_arr['et'])) {
            $q_arr['et'] = mdate("%Y-%m-%d %H:%i:%s");
        }
        if (empty(@$this->gets['page'])) {
            $this->gets['page'] = 1;
        }
        if (empty(@$this->gets['per_page'])) {
            $this->gets['per_page'] = 20;
        }
        $q_arr['hphm'] = trim($q_arr['q']);  //删除两边空格
        $query = $this->Mlogo->getCarinfos($q_arr, @$this->gets['page'], @$this->gets['per_page'], @$this->gets['sort'], @$this->gets['order']);
        $result['items'] = $query->result_array();
        $result['total_count'] = (int)$this->Mlogo->getCarinfos($q_arr, @$this->gets['page'], 0, @$this->gets['sort'], @$this->gets['order'])->row()->sum;
        foreach($result['items'] as $id=>$row) {
            $result['items'][$id]['imgurl'] = 'http://'
                                            . @$this->imgip[$row['img_ip']]
                                            . '/SpreadData'
                                            . $row['img_disk']
                                            . '/'
                                            . str_replace('\\', '/', $row['img_path']);
            $result['items'][$id]['thumb_url'] = 'http://'
                                               . @$this->imgip[$row['img_ip']]
                                               . '/rest_kakou/index.php/v1/img/thumb?id='
                                               . $row['id'];
            $result[$id]['kkdd_id'] = array_key_exists($row['place_id'], $this->kkdd_id) ? $this->kkdd_id[$row['place_id']] : null;
            $result[$id]['kkdd'] = $row['place'];
            unset($result['items'][$id]['img_ip']);
            unset($result['items'][$id]['img_disk']);
            unset($result['items'][$id]['img_path']);
        }

        header('Cache-Control:max-age=0');

        echo json_encode($result);
    }

    /**
     * get fresh carinfo
     * 获取最新车辆信息
     *
     * @return json
     */
    public function fresh_get()
    {
        if (empty(@$this->gets['q'])) {
            $e = [array('resource'=>'Search', 'field'=>'q', 'code'=>'missing')];
            $this->response(array('message' => 'Validation Failed', 'errors' => $e), 422);
        }
        // 解析q参数
        $q_arr = h_convert_param3($this->gets['q']);
        $user_id = @$q_arr['q'];
        $fresh = $this->Mlogo->getFreshByUserId($user_id);
        # 查询最久30分钟前数据
        $q_arr['t'] = mdate("%Y-%m-%d %H:%i:%s", strtotime('-30 minutes'));
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
                # 休眠100毫秒
                usleep(100000);
            }
        }
        $result['items'] = $query->result_array();
        $result['total_count'] = $query->num_rows();
        foreach($result['items'] as $id => $row) {
            $result['items'][$id]['imgurl'] = 'http://'
                                            . @$this->imgip[$row['img_ip']]
                                            . '/SpreadData'
                                            . $row['img_disk']
                                            . '/'
                                            . str_replace('\\', '/', $row['img_path']);
            $result['items'][$id]['thumb_url'] = 'http://'
                                               . @$this->imgip[$row['img_ip']]
                                               . '/rest_kakou/index.php/v1/img/thumb?id='
                                               . $row['id'];
            $result[$id]['kkdd_id'] = array_key_exists($row['place_id'], $this->kkdd_id) ? $this->kkdd_id[$row['place_id']] : null;
            $result[$id]['kkdd'] = $row['place'];
            unset($result['items'][$id]['img_ip']);
            unset($result['items'][$id]['img_disk']);
            unset($result['items'][$id]['img_path']);
        }

        header('Cache-Control:max-age=0');
        echo json_encode($result);
    }

}