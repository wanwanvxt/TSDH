<html>

<head>
  <link rel="icon" href="../assets/img/logo.png">
  <title>Thay đổi mật khẩu | Trường đại học</title>
  <link rel="stylesheet" href="../assets/css/main.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once("../includes/users.php");

  if (!isLoggedInAsUniversity()) {
    header("location:login.php");
    exit();
  }

  $username = $_COOKIE["user"];
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["txtPassword"];
    $rePassword = $_POST["txtRePassword"];

    if ($password == $rePassword) {
      if (updatePassword($username, $password)) {
        echo "<script>alert('Thay đổi mật khẩu thành công!')</script>";
      }
    } else {
      echo "<script>alert('Mật khẩu không trùng khớp!')</script>";
    }
  }
  ?>

  <main class="container-fluid px-0 d-flex" style="min-height: 100vh">
    <!-- side bar -->
    <input id="chbSidebar" class="visually-hidden" type="checkbox" checked />
    <div id="sidebar" class="bg-light-subtle border-end p-3 d-flex flex-column" style="max-width: 18rem; z-index: 999">
      <h5 class="row m-0 d-flex align-items-center">
        <span class="col-10 p-0 ps-2 _toggle">
          TUYỂN SINH<br />ĐẠI HỌC 2024
        </span>
        <label class="col p-0 btn fs-3" for="chbSidebar">
          <i class="bi bi-list"></i>
        </label>
      </h5>
      <hr />
      <div class="nav nav-pills flex-column mb-auto">
        <a class="nav-link" href="./index.php">
          <i class="bi bi-house"></i>
          <span class="ms-2 _toggle">Trang chủ</span>
        </a>
        <a class="nav-link" href="#">
          <i class="bi bi-list-stars"></i>
          <span class="ms-2 _toggle">Danh sách tuyển sinh</span>
        </a>
        <a class="nav-link active" href="./change-password.php">
          <i class="bi bi-person-lock"></i>
          <span class="ms-2 _toggle">Thay đổi mật khẩu</span>
        </a>
      </div>
      <hr />
      <div class="nav">
        <a class="nav-link" href="./login.php">
          <i class="bi bi-box-arrow-up-left"></i>
          <span class="ms-2 _toggle">Đăng xuất</span>
        </a>
      </div>
    </div>
    </div>

    <div class="flex-fill d-flex flex-column">
      <!-- header -->
      <div class="container-fluid bg-light-subtle m-0 row justify-content-between align-items-center border-bottom" style="height: 4rem">
        <h3 class="col m-0">Thay đổi mật khẩu</h3>
      </div>

      <!-- content -->
      <div class="h-100 w-100 p-3 bg-light-subtle">
        <h5>Tài khoản: <?php echo $username ?></h5>
        <form action="change-password.php" style="max-width: 30rem" method="POST">
          <div class="mb-3">
            <label class="form-label">Mật khẩu mới: <red>*</red></label>
            <input class="form-control" type="password" name="txtPassword" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Nhập lại mật khẩu mới: <red>*</red></label>
            <input class="form-control" type="password" name="txtRePassword" required />
          </div>
          <button class="btn btn-success" type="submit">Xác nhận</button>
        </form>
      </div>
    </div>
  </main>
</body>

</html>