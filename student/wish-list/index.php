<html>

<head>
  <link rel="icon" href="../../assets/img/logo.png">
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

  require_once("../../includes/universities.php");
  $univerList = getUniverList();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_COOKIE["user"];
    $univerId = $_POST["selUniver"];
    $majorId = $_POST["selMajor"];

    require_once("../../includes/wishes.php");
    if (addWish($userId, $univerId, $majorId)) {
      echo "<script>alert('Thêm nguyện vọng thành công!')</script>";
      header("refresh:0");
      exit();
    } else {
      echo "<script>alert('Thêm nguyện vọng không thành công!')</script>";
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

        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse">
          Thêm nguyện vọng
        </button>
        <div id="collapse" class="collapse">
          <form action="index.php" method="POST" style="max-width: 30rem;">
            <div class="mb-3">
              <label class="form-label">Trường đại học: <red>*</red></label>
              <select id="selUniver" class="form-select" name="selUniver" required onchange="matchSel(this.value)">
                <option value="">-Chọn trường đại học-</option>
                <?php while ($univer = $univerList->fetch_assoc()) { ?>
                  <option value="<?php echo $univer["id"] ?>"><?php echo $univer["id"] . " - " . $univer["name"] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Ngành đăng ký: <red>*</red></label>
              <select id="selMajor" class="form-select" name="selMajor" required>
                <option value="">-Chọn ngành-</option>
                <?php
                $univerList = getUniverList();
                require_once("../../includes/majors.php");
                while ($univer = $univerList->fetch_assoc()) {
                  $majorByUniver = getMajorListByUniver($univer["id"]);
                  while ($major = $majorByUniver->fetch_assoc()) {
                ?>
                    <option data-option="<?php echo $univer["id"] ?>" value="<?php echo $major["major_id"] ?>"><?php echo $major["major_id"] . " - " . $major["name"] ?></option>
                <?php
                  }
                }
                ?>
              </select>

            </div>

            <script>
              const selUniver = document.querySelector('#selUniver');
              const selMajor = document.querySelector('#selMajor');
              const majorOptions = selMajor.querySelectorAll('option');

              function matchSel(value) {
                selMajor.innerHTML = '<option value="">-Chọn ngành-</option>';
                majorOptions.forEach(opt => {
                  if (opt.dataset.option === value) {
                    selMajor.appendChild(opt);
                  }
                });
              }

              matchSel(selUniver.value);
            </script>

            <button class="btn btn-success" type="submit">Thêm</button>
            <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapse">
              Huỷ
            </button>
          </form>
          <hr />
        </div>

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