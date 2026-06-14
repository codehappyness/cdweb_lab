<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('connection.php');
if (isset($_GET['controller'])) {
  $controller = $_GET['controller'];
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
  } else {
    $action = 'index';
  }
} else
  if (isset($_POST['controller'])) {
  $controller = $_POST['controller'];
  if (isset($_POST['action'])) {
    $action = $_POST['action'];
  } else {
    $action = 'index';
  }
} else {
  $controller = 'home';
  $action = 'index';
}
DB::getInstance();
require_once('router.php');
