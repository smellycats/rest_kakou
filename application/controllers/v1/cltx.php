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
require APPPATH . '/libraries/REST_Controller.php';

class Cltx extends REST_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
        
        $this->load->model('Mcgs');
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

}