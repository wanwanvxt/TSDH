<?php
class ConnDB
{
  private $hostname = "localhost:3306";
  private $username = "root";
  private $password = "";
  private $dbname = "db_tsdh";

  private $conn = null;

  public function __construct()
  {
    $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
    if ($this->conn->connect_error) {
      die("ket noi database khong thanh cong: " . $this->conn->connect_error);
    }
  }
  public function __destruct()
  {
    $this->conn->close();
  }

  public function execute($sql, $types = "", ...$vars): bool|mysqli_result
  {
    if ($this->conn->connect_error) {
      die("ket noi database khong thanh cong: " . $this->conn->connect_error);
    }
    
    if (!empty($types)) {
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param($types, ...$vars);

      $success = $stmt->execute();
      if ($success) {
        $result = $stmt->get_result();

        if (!$result) {
          return true;
        }

        $stmt->close();
        return $result;
      }

      $stmt->close();
      return false;
    }

    return $this->conn->query($sql);
  }
}