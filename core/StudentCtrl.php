<?php
require_once "Student.php";
class StudentCtrl
{
  public static function getStudentByUserId($userId): Student|null
  {
    $conn = new ConnDB();
    $data = $conn->execute("SELECT * FROM tb_students WHERE userId=?", "s", $userId);

    while ($row = $data->fetch_assoc()) {
      return new Student($row['id'], $row['name'], $row['gender'], $row['birthdate'], $row["address"], $row["school"], $row["citizenId"], $row["transcript"], $row["userId"]);
    }

    return null;
  }

  public static function addStudent($name, $gender, $birthdate, $address, $school, $citizenId, $transcript, $userId)
  {
    $conn = new ConnDB();
    return $conn->execute("INSERT INTO tb_students (name,gender,birthdate,address,school,citizenId,transcript,userId) VALUES (?,?,?,?,?,?,?,?)", "sisssssi", $name, $gender, $birthdate, $address, $school, $citizenId, $transcript, $userId);
  }

  public static function updateStudent($name, $gender, $birthdate, $address, $school, $citizenId, $transcript, $userId)
  {
    $conn = new ConnDB();
    return $conn->execute("UPDATE tb_students SET name=? , gender=?, birthdate=?, address=?, school=?, citizenId=?, transcript=?, userId?", "sisssssi", $name, $gender, $birthdate, $address, $school, $citizenId, $transcript, $userId);
  }
}