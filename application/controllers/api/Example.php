<?php

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Example extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Upload');
    }
    public function photo_post()
    {
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('files')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->Upload->tambah('foto', [
                'nama' => $data['upload_data']['file_name'],
                'path' => base_url() . 'uploads/'
            ]);
            $link = base_url() . 'uploads/' . $data['upload_data']['file_name'];
            $url = "http://192.168.1.253:5001/";
            $parameters = array('link' => $link);
            $options = array(
                'http' => array(
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($parameters)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, true, $context);
            $response = json_decode($result);
            $this->response([
                'status' => FALSE,
                'message' => $response
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }
}

   
