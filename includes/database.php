<?php
class database
{
  private $hostname = 'localhost:3306';
  private $username = 'root';
  private $password = '';
  private $dbname = 'dbTSDH';

  private $conn = '';

  public function __construct()
  {
    $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
    if ($this->conn->connect_error) {
      die("Ket noi database khong thanh cong: " . $this->conn->connect_error);
    }
  }
  public function __destruct()
  {
    $this->conn->close();
  }

  //select, insert, update, delete, 
  public function execute($sql, $types = "", ...$vars)
  {
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
