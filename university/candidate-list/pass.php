<html>

<head>
  <link rel="icon" href="../../assets/img/logo.png">
  <title>Xoá ngành | Trường đại học</title>
</head>

<body>
  <?php
  require_once("../../includes/users.php");

  if (!isLoggedInAsUniversity()) {
    header("location:../login.php");
    exit();
  }

  require_once("../../includes/wishes.php");

  $result = $_GET["pass"];
  $wishId = $_GET["wish_id"];

  if (updateResult($result, $wishId)) {
    echo "<script>alert('Xác nhận thành công!')</script>";
  } else {
    echo "<script>alert('Xác nhận không thành công!')</script>";
  }
  ?>

  <script>
    window.location.href = './index.php';
  </script>

</body>

</html>