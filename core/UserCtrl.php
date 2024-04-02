<?php
require_once "User.php";
require_once "ConnDB.php";

class UserCtrl
{
  /**
   * @return array<User>
   */
  public static function getUserList(): array
  {
    $userList = array();

    $conn = new ConnDB();
    $data = $conn->execute("SELECT * FROM tb_users");

    while ($row = $data->fetch_assoc()) {
      $user = new User($row['id'], $row['email'], $row['password'], $row['admin']);
      $userList[] = $user;
    }

    return $userList;
  }

  public static function getCurrentUser(): User|null
  {
    $email = $_COOKIE["login"];

    $conn = new ConnDB();
    $data = $conn->execute("SELECT * FROM tb_users WHERE email=?", "s", $email);

    while ($row = $data->fetch_assoc()) {
      return new User($row['id'], $row['email'], $row['password'], $row['admin']);
    }

    return null;
  }

  public static function updateUser($id, $email, $password, $admin): bool
  {
    $conn = new ConnDB();
    return $conn->execute("UPDATE tb_users SET email=?, password=?, admin=? WHERE id=?", "ssii", $email, $password, $admin, $id);
  }

  public static function isAdmin($email): bool
  {
    $conn = new ConnDB();
    $data = $conn->execute("SELECT * FROM tb_users WHERE email=?", "s", $email);

    while ($row = $data->fetch_assoc()) {
      if ($row["admin"] == 1) {
        return true;
      }
    }

    return false;
  }

  public static function isUserExist($email, $password): bool
  {
    $conn = new ConnDB();
    $result = $conn->execute("SELECT COUNT(*) as count FROM tb_users WHERE email=? AND password=?", "ss", $email, $password);

    if ($result->num_rows == 1) {
      while ($row = $result->fetch_assoc()) {
        if ($row["count"] == 1) {
          return true;
        }
      }
    }

    return false;
  }

  public static function isEmailExist($email): bool
  {
    $conn = new ConnDB();
    $result = $conn->execute("SELECT COUNT(*) as count FROM tb_users WHERE email=?", "s", $email);

    if ($result->num_rows == 1) {
      while ($row = $result->fetch_assoc()) {
        if ($row["count"] == 1) {
          return true;
        }
      }
    }

    return false;
  }

  public static function login($email, $password, $keepLogin): bool
  {
    if (UserCtrl::isUserExist($email, $password)) {
      if ($keepLogin) {
        setcookie("login", $email, time() + 3600 * 24 * 30);
      } else {
        setcookie("login", $email, 0);
      }

      return true;
    }
    return false;
  }

  public static function logout()
  {
    return setcookie("login", "", time());
  }

  public static function isLoggedIn(): bool
  {
    if (isset($_COOKIE["login"])) {
      if (UserCtrl::isEmailExist($_COOKIE["login"])) {
        return true;
      }
    }
    return false;
  }

  public static function isStudentLoggedIn(): bool
  {
    if (UserCtrl::isLoggedIn()) {
      return !UserCtrl::isAdmin($_COOKIE["login"]);
    }
    return false;
  }

  public static function isAdminLoggedIn(): bool
  {
    if (UserCtrl::isLoggedIn()) {
      return UserCtrl::isAdmin($_COOKIE["login"]);
    }
    return false;
  }
}