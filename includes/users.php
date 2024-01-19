<?php
require('database.php');

function validUser($username, $password = "")
{
  $db = new database();
  $result = "";

  if (empty($password)) {
    $result = $db->execute("select * from users where username=?", "s", $username);
  } else {
    $result = $db->execute("select * from users where username=? and password=?", "ss", $username, $password);
  }

  if ($result->num_rows == 1) {
    return true;
  }

  return false;
}

function isLoggedIn()
{
  if (isset($_COOKIE["user"])) {
    if (validUser($_COOKIE["user"])) {
      return true;
    }
  }

  return false;
}

function login($username, $password, $keepLogin)
{
  if (validUser($username, $password)) {
    if ($keepLogin) {
      setcookie("user", $username, time() + 3600 * 24 * 30);
    } else {
      setcookie("user", $username, 0);
    }

    return true;
  }

  return false;
}

function register($username, $password)
{
  $db = new database();
  return $db->execute("INSERT INTO Users (username,password,admin) VALUES (?,?,?)", "ssi", $username, $password, 0);
}

function updatePassword($username, $password)
{
  $db = new database();
  return $db->execute("UPDATE Users SET password = ? WHERE username = ?", "ss", $password, $username);
}
