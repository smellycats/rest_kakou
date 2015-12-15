<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is img create rest
 *
 * @package		CodeIgniter
 * @subpackage	Kakou Rest Server
 * @category	Controller
 * @author		Fire
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
#require APPPATH . '/libraries/REST_Controller.php';

class Img extends CI_Controller
{
	public function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Mlogo');

        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('kakou');

        $this->load->library('image_lib');
        #$this->load->library('Lib_kakou');

        #header('Cache-Control: public, max-age=60, s-maxage=60');
    }

    public function thumb()
    {
        $id = $this->input->get('id', True);
        $query = $this->Mlogo->getCarinfoById($id);
        $result = $query->row_array();

        $img_path = $result['img_disk']
                  . ':/SpreadData/'
                  . str_replace("\\", '/', $result['img_path']);

        $config['image_library'] = 'gd2';
        $config['source_image'] = $img_path;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['dynamic_output'] = TRUE;
        $config['quality'] = 100;
        $config['width'] = 800;
        $config['height'] = 250;

        ob_clean();
        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize())
        {
            echo $this->image_lib->display_errors();
        }
    }

    public function crop()
    {
        $id = $this->input->get('id', True);
        $query = $this->Mlogo->getCarinfoById($id);
        $result = $query->row_array();

        $img_path = $result['img_disk']
                  . ':/SpreadData/'
                  . str_replace("\\", '/', $result['img_path']);
        $arr = getimagesize($img_path);
        if ($arr[0] > $arr[1] * 2) {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $img_path;
            $config['maintain_ratio'] = FALSE;//维持比例
            $config['dynamic_output'] = TRUE;
            $config['width'] = $arr[0] / 2;
            $config['height'] = $arr[1];

            ob_clean();
            $this->image_lib->clear();
            $this->image_lib->initialize($config);

            if ( ! $this->image_lib->crop()) {
                echo $this->image_lib->display_errors();
            }
        } else {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $img_path;
            $config['maintain_ratio'] = FALSE;//维持比例
            $config['dynamic_output'] = TRUE;
            $config['width'] = $arr[0];
            $config['height'] = $arr[1];

            ob_clean();
            $this->image_lib->clear();
            $this->image_lib->initialize($config);

            if ( ! $this->image_lib->crop()) {
                echo $this->image_lib->display_errors();
            }
        }
    }

    public function test()
    {
        /*
        $arr = getimagesize("C:/SpreadData/test2.jpg");
        var_dump($arr[0] / 2);
        return; */
        $img_path = "C:/SpreadData/test2.jpg";
        $config['image_library'] = 'gd2';
        $config['source_image'] = $img_path;
        #$config['maintain_ratio'] = TRUE;
        $config['dynamic_output'] = TRUE;
        $config['maintain_ratio'] = FALSE;//维持比例
        $config['width'] = 2752;//(必须)设置你想要得图像宽度。
        $config['height'] = 2208;//(必须)设置你想要得图像高度
        #$config['x_axis'] = 0;
        #$config['y_axis'] = 0;
        #var_dump($config);
        #return;
        ob_clean();
        $this->image_lib->clear();
        $this->image_lib->initialize($config);

        if ( ! $this->image_lib->crop()) {
            echo $this->image_lib->display_errors();
        }
    }

}