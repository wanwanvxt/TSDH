<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng ký | Tuyển sinh đại học - Trường Đại học Công nghệ Đông Á</title>
  <link rel="icon" type="image/x-icon" href="/assets/img/eaut_brand.webp">
  <link rel="stylesheet" href="/assets/bootstrap/bootstrap.min.css" />
  <script src="/assets/bootstrap/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../core/User.php";
    require_once "../core/UserCtrl.php";

    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($password == $confirmPassword) {
      if (UserCtrl::registerAsStudent($email, $password)) {
        echo "<script>alert('Đăng ký thành công');window.location.href='/student/login.php'</script>";
      } else {
        echo "<script>alert('Đăng ký không thành công')</script>";
      }
    } else {
      echo "<script>alert('Mật khẩu không trùng khớp')</script>";
    }
  }
  ?>

  <header class="text-primary p-3 mb-5 d-flex justify-content-center align-items-center">
    <img src="/assets/img/eaut_brand.webp" alt="Trường Đại học Công nghệ Đông Á" width="120" />
    <h3 class="m-0 ms-3 text-uppercase fw-bold">
      Tuyển sinh đại học -<br />
      Trường Đại học Công nghệ Đông Á
    </h3>
  </header>

  <main class="mb-5 px-3 d-flex justify-content-center">
    <div class="card p-3 bg-body-tertiary" style="width: 50rem">
      <h3 class="fw-bold text-center">ĐĂNG KÝ</h3>
      <p class="text-center text-primary mb-5">(với tư cách là học sinh)</p>

      <form class="d-flex flex-column gap-3" action="/student/register.php" method="post">
        <label class="form-label fw-medium">
          Email <span class="text-danger">*</span>
          <input class="form-control" type="email" name="email" required />
        </label>
        <label class="form-label fw-medium">
          Mật khẩu <span class="text-danger">*</span>
          <input class="form-control" type="password" name="password" required />
        </label>
        <label class="form-label fw-medium">
          Nhập lại mật khẩu <span class="text-danger">*</span>
          <input class="form-control" type="password" name="confirmPassword" required />
        </label>
        <button class="btn btn-primary" type="submit">Đăng ký</button>

        <p>Đã có tài khoản? <a href="/student/login.php">Đăng nhập ngay</a></p>
      </form>
    </div>
  </main>

  <footer>
    <h4 class="text-center">
      Bản quyền &copy;
      <a href="https://eaut.edu.vn">Trường Đại học Công nghệ Đông Á</a>
    </h4>
  </footer>
</body>

</html>