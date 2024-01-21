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
