<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    Tài khoản | Tuyển sinh đại học - Trường Đại học Công nghệ Đông Á
  </title>
  <link rel="stylesheet" href="/assets/bootstrap/bootstrap.min.css" />
  <script src="/assets/bootstrap/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once "../core/UserCtrl.php";
  if (!UserCtrl::isStudentLoggedIn()) {
    header("location: /student/login.php");
    exit();
  }

  /** */

  $currentUser = UserCtrl::getCurrentUser();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["updateEmail"])) {
      $email = $_POST["email"];

      if ($_POST["password"] == $currentUser->password) {
        if (UserCtrl::updateUser($currentUser->id, $email, $currentUser->password, $currentUser->admin)) {
          setcookie("login", $email, time() + 3600 * 24 * 30);
          echo "<script>alert('Thay đổi thành công')</script>";
        } else {
          echo "<script>alert('Thay đổi không thành công')</script>";
        }
      } else {
        echo "<script>alert('Mật khẩu không khớp')</script>";
      }
    } elseif (isset($_POST["updatePassword"])) {
      $oldPassword = $_POST["oldPassword"];
      $newPassword = $_POST["newPassword"];
      $confirmNewPassword = $_POST["confirmNewPassword"];

      if ($oldPassword == $currentUser->password) {
        if ($newPassword == $confirmNewPassword) {
          if (UserCtrl::updateUser($currentUser->id, $currentUser->email, $newPassword, $currentUser->admin)) {
            echo "<script>alert('Thay đổi thành công')</script>";
          } else {
            echo "<script>alert('Thay đổi không thành công')</script>";
          }
        } else {
          "<script>alert('Mật mới khẩu không khớp')</script>";
        }
      } else {
        echo "<script>alert('Mật khẩu cũ không khớp')</script>";
      }
    }
  }
  ?>

  <nav class="fixed-top navbar navbar-expand-lg bg-primary-subtle shadow-sm">
    <div class="container-fluid" style="height: 4.5rem">
      <a class="navbar-brand" href="/">
        <img src="/assets/img/eaut_brand.webp" alt="Trường Đại học Công nghệ Đông Á" width="60" />
      </a>

      <ul class="nav nav-pills nav-fill gap-2 p-1">
        <li class="nav-item">
          <a class="nav-link fw-medium" href="/student">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-medium" href="/student/profile.php">Hồ sơ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-medium" href="/student/wishlist.php">Nguyện vọng</a>
        </li>
        <li class="nav-item dropstart">
          <a class="nav-link active dropdown-toggle fw-medium" href="#" data-bs-toggle="dropdown">Tài khoản</a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item fw-medium" href="/student/user.php">Thông tin tài khoản</a>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <a class="dropdown-item fw-medium" href="/student/logout.php">Đăng xuất</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <main style="margin-top: 6rem; min-height: calc(100vh - 6rem)">
    <div class="container-fluid py-3">
      <h2 class="text-primary">Thông tin tài khoản</h2>
      <h3 class="text-primary">
        <a href="#">Trường Đại học Công nghệ Đông Á</a>
      </h3>

      <div class="mt-5">
        <h4>Email:</h4>
        <div class="mb-3 d-flex gap-3">
          <p>
            <?php echo $_COOKIE["login"] ?>
          </p>
          <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updateEmailModal">
            Thay đổi
          </button>
        </div>

        <h4>Mật khẩu:</h4>
        <div class="mb-3 d-flex gap-3">
          <p>********</p>
          <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
            Thay đổi
          </button>
        </div>
      </div>

      <hr class="table-group-divider my-5" />

      <a class="btn btn-warning" href="/student/logout.php">Đăng xuất</a>
    </div>
  </main>

  <div id="modalWrapper">
    <div id="updateEmailModal" class="modal">
      <div class="bg-body-secondary fixed-top" style="width: 100vw; height: 100vh; z-index: -10; opacity: 0.75"></div>
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thay đổi email</h5>
            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-bold"> Email cũ: </label>
              <h5>
                <?php echo $_COOKIE["login"] ?>
              </h5>
            </div>

            <form action="user.php" method="post">
              <div class="mb-3">
                <label class="form-label fw-bold"> Email mới: </label>
                <input class="form-control" type="email" name="email" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Mật khẩu: </label>
                <input class="form-control" type="password" name="password" required />
              </div>

              <button class="btn btn-success" type="submit" name="updateEmail">Xác nhận</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div id="updatePasswordModal" class="modal">
      <div class="bg-body-secondary fixed-top" style="width: 100vw; height: 100vh; z-index: -10; opacity: 0.75"></div>
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thay đổi mật khẩu</h5>
            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <form action="user.php" method="post">
              <div class="mb-3">
                <label class="form-label fw-bold"> Mật khẩu cũ: </label>
                <input class="form-control" type="password" name="oldPassword" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Mật khẩu mới: </label>
                <input class="form-control" type="password" name="newPassword" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Nhập lại mật khẩu mới: </label>
                <input class="form-control" type="password" name="confirmNewPassword" required />
              </div>

              <button class="btn btn-success" type="submit" name="updatePassword">Xác nhận</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>