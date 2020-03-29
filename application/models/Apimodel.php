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

   public function getAlldatapembelian($dataqr,$tgl)
   {
    // $first_day_this_month = date('m-01-Y',$tgl); // hard-coded '01' for first day
    // $last_day_this_month  = date('m-t-Y',$tgl);
    $this->db->select($dataqr .' as item');
    $this->db->from("{$this->poh}");
    $this->db->join("{$this->pod}", 'po_h.nopo = po_d.nopo');
    $this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    $this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->where('YEAR(po_h.tgl)', $thn);
    // $this->db->where('MONTH(po_h.tgl)', $bln);
    $this->db->group_by(array($dataqr));
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatabelidetail($datapo){
    // $first_day_this_month = date('m-01-Y',$tgl); // hard-coded '01' for first day
    // $last_day_this_month  = date('m-t-Y',$tgl);
    $this->db->select('po_d.kodepro,po_d.namapro,po_d.qty,po_d.unit,po_d.price,po_d.total');
    $this->db->from("{$this->pod}");
    //$this->db->join("{$this->pod}", 'po_h.nopo = po_d.nopo');
    //$this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    //$this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->like($datafield,$datacari,'both');
    $this->db->where('po_d.nopo', $datapo);
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatabelidetailheader($datapo){
    $this->db->select('po_h.nopo,po_h.tgl,po_h.grandtotal,Supplier.perusahaan');
    $this->db->from("{$this->poh}");
    $this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    //$this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->like($datafield,$datacari,'both');
    // $this->db->group_by(array("po_h.nopo"));
    $this->db->where('po_h.nopo', $datapo);
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatabeliheader($datafield,$tgl,$datacari){
    $this->db->select('po_h.nopo,po_h.grandtotal,Supplier.perusahaan,po_h.tgl');
    $this->db->from("{$this->poh}");
    $this->db->join("{$this->pod}", 'po_h.nopo = po_d.nopo');
    $this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    $this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
      // $this->db->like($datafield,$datacari,'both');
    if($datafield){
      $this->db->where($datafield, $datacari);
    }
    
    $this->db->group_by(array("po_h.nopo", "Supplier.perusahaan","po_h.tgl"));
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatabeliheadertotal($datafield,$tgl,$datacari){
    $this->db->select('sum(po_h.grandtotal) as gtotal');
    $this->db->from("{$this->poh}");
    $this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    $this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->like($datafield,$datacari,'both');
    // $this->db->group_by(array("po_h.nopo"));
    if($datafield){
      $this->db->where($datafield, $datacari);
    }
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatapenjualan($dataqr,$tgl)
   {
    
    $this->db->select($dataqr .' as item');
    $this->db->from("{$this->soh}");
    $this->db->join("{$this->sod}", 'so_h.noso = so_d.noso');
    $this->db->where('so_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->where('YEAR(po_h.tgl)', $thn);
    // $this->db->where('MONTH(po_h.tgl)', $bln);
    $this->db->group_by(array($dataqr));
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatajualheader($datafield,$tgl,$datacari){
    $this->db->select('so_h.noso,so_h.grandtotal,so_h.sales as perusahaan,so_h.tgl');
    $this->db->from("{$this->soh}");
    $this->db->join("{$this->sod}", 'so_h.noso = so_d.noso');
    $this->db->where('so_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
      // $this->db->like($datafield,$datacari,'both');
    if($datafield){
      $this->db->where($datafield, $datacari);
    }
    $this->db->group_by(array("so_h.noso","so_h.tgl"));
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatajualheadertotal($datafield,$tgl,$datacari){
    $this->db->select('sum(so_h.grandtotal) as gtotal');
    $this->db->from("{$this->soh}");
    $this->db->where('so_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->like($datafield,$datacari,'both');
    // $this->db->group_by(array("po_h.nopo"));
    if($datafield){
      $this->db->where($datafield, $datacari);
    }
    $query = $this->db->get();
    return $query->result();
   }


   public function getAlldatajualdetail($datapo){
    // $first_day_this_month = date('m-01-Y',$tgl); // hard-coded '01' for first day
    // $last_day_this_month  = date('m-t-Y',$tgl);
    $this->db->select('so_d.kodebrg,so_d.namabrg,so_d.qty,so_d.unit,so_d.price,so_d.total');
    $this->db->from("{$this->sod}");
    //$this->db->join("{$this->pod}", 'po_h.nopo = po_d.nopo');
    //$this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    //$this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->like($datafield,$datacari,'both');
    $this->db->where('so_d.noso', $datapo);
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatajualdetailheader($datapo){
    $this->db->select('so_h.noso,so_h.tgl,so_h.grandtotal,so_h.sales as perusahaan');
    $this->db->from("{$this->soh}");
   
    //$this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->like($datafield,$datacari,'both');
    // $this->db->group_by(array("po_h.nopo"));
    $this->db->where('so_h.noso', $datapo);
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatarugilaba($tgl){
    $this->db->select('so_h.noso,so_h.grandtotal,so_h.tgl,(total-ttlhpp) AS rl');
    $this->db->from("{$this->soh}");
    $this->db->where('so_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatarugilabadetail($datapo){
    // $first_day_this_month = date('m-01-Y',$tgl); // hard-coded '01' for first day
    // $last_day_this_month  = date('m-t-Y',$tgl);
    $this->db->select('so_d.kodebrg,so_d.namabrg,so_d.qty,so_d.unit,so_d.price,so_d.total,total-(hpp*qty) as hpp');
    $this->db->from("{$this->sod}");
    //$this->db->join("{$this->pod}", 'po_h.nopo = po_d.nopo');
    //$this->db->join("{$this->spl}", 'po_h.spl = Supplier.kodecst');
    //$this->db->where('po_h.tgl BETWEEN "'. date('Y-m-01', strtotime($tgl)). '" and "'. date('Y-m-t', strtotime($tgl)).'"');
    // $this->db->like($datafield,$datacari,'both');
    $this->db->where('so_d.noso', $datapo);
    $query = $this->db->get();
    return $query->result();
   }

   public function getAlldatarugilabadetailheader($datapo){
    $this->db->select('so_h.noso,so_h.tgl,so_h.grandtotal,so_h.sales as perusahaan');
    $this->db->from("{$this->soh}");
    $this->db->where('so_h.noso', $datapo);
    $query = $this->db->get();
    return $query->result();
   }
}
