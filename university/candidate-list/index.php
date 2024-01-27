<html>

<head>
  <link rel="icon" href="../../assets/img/logo.png">
  <title>Trang chủ | Trường đại học</title>
  <link rel="stylesheet" href="../../assets/css/main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once("../../includes/users.php");

  if (!isLoggedInAsUniversity()) {
    header("location:login.php");
    exit();
  }

  require_once("../../includes/universities.php");
  $univerId = getUniverId($_COOKIE["user"]);
  $candidateList = getCandidateList($univerId);
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
        <a class="nav-link" href="../index.php">
          <i class="bi bi-house"></i>
          <span class="ms-2 _toggle">Trang chủ</span>
        </a>
        <a class="nav-link active" href="./index.php">
          <i class="bi bi-list-stars"></i>
          <span class="ms-2 _toggle">Tuyển sinh</span>
        </a>
        <a class="nav-link" href="../change-password.php">
          <i class="bi bi-person-lock"></i>
          <span class="ms-2 _toggle">Thay đổi mật khẩu</span>
        </a>
      </div>
      <hr />
      <div class="nav">
        <a class="nav-link" href="../login.php">
          <i class="bi bi-box-arrow-up-left"></i>
          <span class="ms-2 _toggle">Đăng xuất</span>
        </a>
      </div>
    </div>

    <div class="flex-fill d-flex flex-column">
      <!-- header -->
      <div class="container-fluid bg-light-subtle m-0 row justify-content-between align-items-center border-bottom" style="height: 4rem">
        <h3 class="col m-0">Danh sách tuyển sinh</h3>
      </div>

      <!-- content -->
      <div class="h-100 w-100 p-3 bg-light-subtle">
        <h5 class="text-primary mb-3">DANH SÁCH TUYỂN SINH</h5>
        <table class="table table-striped-columns">
          <thead>
            <tr class="table-primary">
              <th>Họ tên</th>
              <th>Ngày sinh</th>
              <th>Địa chỉ</th>
              <th>Kết quả</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($candidate = $candidateList->fetch_assoc()) { ?>
              <!-- wish_id, name, birthday, address, result -->
              <tr>
                <td><?php echo $candidate["name"] ?></td>
                <td><?php echo $candidate["birthday"] ?></td>
                <td><?php echo $candidate["address"] ?></td>
                <td>
                  <?php if ($candidate["result"] === 1) { ?>
                    <i class="bi bi-check-square-fill text-success"></i>
                  <?php } elseif ($candidate["result"] === 0) { ?>
                    <i class="bi bi-x-square-fill text-danger"></i>
                  <?php } else { ?>
                    <i class="bi bi-dash-square-fill text-primary"></i>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($candidate["result"] !== 1 && $candidate["result"] !== 0) { ?>
                    <a class="btn btn-success" href="./pass.php?pass=1&wish_id=<?php echo $candidate["wish_id"] ?>" onclick="return confirm('Xác nhận đậu?')">Đậu</a>
                    <a class="btn btn-danger" href="./pass.php?pass=0&wish_id=<?php echo $candidate["wish_id"] ?>" onclick="return confirm('Xác nhận trượt?')">Trượt</a>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>

</html>