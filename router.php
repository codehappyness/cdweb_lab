<?php

$controllers = array(
  'home' => ['index', 'error'],
  'auth' => ['login', 'loginPost', 'logout', 'register', 'registerPost'],
  'nguoidung' => ['index', 'edit', 'update', 'delete', 'add', 'store'],
  'dichvu' => ['index', 'error', 'detail', 'edit', 'delete', 'add', 'store'],
  'nhacungcap' => ['index', 'error', 'detail', 'edit', 'delete', 'add', 'store'],
  'hoadon' => ['index', 'add', 'store', 'edit', 'update', 'delete', 'pay', 'store_pay'],
  'thongke' => ['index'],
  'profile' => ['index', 'store']
);

if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
  $controller = 'home';
  $action = 'error';
}

include_once('controllers/' . $controller . '_controller.php');

// Tạo ra tên controller class từ các giá trị lấy được từ URL sau đó gọi ra để hiển thị trả về cho người dùng.
$tenClass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
$controller = new $tenClass();
$controller->$action();
