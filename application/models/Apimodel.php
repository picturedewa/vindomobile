<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiModel extends CI_Model
{
  public $soh = 'so_h';
  public $sod = 'so_d';
  public $stc = 'stock';
  public $avg = 'hrata';
  public $product = 'product';

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

  public function getjualdetail($idso){
    $this->db->select('A.noso,A.kodebrg,A.namabrg,A.qty,A.unit,A.price,A.total');
    $this->db->from("{$this->sod} A");
    $this->db->where('A.noso', $idso);
    $query = $this->db->get();
    return $query->result();
  }

  public function getAllstocktotal(){
    $this->db->select('SUM(A.sisa * B.hrata) as ttlstc');
    $this->db->from("{$this->stc} A");
    $this->db->join("{$this->avg} B", 'A.kodepro = B.kodepro');
    $query = $this->db->get();
    return $query->result();
  }

  public function getAlldetailstock(){
    $this->db->select('A.kodepro,A.sisa,C.namapro,B.hrata,(A.sisa * B.hrata) AS nilai');
    $this->db->from("{$this->stc} A");
    $this->db->join("{$this->avg} B", 'A.kodepro = B.kodepro');
    $this->db->join("{$this->product} C", 'A.kodepro = C.kodepro');
    $query = $this->db->get();
    return $query->result();
  }

  public function getAlltotalsubgol(){
    $this->db->select('C.subgol,SUM(A.sisa * B.hrata) AS nilai');
    $this->db->from("{$this->stc} A");
    $this->db->join("{$this->avg} B", 'A.kodepro = B.kodepro');
    $this->db->join("{$this->product} C", 'A.kodepro = C.kodepro');
    $this->db->group_by(array("subgol"));
    $query = $this->db->get();
    return $query->result();
  }

}
