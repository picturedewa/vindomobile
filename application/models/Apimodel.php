<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiModel extends CI_Model
{
  public $soh = 'so_h';
  public $sod = 'so_d';
  public $stc = 'stock';
  public $avg = 'hrata';
  public $product = 'product';
  public $poh = 'po_h';
  public $pod = 'po_d';
  public $retjualh = 'retjual_h';
  public $retbelih = 'retbeli_h';
  public $lnssplh = 'lnsspl_h';
  public $spl = 'Supplier';
  public $prod = 'product';

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

  public function getsubgoldetailstock($subdata){
    $this->db->select('A.kodepro,A.sisa,C.namapro,B.hrata,(A.sisa * B.hrata) AS nilai');
    $this->db->from("{$this->stc} A");
    $this->db->join("{$this->avg} B", 'A.kodepro = B.kodepro');
    $this->db->join("{$this->product} C", 'A.kodepro = C.kodepro');
    $this->db->where('C.subgol', $subdata);
    $query = $this->db->get();
    return $query->result();
  }


  public function updateoepnedit($idno,$idmodule,$idevent){
   
    if ($idevent == 1) {
        $data = array( 
          'ocedit'=> "1"
        );
    }
    if ($idevent == 2) {
        $data = array( 
          'ocdel'=> "1"
        );
    }
    if ($idevent == 3) {
      $data = array( 
        'ocdel'=> "0",
        'ocedit'=> "0"
      );
  }

    if($idmodule == "inv") {
      $this->db->where('noso', $idno);
      return $this->db->update($this->soh,$data);
    }
    
    if($idmodule == "po") {
      $this->db->where('nopo', $idno);
      return $this->db->update($this->poh,$data);
    }

    if($idmodule == "retjual") {
      $this->db->where('noret', $idno);
      return $this->db->update($this->retjualh,$data);
    }

    if($idmodule == "retbeli") {
      $this->db->where('noret', $idno);
      return $this->db->update($this->retbelih,$data);
    }

    if($idmodule == "lnsspl") {
      $this->db->where('nobyr', $idno);
      return $this->db->update($this->lnsspl,$data);
    }

    if($idmodule == "spl") {
      $this->db->where('kodecst', $idno);
      return $this->db->update($this->spl,$data);
    }

    if($idmodule =="prod") {
      $this->db->where('kodepro', $idno);
      return $this->db->update($this->prod,$data);
    }
    
   }

   public function getAlldatapembelian($dataqr)
   {
    $this->db->select($dataqr .' as item');
    $this->db->from("{$this->poh}");
    $this->db->join("{$this->pod}", 'po_h.nopo = po_d.nopo');
    $this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    $this->db->group_by(array($dataqr));
    $query = $this->db->get();
    return $query->result();
   }
}
