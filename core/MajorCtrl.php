<?php
require_once "Major.php";
class MajorCtrl
{
  /**
   * @return array<Major>
   */
  public static function getMajorList($search = ""): array
  {
    $majorList = array();

    $conn = new ConnDB();

    if (empty($search)) {
      $data = $conn->execute("SELECT * FROM tb_majors");

      while ($row = $data->fetch_assoc()) {
        $major = new Major($row['id'], $row['name'], $row['score']);
        $majorList[] = $major;
      }
    } else {
      $data = $conn->execute("SELECT * FROM tb_majors WHERE id=? OR name=?", "ss", $search, $search);

      while ($row = $data->fetch_assoc()) {
        $major = new Major($row['id'], $row['name'], $row['score']);
        $majorList[] = $major;
      }
    }

    return $majorList;
  }

  public static function getMajorById($majorId): Major|null
  {
    $conn = new ConnDB();
    $data = $conn->execute("SELECT * FROM tb_majors WHERE id=?", "i", $majorId);

    while ($row = $data->fetch_assoc()) {
      return new Major($row['id'], $row['name'], $row['score']);
    }

    return null;
  }
}