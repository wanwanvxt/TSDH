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
}