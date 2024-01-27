<?php
require_once('database.php');

function getUniverList()
{
  $db = new database();
  $result = $db->execute("select * from universities");
  return $result;
}

function searchUniver($value)
{
  $value = "%" . $value . "%";

  $db = new database();
  // = ... Đông
  // like ... Đông Á
  //select * from universities where name = %Đông% or id like %Đông%
  $result = $db->execute("select * from universities where name like ? or id like ?", "ss", $value, $value);
  return $result;
}

function getUniverInfo($username)
{
  $db = new database();
  return $db->execute("select * from universities where user_id=?", "s", $username);
}

function getUniverId($username)
{
  $result = getUniverInfo($username);
  $univerInfo = $result->fetch_assoc();
  return $univerInfo["id"];
}

function getCandidateList($univer_id)
{
  // wish_id, name, birthday, address, major_id, major_name, result
  $db = new database();
  return $db->execute("SELECT wishes.id AS wish_id, students.name, students.birthday, students.address, majors.id AS major_id, majors.name AS major_name, wishes.result FROM students JOIN wishes ON students.user_id = wishes.user_id JOIN u_m ON wishes.um_id = u_m.id JOIN majors ON u_m.major_id = majors.id WHERE u_m.univer_id = ?", "s", $univer_id);
}
