<?php
class DB
{
  private static $instance = NULL;
  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      try {
        // Viết liền mạch chuỗi kết nối
        self::$instance = new PDO('mysql:host=localhost;dbname=qltaichinh', 'cdweb', 'Cdweb@1235');
        self::$instance->exec("SET NAMES 'utf8'");
      } catch (PDOException $ex) {
        die($ex->getMessage());
      }
    }
    return self::$instance;
  }
}
