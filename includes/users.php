<?php
require_once('database.php');

#region utils
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
function isStudent($username)
{
  $db = new database();
  $result = $db->execute("select * from students where user_id=?", "s", $username);
  return $result->num_rows == 1;
}
function isUniversity($username)
{
  $db = new database();
  $result = $db->execute("select * from universities where user_id=?", "s", $username);
  return $result->num_rows == 1;
}
#endregion


#region is logged in
function isLoggedIn()
{
  if (isset($_COOKIE["user"])) {
    if (validUser($_COOKIE["user"])) {
      return true;
    }
  }

  return false;
}
function isLoggedInAsStudent()
{
  if (isLoggedIn()) {
    return isStudent($_COOKIE["user"]);
  }

  return false;
}
function isLoggedInAsUniversity()
{
  if (isLoggedIn()) {
    return isUniversity($_COOKIE["user"]);
  }

  return false;
}
#endregion


#region login
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
function loginAsStudent($username, $password, $keepLogin)
{
  if (isStudent($username)) {
    return login($username, $password, $keepLogin);
  }

  return false;
}
function loginAsUniversity($username, $password, $keepLogin)
{
  if (isUniversity($username)) {
    return login($username, $password, $keepLogin);
  }

  return false;
}
#endregion


#region register
function register($username, $password)
{
  $db = new database();
  // tao mot tai khoan moi trong bang users
  return $db->execute("INSERT INTO Users (username,password,admin) VALUES (?,?,?)", "ssi", $username, $password, 0);
}
function registerAsStudent($username, $password)
{
  if (register($username, $password)) { // kiem tra xem co tao dc tai khoan hay k
    $db = new database();
    // tao mot hoc sinh moi cho tai khoan vua tao
    return $db->execute("insert into students (user_id) values (?)", "s", $username);
  }

  return false;
}
function registerAsUniver($username, $password, $univer_id)
{
  $db = new database();
  $result = $db->execute("select * from universities where id=? and user_id is null", "s", $univer_id);

  if ($result->num_rows == 1) { // chac chan rang truong chua co tai khoan
    if (register($username, $password)) { // kiem tra xem co tao dc tai khoan hay k
      // them ten tai khoan cho truong
      return $db->execute("update universities set user_id=? where id=?", "ss", $username, $univer_id);
    }
  }

  return false;
}
#endregion


function updatePassword($username, $password)
{
  $db = new database();
  return $db->execute("UPDATE Users SET password = ? WHERE username = ?", "ss", $password, $username);
}
