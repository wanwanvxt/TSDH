<?php
require_once('database.php');
// id, name, birthday, block, email, phone, address, user_id
function getStudentInfo($user_id)
{
  $db = new database();
  return $db->execute("SELECT * FROM Students WHERE user_id = ?", "s", $user_id);
}

function updateStudentInfo($user_id, $name, $birthday, $block, $email, $phone, $address)
{
  $db = new database();
  return $db->execute("UPDATE Students SET name = ?, birthday = ?, block = ?, email = ?, phone = ?, address = ? WHERE user_id = ?", "sssssss", $name, $birthday, $block, $email, $phone, $address, $user_id);
}

function studentInfoIsEmpty($user_id)
{
  $result = getStudentInfo($user_id);
  $studentInfo = $result->fetch_assoc();
  foreach ($studentInfo as $col => $value) {
    if (empty($value)) {
      return true;
    }
  }
  return false;
}

function getWishListByStudent($user_id)
{
  // wish_id, major_id, major_name, univer_id, univer_name, block, result 
  $db = new database();
  return $db->execute("SELECT wishes.id AS wish_id, majors.id AS major_id, majors.name AS major_name, universities.id AS univer_id, universities.name AS univer_name, u_m.block AS block, wishes.result AS result FROM wishes JOIN u_m ON wishes.um_id = u_m.id JOIN majors ON u_m.major_id = majors.id JOIN universities ON u_m.univer_id = universities.id WHERE wishes.user_id=?", "s", $user_id);
}
