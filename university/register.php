<html>

<head>
  <link rel="icon" href="../assets/img/logo.png">
  <title>Đăng nhập | Trường đại học</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once("../includes/universities.php");
  $univerList = getUniverList();


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("../includes/users.php");

    $univerId = $_POST["selUniversity"];
    $username = $_POST["txtUsername"];
    $password = $_POST["txtPassword"];
    $rePassword = $_POST["txtRePassword"];

    if ($password == $rePassword) {
      if (registerAsUniver($username, $password, $univerId)) {
        echo "<script>alert('Đăng ký thành công!')</script>";
        echo "<script>window.location.href='login.php'</script>";
        // header("location:login.php");
        exit();
      } else {
        echo "<script>alert('Đăng ký không thành công! Vui lòng thử lại sau!')</script>";
      }
    } else {
      echo "<script>alert('Mật khẩu không trùng khớp!')</script>";
    }
  }
  ?>

  <main class="d-flex flex-column justify-content-center align-items-center" style="width: 100%; min-height: 100vh">
    <a class="container mb-3 px-0 row" href="../index.php" style="text-decoration: none;">
      <img class="col-2" src="../assets/img/logo.png" />
      <h3 class="col-10 m-0 d-flex align-items-center text-white">
        TUYỂN SINH<br />ĐẠI HỌC 2024
      </h3>
    </a>
    <div class="container p-5 bg-white rounded">
      <h3 class="m-0 fw-bold text-center">ĐĂNG KÝ</h3>
      <p class="text-center text-primary">(với tư cách là trường đại học)</p>

      <form action="register.php" method="POST">
        <div class="mb-3">
          <label class="form-label">Trường đại học: <red>*</red></label>
          <select class="form-select" name="selUniversity" required>
            <option value="">-Chọn trường đại học-</option>
            <?php while ($row = $univerList->fetch_assoc()) {
              //kiem tra xem truong da co tai khoan hay chua
              if (!is_null($row["user_id"])) break;
            ?>
              <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Tên tài khoản: <red>*</red></label>
          <input class="form-control" type="text" name="txtUsername" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu: <red>*</red></label>
          <input class="form-control" type="password" name="txtPassword" required />
        </div>
        <div class="mb-5">
          <label class="form-label">Nhập lại mật khẩu: <red>*</red></label>
          <input class="form-control" type="password" name="txtRePassword" required />
        </div>
        <div class="d-flex flex-column gap-3">
          <button class="btn btn-primary" type="submit">Đăng ký</button>
          <p>Đã có tài khoản? <a href="./login.php">Đăng nhập ngay.</a></p>
        </div>
      </form>
    </div>
  </main>
</body>

</html>