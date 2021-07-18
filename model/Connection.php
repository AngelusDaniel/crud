<?php

final class Connection
{
  private function __construct()
  {
  }
  public static function open()
  {
    $type = "mysql";
    $user = "";
    $pass = "";
    $name = "";
    $host = "mariadb";
    $port = "3306";
    switch ($type) {
      case 'pgsql':
        $conn = new PDO("pgsql:dbname={$name};user={$user};password={$pass};host=$host");
        break;
      case 'mysql':
        $conn = new
          PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
        break;
      case 'sqlite':
        $conn = new PDO("sqlite:{$name}");
        break;
      case 'ibase':
        $conn = new PDO("firebird:dbname={$name}", $user, $pass);
        break;
      case 'oci8':
        $conn = new PDO("oci:dbname={$name}", $user, $pass);
        break;
      case 'mssql':
        $conn = new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
        break;
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->query("SET NAMES utf8");
    return $conn;
  }
}