<?php
require_once("database.php");


#region university
function getMajorListNotOwn($univer_id)
{
  $db = new database();
  return $db->execute("SELECT majors.* FROM majors LEFT JOIN u_m ON majors.id = u_m.major_id AND u_m.univer_id=? WHERE u_m.id IS NULL", "s", $univer_id);
}

function getMajorListByUniver($univer_id)
{
  $db = new database();
  // major_id, name, block, score
  return $db->execute("select u_m.major_id, majors.name, u_m.block, u_m.score from u_m join majors on u_m.major_id = majors.id where u_m.univer_id=?", "s", $univer_id);
}

function getMajorInfoByUniver($major_id, $univer_id)
{
  $db = new database();
  // major_id, name, block, score
  return $db->execute("select u_m.major_id, majors.name, u_m.block, u_m.score from u_m join majors on u_m.major_id = majors.id where u_m.major_id=? and u_m.univer_id=?", "ss", $major_id, $univer_id);
}

function addMajorByUniver($univer_id, $major_id, $block, $score)
{
  $db = new database();
  return $db->execute("insert into u_m (univer_id, major_id, block, score) values (?,?,?,?)", "sssd", $univer_id, $major_id, $block, $score);
}

function updateMajorByUniver($major_id, $univer_id, $block, $score)
{
  $db = new database();
  return $db->execute("update u_m set block=?, score=? where major_id=? and univer_id=?", "ssss", $block, $score, $major_id, $univer_id);
}

function deleteMajorByUniver($major_id, $univer_id)
{
  $db = new database();
  return $db->execute("delete from u_m where major_id=? and univer_id=?", "ss", $major_id, $univer_id);
}
#endregion