<html>

<head>
  <link rel="icon" href="../assets/img/logo.png">
  <title>Nguyện vọng | Học sinh</title>
  <link rel="stylesheet" href="../../assets/css/main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once("../../includes/users.php");

  if (!isLoggedInAsStudent()) {
    header("location:../login.php");
    exit();
  }

  require_once("../../includes/students.php");
  // kiem tra xem da dien day tat ca thong tin hay chua
  if (studentInfoIsEmpty($_COOKIE["user"])) {
    echo "<script>alert('Vui lòng điền đầy đủ thông tin')</script>";
    echo "<script>window.location.href = '../info.php'</script>";
    exit();
  }

  $wishList = getWishListByStudent($_COOKIE["user"]);
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
          <span class="ms-2 _toggle">Nguyện vọng</span>
        </a>
        <a class="nav-link" href="../info.php">
          <i class="bi bi-person-bounding-box"></i>
          <span class="ms-2 _toggle">Thông tin cá nhân</span>
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
        <h3 class="col m-0">Nguyện vọng</h3>
      </div>

      <!-- content -->
      <div class="h-100 w-100 p-3 bg-light-subtle">
        <h5 class="text-primary">DANH SÁCH NGUYỆN VỌNG</h5>
        <!--  -->
        <table class="table table-striped-columns">
          <thead>
            <tr class="table-primary">
              <th>Ngành đăng ký</th>
              <th>Tên trường</th>
              <th>Khối thi</th>
              <th>Kết quả</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <!-- ds nguyen vong -->
            <!-- wish_id, major_id, major_name, univer_id, univer_name, block, result -->
            <?php while ($wish = $wishList->fetch_assoc()) { ?>
              <tr>
                <td><?php echo $wish["major_id"] . " - " . $wish["major_name"] ?></td>
                <td><?php echo $wish["univer_id"] . " - " . $wish["univer_name"] ?></td>
                <td><?php echo $wish["block"] ?></td>
                <td><input class="form-check-input" type="checkbox" disabled> <?php echo $wish["result"] ?></td>
                <td>
                  <a class="btn btn-warning" href="./update.php?wish_id=<?php echo $wish["wish_id"] ?>">Sửa</a>
                  <a class="btn btn-danger" href="./delete.php?wish_id=<?php echo $wish["wish_id"] ?>" onclick="return confirm('Chắc chắn muốn xoá nguyện vọng này chứ?')">Xoá</a>
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