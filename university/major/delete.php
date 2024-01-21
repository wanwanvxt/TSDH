<html>

<head>
  <link rel="icon" href="../../assets/img/logo.png">
  <title>Xoá ngành | Trường đại học</title>
  <link rel="stylesheet" href="../../assets/css/main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once("../../includes/users.php");

  if (!isLoggedInAsUniversity()) {
    header("location:../login.php");
    exit();
  }

  require_once("../../includes/majors.php");
  require_once("../../includes/universities.php");

  //kiem tra xem co phai xoa truong cua minh hay k
  $univerId = getUniverId($_COOKIE["user"]);
  $majorId = $_GET["major_id"];

  if (deleteMajorByUniver($majorId, $univerId)) {
    echo "<script>alert('Xoá ngành thành công!')</script>";
  } else {
    echo "<script>alert('Xoá ngành không thành công!')</script>";
  }
  ?>
  <script>
    window.location.href = '../index.php';
  </script>

</body>

</html>