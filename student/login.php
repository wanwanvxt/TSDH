<html>

<head>
  <link rel="icon" href="../assets/img/logo.png">
  <title>Đăng nhập | Học sinh</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require("../includes/users.php");

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["txtUsername"];
    $password = $_POST["txtPassword"];
    $keepLogin = false;
    if (isset($_POST["chbKeepLogin"])) {
      $keepLogin = true;
    }

    if (login($username, $password, $keepLogin)) {
      header("location:index.php");
      exit();
    } else {
      echo "<script>alert('Tài khoản hoặc mật khẩu không chính xác!')</script>";
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
      <h3 class="m-0 fw-bold text-center">ĐĂNG NHẬP</h3>
      <p class="text-center text-primary">(với tư cách là học sinh)</p>

      <form action="login.php" method="post">
        <div class="mb-3">
          <label class="form-label">Tên tài khoản: <red>*</red></label>
          <input class="form-control" type="text" name="txtUsername" required />
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu: <red>*</red></label>
          <input class="form-control" type="password" name="txtPassword" required />
        </div>
        <div class="mb-5 form-check">
          <input class="form-check-input" type="checkbox" name="chbKeepLogin">
          <label class="form-label">Ghi nhớ đăng nhập</label>
        </div>
        <div class="d-flex flex-column gap-3">
          <button class="btn btn-success" type="submit">Đăng nhập</button>
          <p>
            Chưa có tài khoản? <a href="./register.php">Đăng ký tại đây.</a>
          </p>
        </div>
      </form>
    </div>
  </main>
</body>

</html>