<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiModel extends CI_Model
{
  public $soh = 'so_h';
  public $sod = 'so_d';

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function getAllomsetdetail($idtgl){
    if($idtgl){
        $time = strtotime($idtgl);
        $bulan = date('m', $time);
        $tahun = date('Y', $time);
      }else{
        $bulan = date('m');
        $tahun = date('Y');
      }
    $this->db->select('A.noso,A.tgl,A.grandtotal,A.ttlhpp,(grandtotal - ttlhpp) AS rl');
    $this->db->from("{$this->soh} A");
    $this->db->where('YEAR(A.tgl)', $tahun);
    $this->db->where('MONTH(A.tgl)', $bulan);
    $query = $this->db->get();
    return $query->result();
  }

  public function getAllomsettotal($idtgl){
    if($idtgl){
      $time = strtotime($idtgl);
      $bulan = date('m', $time);
      $tahun = date('Y', $time);
    }else{
      $bulan = date('m');
      $tahun = date('Y');
    }
    $this->db->select('sum(grandtotal) as ttlomset');
    $this->db->from("{$this->soh} A");
    $this->db->where('YEAR(A.tgl)', $tahun);
    $this->db->where('MONTH(A.tgl)', $bulan);
    $query = $this->db->get();
    return $query->result();
  }

  public function getdatajualdetail($idso){
    $this->db->select('A.noso,A.kodebrg,A.namabrg,A.qty,A.unit,A.price,A.total');
    $this->db->from("{$this->sod} A");
    $this->db->where('A.noso', $idso);
    $query = $this->db->get();
    return $query->result();
  }

}
