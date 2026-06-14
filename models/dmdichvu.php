<?php

class DmDichvu
{
  public $ma_dv;
  public $ten_dichvu;
  public $mota;
  public function __construct($ma_dv, $ten_dichvu, $mota)
  {
    $this->ma_dv = $ma_dv;
    $this->ten_dichvu = $ten_dichvu;
    $this->mota = $mota;
  }
  public function getAllDichvu(){
      $list =[];
    $db = DB::getInstance();
    $result = $db->prepare('select * from dm_dichvu');
    $result->setFetchMode()
  }
}
