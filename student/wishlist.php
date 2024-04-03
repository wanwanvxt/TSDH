<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nguyện vọng | Tuyển sinh đại học - Trường Đại học Công nghệ Đông Á</title>
  <link rel="icon" type="image/x-icon" href="/assets/img/eaut_brand.webp">
  <link rel="stylesheet" href="/assets/bootstrap/bootstrap.min.css" />
  <script src="/assets/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="/assets/jquery/jquery-3.7.1.min.js"></script>

  <style>
    #tableWishList thead th .btn span {
      visibility: hidden;
    }

    #tableWishList thead th .btn input[type='radio']:checked+span {
      visibility: visible;
    }
  </style>
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
  if ($studentProfile == null) {
    echo "<script>alert('Vui lòng cung cấp đầy đủ thông tin hồ sơ');window.location.href='/student/profile.php'</script>";
    exit();
  }

  /** */

  require_once "../core/Wish.php";
  require_once "../core/WishCtrl.php";
  require_once "../core/MajorCtrl.php";

  $wishList = WishCtrl::getWishListByStudent($studentProfile->id);
  $majorList = MajorCtrl::getMajorList();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addWish"])) {
      $majorId = $_POST["majorId"];
      $studentId = $studentProfile->id;

      if (WishCtrl::addWish($majorId, $studentId)) {
        echo "<script>alert('Thêm NV thành công');window.location.href='/student'</script>";
      } else {
        echo "<script>alert('Thêm NV không thành công')</script>";
      }
    } elseif (isset($_POST["deleteWish"])) {
      $wishId = $_POST["wishId"];

      if (WishCtrl::deleteWish($wishId)) {
        echo "<script>alert('Xoá NV thành công');window.location.href='/student/wishlist.php'</script>";
      } else {
        echo "<script>alert('Xoá NV không thành công')</script>";
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
          <a class="nav-link active fw-medium" href="/student/wishlist.php">Nguyện vọng</a>
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
      <h2 class="text-primary">Danh sách nguyện vọng</h2>
      <h3 class="text-primary">
        <a href="#">Trường Đại học Công nghệ Đông Á</a>
      </h3>

      <form class="input-group my-3" action="/student/wishList.php" method="post">
        <select class="form-select" name="majorId" required>
          <option value="" selected>-Chọn ngành-</option>
          <?php
          foreach ($majorList as $major) {
            if (!WishCtrl::studentHasWish($studentProfile->id, $major->id)) {
              ?>
              <option value="<?php echo $major->id ?>">
                <?php echo $major->id . " - " . $major->name ?>
              </option>
              <?php
            }
          }
          ?>
        </select>
        <button class="btn btn-primary" type="submit" name="addWish">Thêm NV</button>
      </form>

      <div>
        <table id="tableWishList" class="table table-striped-columns table-hover">
          <thead>
            <tr class="table-primary">
              <th class="align-middle">STT</th>
              <th class="align-middle">
                <label class="btn fw-bold">
                  <input type="radio" name="sort" data-sort="wishId" hidden />
                  Mã ngành
                  <span>&#9660;</span>
                </label>
              </th>
              <th class="align-middle">
                <label class="btn fw-bold">
                  <input type="radio" name="sort" data-sort="wishName" hidden />
                  Tên ngành
                  <span>&#9660;</span>
                </label>
              </th>
              <th class="align-middle">
                <label class="btn fw-bold">
                  <input type="radio" name="sort" data-sort="pass" hidden />
                  Kết quả
                  <span>&#9660;</span>
                </label>
              </th>
              <th class="align-middle">Hành động</th>
            </tr>
          </thead>
          <tbody>
            <!-- list here -->
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script>
    $(document).ready(() => {
      const wishList = [
        <?php
        foreach ($wishList as $wish) {
          $major = MajorCtrl::getMajorById($wish->majorId);

          ?> { wishId: <?php echo $wish->id ?>, majorId: <?php echo $major->id ?>, majorName: '<?php echo $major->name ?>', pass: <?php echo empty($wish->pass) ? "null" : $wish->pass ?> },
          <?php
        }
        ?>
      ];

      function createARow(index, item) {
        return `
          <tr>
            <td>${index + 1}</td>
            <td>${item.majorId}</td>
            <td>${item.majorName}</td>
            <td>${item.pass === null ? "Chờ xét duyệt" : (item.pass ? "Đỗ" : "Trượt")}</td>
            <td>
              <form action="/student/wishlist.php" method="post">
                <input type="hidden" name="wishId" value="${item.wishId}"/>
                <button class="btn btn-danger" type="submit" name="deleteWish" ${item.pass === null ? "" : "disabled"}>Xoá</button>
              </form>
            </td>
          </tr>`;
      }

      function sortList(target) {
        if (target === 'majorName' || target === 'pass') {
          wishList.sort(function (a, b) {
            var majorA = a.majorName.toUpperCase();
            var majorB = b.majorName.toUpperCase();
            if (majorA < majorB) {
              return -1;
            }
            if (majorA > majorB) {
              return 1;
            }
            return 0;
          });
        } else {
          wishList.sort((a, b) => {
            return a.target - b.target;
          });
        }
      }

      $.each(wishList, (index, item) => {
        row = createARow(index, item);
        $('#tableWishList tbody').append(row);
      });

      $('#tableWishList thead th input[type="radio"]').change((evt) => {
        const sortTarget = $(evt.target).attr('data-sort');
        sortList(sortTarget);

        $('#tableWishList tbody').empty();

        $.each(wishList, (index, item) => {
          row = createARow(index, item);
          $('#tableWishList tbody').append(row);
        });
      });
    });
  </script>
</body>

</html>