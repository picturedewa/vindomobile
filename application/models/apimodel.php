<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiModel extends CI_Model
{
  public $soh = 'so_h';
  

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getAllomset($idtgl){
    if($idtgl){
        $time = strtotime($idtgl);
        $bulan = date('m', $time);
        $tahun=date('Y',$time)
      }else{
        $bulan=date('m');
        $tahun=date('Y');
      }
    $this->db->select('A.noso,A.tgl,A.grandtotal,A.ttlhpp,A.grandtotal-A.ttlhpp AS rl');
    $this->db->from("{$this->so_h} A");
    $this->db->where('YEAR(A.tgl)', $tahun);
    $this->db->where('MONTH(A.tgl)', $bulan);
    $query = $this->db->get();
    return $query->result();
  }



}
