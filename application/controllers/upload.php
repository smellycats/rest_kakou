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

class Upload extends CI_Controller
{
	public function __construct()
    {
        // Construct our parent class
        parent::__construct();

        $this->load->helper(array('form', 'url'));

        $this->load->model('Mversion');
    }

    public function index()
    {
        $this->load->view('upload_form', array('error' => ''));
    }

    public function do_upload()
    {
        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = 'apk';
        $config['max_size'] = 100000;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $file_name = explode('.', $this->upload->data()['file_name'])[0];
            $d['version'] = explode('_', $file_name)[1];
            $d['file_name'] = $this->upload->data()['file_name'];
            $this->Mversion->addVersion($d);
            $this->load->view('upload_success', $data);
        }
    }

    public function latest_version()
    {
        $row = $this->Mversion->getLatestVersion()->row_array();
        $result['version'] = $row['version'];
        $result['file_url'] = base_url() . '/uploads/' . $row['file_name'];

        header('Content-Type: application/json; charset=utf-8');
        header("HTTP/1.1 200 OK");
        echo json_encode($result);
    }

    public function test()
    {
        $d['version'] = '0.1.0';
        $d['file_name'] = '死肥字_0.1.0.apk';
        $this->Mversion->addVersion($d);
    }

}