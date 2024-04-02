<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Hồ sơ | Tuyển sinh đại học - Trường Đại học Công nghệ Đông Á</title>
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

  require_once "../core/UserCtrl.php";
  require_once "../core/StudentCtrl.php";

  $currentUser = UserCtrl::getCurrentUser();
  $studentProfile = StudentCtrl::getStudentByUserId($currentUser->id);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addProfile"])) {
      $name = $_POST["name"];
      $gender = $_POST["gender"];
      $birthdate = $_POST["birthdate"];
      $address = $_POST["address"];
      $school = $_POST["school"];
      $citizenId = $_POST["citizenId"];
      $transcript = $_POST["transcript"];
      $userId = $currentUser->id;

      if (StudentCtrl::addStudent($name, $gender, $birthdate, $address, $school, $citizenId, $transcript, $userId)) {
        echo "<script>alert('Thay đổi thông tin thành công');window.location.href='/student/profile.php'</script>";
      } else {
        echo "<script>alert('Thay đổi thông tin không thành công')</script>";
      }

    } elseif (isset($_POST["updateProfile"])) {
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
          <a class="nav-link active fw-medium" href="/student/profile.php">Hồ sơ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-medium" href="/student/wishlist.php">Nguyện vọng</a>
        </li>
        <li class="nav-item dropstart">
          <a class="nav-link dropdown-toggle fw-medium" href="#" data-bs-toggle="dropdown">Tài khoản</a>
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
      <h2 class="text-primary">Thông tin hồ sơ tuyển sinh</h2>
      <h3 class="text-primary">
        <a href="#">Trường Đại học Công nghệ Đông Á</a>
      </h3>

      <div class="mt-5 row">
        <div class="col-6">
          <ul>
            <li>
              <h4>Họ tên: <span class="fw-normal">
                  <?php echo $studentProfile == null ? "" : $studentProfile->name ?>
                </span>
              </h4>
            </li>
            <li>
              <h4>Giới tính: <span class="fw-normal">
                  <?php echo $studentProfile == null ? "" : ($studentProfile->gender == 1 ? "Nam" : "Nữ") ?>
                </span>
              </h4>
            </li>
            <li>
              <h4>Ngày sinh: <span class="fw-normal">
                  <?php echo $studentProfile == null ? "" : $studentProfile->birthdate ?>
                </span>
              </h4>
            </li>
            <li>
              <h4>Địa chỉ: <span class="fw-normal">
                  <?php echo $studentProfile == null ? "" : $studentProfile->address ?>
                </span>
              </h4>
            </li>
            <li>
              <h4>Tên trường THPT: <span class="fw-normal">
                  <?php echo $studentProfile == null ? "" : $studentProfile->school ?>
                </span>
              </h4>
            </li>
          </ul>
        </div>
        <div class="col-6">
          <ul>
            <li>
              <h4>CCCD: <a class="btn btn-info"
                  href="<?php echo $studentProfile == null ? "#" : $studentProfile->citizenId ?>">Xem hồ sơ</a>
              </h4>
            </li>
            <li>
              <h4>Học bạ: <a class="btn btn-info"
                  href="<?php echo $studentProfile == null ? "#" : $studentProfile->transcript ?>">Xem hồ sơ</a>
              </h4>
            </li>
          </ul>

          <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
            Thay đổi thông tin
          </button>
        </div>
      </div>
    </div>
  </main>

  <div id="modalWrapper">
    <div id="updateProfileModal" class="modal">
      <div class="bg-body-secondary fixed-top" style="width: 100vw; height: 100vh; z-index: -10; opacity: 0.75"></div>
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thay đổi thông tin hồ sơ</h5>
            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <form action="profile.php" method="post" enctype="multipart/form-data">
              <div class="mb-3">
                <label class="form-label fw-bold"> Họ tên: </label>
                <input class="form-control" type="text" name="name" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Giới tính: </label>
                <select class="form-select" name="gender" required>
                  <option value="">-Chọn giới tính-</option>
                  <option value="0">Nữ</option>
                  <option value="1">Nam</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Ngày sinh: </label>
                <input class="form-control" type="date" name="birthdate" max="<?php echo date('Y') - 16 ?>-12-31"
                  required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Địa chỉ: </label>
                <input class="form-control" type="text" name="address" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Tên trường THPT: </label>
                <input class="form-control" type="text" name="school" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> CCCD: </label>
                <input class="form-control" type="text" name="citizenId"
                  placeholder="Đường link đến tệp trong GoogleDrive" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold"> Học bạ: </label>
                <input class="form-control" type="text" name="transcript"
                  placeholder="Đường link đến tệp trong GoogleDrive" required />
              </div>

              <button class="btn btn-success" type="submit"
                name="<?php echo $studentProfile == null ? "addProfile" : "updateProfile" ?>">
                Xác nhận
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>