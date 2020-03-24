<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

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
class Allapi extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model("Apimodel","Mallapi");
    }

    public function getdataomset_post(){
        $idtgl = $this->post("idtgl");
        $omsetData = $this->Mallapi->getAllomset($idtgl);
        if (count($omsetData) == 0) {
            $jadwal["message"] = "Data Omset tidak ditemukan";
            $jadwal["success"] = 0;
        }else{
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all Data";
        }
           
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }
}