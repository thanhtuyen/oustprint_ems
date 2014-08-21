<?php

/**
 * CalculateForm class.
 * CalculateForm is the data structure for keeping
 * calculate data form data. It is used by the 'calculate' action of 'CostController'.
 */
class CalculateForm extends CFormModel
{
  public $namtinh;
  public $thunhap_vnd;
  public $thunhap_usd;
  public $tigia;
  public $luong_toi_thieu;
  public $bh_xh;
  public $bh_yte;
  public $bh_thatnghiep;
  public $songuoi_phuthuoc;

  public function __construct($scenario='') {
    parent::__construct($scenario);
    $this->tigia = ContractSalary::get_CurrentUSD();
  }

  public function rules()
  {
    return array(
      //array('namtinh, thunhap_vnd, luong_toi_thieu, bh_xh, bh_yte, bh_thatnghiep', 'required'),
      array('thunhap_vnd, thunhap_usd, tigia, luong_toi_thieu, bh_xh, bh_yte, bh_thatnghiep, songuoi_phuthuoc', 'safe'),
    );
  }

  public function attributeLabels()
  {
    return array(
      'namtinh'=>'Calculate On',
      'thunhap_vnd'=>'Salary',
      'thunhap_usd'=>'Salary',
      'tigia'=>'Exchange Rate',
      'luong_toi_thieu'=>'Basic Salary',
      'bh_xh'=>'Social Insurance',
      'bh_yte'=>'Medical Insurance',
      'bh_thatnghiep'=>'Unemployment Insurance',
      'songuoi_phuthuoc'=>'Number of Dependents',
    );
  }

  protected function replaceComma($value) {
    if (strpos($value, ',') !== FALSE) {
      return (float)str_replace(',', '', $value);
    }
    return (float)$value;
  }

  protected function tinhThue($luong_chiu_thue) {
    if ($luong_chiu_thue <= 0) {
      return 0;
    }
    else if ($luong_chiu_thue <= 5000000) {
      return 0.05;
    }
    else if ($luong_chiu_thue <= 10000000) {
      return 0.1;
    }
    else if ($luong_chiu_thue <= 18000000) {
      return 0.15;
    }
    else if ($luong_chiu_thue <= 32000000) {
      return 0.2;
    }
    else if ($luong_chiu_thue <= 52000000) {
      return 0.25;
    }
    else if ($luong_chiu_thue <= 80000000) {
      return 0.3;
    }
    else if ($luong_chiu_thue > 80000000) {
      return 0.35;
    }
  }

  public function calculateGross() {
    $thunhap_vnd = $this->replaceComma($this->thunhap_vnd);
    $thunhap_usd = $this->replaceComma($this->thunhap_usd);
    $gross = $thunhap_vnd + ($thunhap_usd * $this->tigia);
    $bh_xh = $gross * $this->bh_xh/100;
    $bh_yte = $gross * $this->bh_yte/100;
    $bh_thatnghiep = $gross * $this->bh_thatnghiep/100;
    $luong_truoc_thue = $gross - $bh_xh - $bh_yte - $bh_thatnghiep;
    $phucap_canhan = 4000000;
    $phucap_phuthuoc = 1600000 * $this->songuoi_phuthuoc;
    $luong_chiu_thue = $luong_truoc_thue - $phucap_canhan - phucap_phuthuoc;
    $thue = $this->tinhThue($luong_chiu_thue);
    $thue_canhan = $luong_chiu_thue * $thue;
    $net = $luong_truoc_thue - $thue_canhan;

    return array($gross, $net);
  }

  public function calculateNet() {
    $thunhap_vnd = $this->replaceComma($this->thunhap_vnd);
    $thunhap_usd = $this->replaceComma($this->thunhap_usd);
    $net = $thunhap_vnd + ($thunhap_usd * $this->tigia);
    $tam_chiu_thue = $net - 4000000 - (1600000 * $this->songuoi_phuthuoc);
    $thue = $this->tinhThue($tam_chiu_thue);
    $luong_truoc_thue = ($net - ($thue * (4000000 + (1600000 * $this->songuoi_phuthuoc)))) / (1 - $thue);
    $gross = $luong_truoc_thue / (1 - ($this->bh_xh + $this->bh_yte + $this->bh_thatnghiep) / 100);

    return array($gross, $net);
  }

}
