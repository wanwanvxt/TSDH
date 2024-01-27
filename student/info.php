<html>

<head>
  <link rel="icon" href="../assets/img/logo.png">
  <title>Trang chủ | Học sinh</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once("../includes/users.php");
  require_once("../includes/students.php");

  if (!isLoggedInAsStudent()) {
    header("location:login.php");
    exit();
  }

  $result = getStudentInfo($_COOKIE["user"]);
  $student = $result->fetch_assoc();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $birthday = $_POST["birthday"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    if (updateStudentInfo($_COOKIE["user"], $name, $birthday, $email, $phone, $address)) {
      echo "<script>alert('Thay đổi thông tin thành công!')</script>";
      header("refresh:0");
      exit();
    } else {
      echo "<script>alert('Thay đổi thông tin không thành công!')</script>";
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
        <a class="nav-link" href="./wish-list/index.php">
          <i class="bi bi-list-stars"></i>
          <span class="ms-2 _toggle">Nguyện vọng</span>
        </a>
        <a class="nav-link active" href="./info.php">
          <i class="bi bi-person-bounding-box"></i>
          <span class="ms-2 _toggle">Thông tin cá nhân</span>
        </a>
        <a class="nav-link" href="./change-password.php">
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
        <h3 class="col m-0">Thông tin cá nhân</h3>
      </div>

      <!-- content -->
      <div class="h-100 w-100 p-3 bg-light-subtle">
        <h5>Tài khoản: <?php echo $_COOKIE["user"] ?></h5>
        <form action="info.php" style="max-width: 30rem" method="POST">
          <div class="mb-3">
            <label class="form-label">Họ tên: <red>*</red></label>
            <input class="form-control" type="text" name="name" value="<?php echo $student['name'] ?>" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Ngày sinh: <red>*</red></label>
            <input class="form-control" type="date" name="birthday" max="<?php echo date('Y') - 15 ?>-12-31" value="<?php echo $student['birthday'] ?>" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Email: <red>*</red></label>
            <input class="form-control" type="email" name="email" value="<?php echo $student['email'] ?>" required />
          </div>
          <div class="mb-3">
            <label class="form-label">SĐT: <red>*</red></label>
            <input class="form-control" type="tel" name="phone" value="<?php echo $student['phone'] ?>" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Địa chỉ: <red>*</red></label>
            <input class="form-control" type="address" name="address" value="<?php echo $student['address'] ?>" required />
          </div>
          <div>
            <button class="btn btn-success" type="submit">Thay đổi</button>
            <a class="btn btn-warning" href="info.php">Huỷ</a>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>

</html>