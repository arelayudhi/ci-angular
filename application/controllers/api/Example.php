<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Example extends REST_Controller
{

    function __construct()
    {
        Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
        Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
        parent::__construct();
    }
    public function index_post()
    {
        $this->set_response(["status" => "OK", "message" => "post_success"], REST_Controller::HTTP_OK);
    }
    public function index_get()
    {
        $this->set_response(["status" => "OK", "message" => "get_success"], REST_Controller::HTTP_OK);
    }
    public function test_post()
    {
        $post["base64"] = $this->post("base64");
        $post["fotoarray"] = $this->post("fotoarray");
        $this->set_response(["base64" => $post["base64"], "fotoarray" => $post["fotoarray"]], REST_Controller::HTTP_OK);
    }
}