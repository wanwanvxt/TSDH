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

  require_once("../../includes/majors.php");
  require_once("../../includes/universities.php");

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