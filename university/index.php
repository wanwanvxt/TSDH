<html>

<head>
  <link rel="icon" href="../assets/img/logo.png">
  <title>Trang chủ | Trường đại học</title>
  <link rel="stylesheet" href="../assets/css/main.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <?php
  require_once("../includes/users.php");

  if (!isLoggedInAsUniversity()) {
    header("location:login.php");
    exit();
  }

  require_once("../includes/universities.php");
  $result = getUniverInfo($_COOKIE["user"]);
  $info = $result->fetch_assoc();

  require_once("../includes/majors.php");
  $majorListNotOwn = getMajorListNotOwn($info["id"]);
  $majorUniverList = getMajorListByUniver($info["id"]);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $majorId = $_POST["selMajor"];
    $block = $_POST["txtBlock"];
    $score = $_POST["txtScore"];
    if (addMajorByUniver($info["id"], $majorId, $block, $score)) {
      echo "<script>alert('Thêm ngành thành công!')</script>";
      header("refresh:0");
      exit();
    } else {
      echo "<script>alert('Thêm ngành không thành công!')</script>";
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
        <a class="nav-link active" href="./index.php">
          <i class="bi bi-house"></i>
          <span class="ms-2 _toggle">Trang chủ</span>
        </a>
        <a class="nav-link" href="./candidate-list/index.php">
          <i class="bi bi-list-stars"></i>
          <span class="ms-2 _toggle">Tuyển sinh</span>
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

    <div class="flex-fill d-flex flex-column">
      <!-- header -->
      <div class="container-fluid bg-light-subtle m-0 row justify-content-between align-items-center border-bottom" style="height: 4rem">
        <h3 class="col m-0">Trang chủ</h3>
      </div>

      <!-- content -->
      <div class="h-100 w-100 p-3 bg-light-subtle">
        <div>
          <h3 class="text-uppercase">
            <?php echo $info["name"] ?>
            <a href="<?php echo $info["link"] ?>" target="_blank"><i class="bi bi-link-45deg"></i></a>
          </h3>
          <h5>Mã trường: <?php echo $info["id"] ?></h5>
        </div>
        <!--  -->
        <hr />
        <h5 class="text-primary">DANH SÁCH NGÀNH ĐÀO TẠO</h5>
        <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse">
          Thêm ngành
        </button>
        <div id="collapse" class="collapse">
          <form action="index.php" method="POST" style="max-width: 30rem;">
            <div class="mb-3">
              <label class="form-label">Ngành đào tạo: <red>*</red></label>
              <select class="form-select" name="selMajor" required>
                <option value="">-Chọn ngành-</option>
                <?php while ($major = $majorListNotOwn->fetch_assoc()) { ?>
                  <!-- id, name -->
                  <option value="<?php echo $major["id"] ?>"><?php echo $major["id"] . " - " . $major["name"] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Khối tuyển chọn: <red>*</red></label>
              <input class="form-control" type="text" name="txtBlock" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Điểm chuẩn: <red>*</red></label>
              <input class="form-control" type="number" name="txtScore" min="0" step="0.01" required>
            </div>

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
              <th>Mã ngành</th>
              <th>Tên ngành</th>
              <th>Khối tuyển chọn</th>
              <th>Điểm chuẩn</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($major = $majorUniverList->fetch_assoc()) { ?>
              <!-- major_id, name, block, score -->
              <tr>
                <td><?php echo $major["major_id"] ?></td>
                <td><?php echo $major["name"] ?></td>
                <td><?php echo $major["block"] ?></td>
                <td><?php echo $major["score"] ?></td>
                <td>
                  <a class="btn btn-warning" href="./major/update.php?major_id=<?php echo $major["major_id"] ?>">Sửa</a>
                  <a class="btn btn-danger" href="./major/delete.php?major_id=<?php echo $major["major_id"] ?>" onclick="return confirm('Chắc chắn muốn xoá ngành này chứ?')">Xoá</a>
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