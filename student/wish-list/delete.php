<html>

<head>
  <link rel="icon" href="../../assets/img/logo.png">
  <title>Xoá ngành | Trường đại học</title>
</head>

<body>
  <?php
  require_once("../../includes/users.php");

  if (!isLoggedInAsStudent()) {
    header("location:../login.php");
    exit();
  }

  require_once("../../includes/wishes.php");

  $wishId = $_GET["wish_id"];

  if (deleteWish($wishId)) {
    echo "<script>alert('Xoá nguyện vọng thành công!')</script>";
  } else {
    echo "<script>alert('Xoá nguyện vọng không thành công!')</script>";
  }
  ?>
  <script>
    window.location.href = './index.php';
  </script>

</body>

</html>