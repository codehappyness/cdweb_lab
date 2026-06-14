<?php

$controllers = array(
  'home' => ['index', 'error'],
  'dmdichvu' => ['index', 'error'],
  'nhacungcap' => ['index', 'error', 'detail', 'edit', 'delete', 'add', 'store'],
  'sanpham' => [
    'dssp',
    'index',
    'chitietsanpham',
    'xemKetQuaThemSP',
    'ThemSP',
    'SuaSP',
    'ketquaSuaSP',
    'ketquaXoasp',
    'timsanpham',
    'timsanpham2',
    'SuathongtinSP',
    'KetquaSuathongtinSP',
    'KetquaThemSP',
    'XulyThemSP',
    'getTenvaDonvitinhSP',
    'XoathongtinSP',
  ],
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
