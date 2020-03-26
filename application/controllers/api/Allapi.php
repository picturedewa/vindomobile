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
        // $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        // $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        // $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key

        $this->load->model("Apimodel","Mallapi");
    }

    public function getdataomsetdetail_post(){
        $idtgl = $this->post("idtgl");
        $omsetData = $this->Mallapi->getAllomsetdetail($idtgl);
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

    public function getdataomsettotal_post(){
        $idtgl = $this->post("idtgl");
        $omsetData = $this->Mallapi->getAllomsettotal($idtgl);
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

    public function getdatajualdetail_post(){
        $idso = $this->post("noso");
        $omsetData = $this->Mallapi->getjualdetail($idso);
        if (count($omsetData) == 0) {
            $jadwal["message"] = "Data Penjualan tidak ditemukan";
            $jadwal["success"] = 0;
        }else{
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all Data";
        }
           
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }

    public function getdatatotalstock_post(){
        
        $omsetData = $this->Mallapi->getAllstocktotal();
        if (count($omsetData) == 0) {
            $jadwal["message"] = "Data stock tidak ditemukan";
            $jadwal["success"] = 0;
        }else{
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all Data";
        }
           
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }

    public function getdetalstock_post(){
        $omsetData = $this->Mallapi->getAlldetailstock();
        if (count($omsetData) == 0) {
            $jadwal["message"] = "Data stock tidak ditemukan";
            $jadwal["success"] = 0;
        }else{
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all Data";
        }
           
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }

    public function getdatasubgoldetailstock_post(){
        $idsubgol = $this->post("subgol");
        if ($idsubgol){
            $omsetData = $this->Mallapi->getsubgoldetailstock($idsubgol);
            if (count($omsetData) == 0) {
                $jadwal["message"] = "Data Penjualan tidak ditemukan";
                $jadwal["success"] = 0;
            }else{
                $jadwal["success"] = 1;
                $jadwal["message"] = "success show list all Data";
            }
        }else{
            $jadwal["message"] = "Sub Golongan Tidak ditemukan";
            $jadwal["success"] = 0;
        }
        
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }


    public function getlistsubgoltotal_post(){
        $omsetData = $this->Mallapi->getAlltotalsubgol();
        if (count($omsetData) == 0) {
            $jadwal["message"] = "Data sub gol tidak ditemukan";
            $jadwal["success"] = 0;
        }else{
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all Data";
        }
           
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }


    public function openeditdata_post(){

        $idno = $this->post("idno");
        $idmodule = $this->post("idmodule");
        $idevent = $this->post("idevent");
        // echo "<pre>";
        // print_r($idevent);
        // print_r($idmodule);
        // echo "<pre>";
        $omsetData = $this->Mallapi->updateoepnedit($idno,$idmodule,$idevent);
        if ($omsetData) {
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all Data";
        }else{

            $jadwal["message"] = "Data sub gol tidak ditemukan";
            $jadwal["success"] = 0;
        }
           
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }


    public function getdatapembelian_post(){
        $dataqr = $this->post("dataquery");
        $tgl=$this->post("tgl");
        // $bln=$this->post("bulan");
        $omsetData = $this->Mallapi->getAlldatapembelian($dataqr,$tgl);
        if (count($omsetData) == 0) {
            $jadwal["message"] = "Data sub gol tidak ditemukan";
            $jadwal["success"] = 0;
        }else{
            $jadwal["success"] = 1;
            $jadwal["message"] = "success show list all Data";
        }
           
        $jadwal["data"] = $omsetData;
        $this->response($jadwal, REST_Controller::HTTP_OK);
    }

}