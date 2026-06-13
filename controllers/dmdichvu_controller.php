<?php
require_once('controllers/base_controller.php');
class DmdichvuController extends BaseController
{
  function __construct()
  {
    $this->folder = 'dmdichvu';
  }
  public function index()
  {
    $this->render('index');
  }
  public function error()
  {
    $this->render('error');
  }
}
