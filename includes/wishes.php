<?php
require_once("database.php");

function addWish($user_id, $univer_id, $major_id)
{
  $db = new database();
  if ($db->execute("INSERT INTO wishes(user_id, um_id) SELECT ?, u_m.id FROM u_m LEFT JOIN wishes ON u_m.id = wishes.um_id AND wishes.user_id = ? WHERE u_m.univer_id = ? AND u_m.major_id = ? AND wishes.user_id IS NULL;", "sssi", $user_id, $user_id, $univer_id, $major_id)) {
    return $db->getAffectedRowId() != 0;
  }

  return false;
}

function deleteWish($wish_id)
{
  $db = new database();
  return $db->execute("delete from wishes where id=?", "s", $wish_id);
}

function updateResult($result, $wish_id)
{
  $db = new database();
  return $db->execute("update wishes set result=? where id=?", "ii", $result, $wish_id);
}
