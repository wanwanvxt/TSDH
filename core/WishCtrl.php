<?php
require_once "Wish.php";
class WishCtrl
{
  /** 
   * @return array<Wish>
   */
  public static function getWishListByStudent($studentId): array
  {
    $wishList = array();

    $conn = new ConnDB();
    $data = $conn->execute("SELECT * FROM tb_wishes WHERE studentId=?", "s", $studentId);

    while ($row = $data->fetch_assoc()) {
      $wish = new Wish($row['id'], $row['studentId'], $row['majorId'], $row["pass"]);
      $wishList[] = $wish;
    }

    return $wishList;
  }

  public static function addWish($majorId, $studentId): bool
  {
    if (!WishCtrl::studentHasWish($studentId, $majorId)) {
      $conn = new ConnDB();
      return $conn->execute("INSERT INTO tb_wishes (majorId, studentId) VALUES (?,?)", "si", $majorId, $studentId);
    }

    return false;
  }

  public static function deleteWish($wishId): bool
  {
    $conn = new ConnDB();
    return $conn->execute("DELETE FROM tb_wishes WHERE id=?", "i", $wishId);
  }

  public static function studentHasWish($studentId, $majorId): bool
  {
    $conn = new ConnDB();
    $result = $conn->execute("SELECT COUNT(*) AS count FROM tb_wishes WHERE studentId=? AND majorId=?", "si", $studentId, $majorId);

    if ($result->num_rows == 1) {
      while ($row = $result->fetch_assoc()) {
        if ($row["count"] == 1) {
          return true;
        }
      }
    }

    return false;
  }
}