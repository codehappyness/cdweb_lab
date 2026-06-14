<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

function back_with($type, $message, $withInput = false)
{
  $_SESSION['flash_message'] = [
    'type' => $type,
    'message' => $message
  ];
  if ($withInput && !empty($_POST)) {
    $_SESSION['old_input'] = $_POST;
  }
  $previous_url = $_SERVER['HTTP_REFERER'] ?? 'index.php';
  header("Location: " . $previous_url);
  exit();
}
function old($key, $default = '')
{
  $value = $_SESSION['old_input'][$key] ?? $default;
  return htmlspecialchars((string)$value);
}
function back_with_errors($errors, $message = 'Vui lòng kiểm tra lại dữ liệu nhập vào!')
{
  $_SESSION['errors'] = $errors; // Lưu mảng lỗi
  back_with('error', $message, true);
}

function has_error($key)
{
  return isset($_SESSION['errors'][$key]) ? 'is-invalid' : '';
}

// function error($key)
// {
//   if (isset($_SESSION['errors'][$key])) {
//     // Class text-danger hoặc invalid-feedback (nếu dùng Bootstrap)
//     //        return '<div class="text-danger mt-1" style="font-size: 0.875em;">' . htmlspecialchars($_SESSION['errors'][$key]) . '</div>';
//     return '<div class="text-danger mt-1 d-flex justify-content-between align-items-start" style="font-size: 0.875em;">'
//       . '<span>' . htmlspecialchars($_SESSION['errors'][$key]) . '</span>'
//       . '<button type="button" style="background: none; border: none; padding: 0; line-height: 1; color: inherit; cursor: pointer; font-size: 1.2em;" onclick="this.parentElement.remove();" title="Đóng">&times;</button>'
//       . '</div>';
//
//   }
//   return '';
// }
function error($key) {
    if (isset($_SESSION['errors'][$key])) {
        return '<div class="alert alert-dismissible fade show p-0 mt-1 mb-0 bg-transparent border-0 text-danger d-flex align-items-center" role="alert" style="font-size: 0.875em;">' 
             . '<span class="mr-auto">' . htmlspecialchars($_SESSION['errors'][$key]) . '</span>'
             . '<button type="button" class="close position-static p-0 ml-2" data-dismiss="alert" aria-label="Close" style="font-size: 1.25rem; line-height: 1; outline: none;">'
             . '<span aria-hidden="true">&times;</span>'
             . '</button>'
             . '</div>';
    }
    return '';
}

/**
 * Hàm tạo URL động (Giống hàm route() của Laravel)
 * Ví dụ: route('nhacungcap', 'index', ['page' => 2]) 
 * -> index.php?controller=nhacungcap&action=index&page=2
 */
function route($controller, $action = 'index', $params = [])
{
  $url = "index.php?controller={$controller}&action={$action}";

  if (!empty($params)) {
    $url .= '&' . http_build_query($params);
  }

  return $url;
}

/**
 * Hàm chuyển hướng đến URL cụ thể kèm thông báo (Giống redirect()->with())
 */
function redirect_with($url, $type, $message)
{
  // Lưu thông báo dạng Flash Session
  $_SESSION['flash_message'] = [
    'type' => $type,
    'message' => $message
  ];

  header("Location: " . $url);
  exit();
}
