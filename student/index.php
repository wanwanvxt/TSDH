<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tuyển sinh đại học - Trường Đại học Công nghệ Đông Á</title>
  <link rel="stylesheet" href="/assets/bootstrap/bootstrap.min.css" />
  <script src="/assets/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="/assets/jquery/jquery-3.7.1.min.js"></script>

  <style>
    #tableMajorList thead th .btn span {
      visibility: hidden;
    }

    #tableMajorList thead th .btn input[type='radio']:checked+span {
      visibility: visible;
    }
  </style>
</head>

<body class="bg-light-subtle">
  <?php
  require_once "../core/UserCtrl.php";
  if (!UserCtrl::isStudentLoggedIn()) {
    header("location: /student/login.php");
    exit();
  }

  /** */

  require_once "../core/Major.php";
  require_once "../core/MajorCtrl.php";

  if (isset($_GET["search"])) {
    $majorList = MajorCtrl::getMajorList($_GET["search"]);
  } else {
    $majorList = MajorCtrl::getMajorList();
  }

  require_once "../core/UserCtrl.php";
  require_once "../core/StudentCtrl.php";
  require_once "../core/WishCtrl.php";

  $currentUser = UserCtrl::getCurrentUser();
  $studentProfile = StudentCtrl::getStudentByUserId($currentUser->id);
  ?>

  <nav class="fixed-top navbar navbar-expand-lg bg-primary-subtle shadow-sm">
    <div class="container-fluid" style="height: 4.5rem">
      <a class="navbar-brand" href="/">
        <img src="/assets/img/eaut_brand.webp" alt="Trường Đại học Công nghệ Đông Á" width="60" />
      </a>

      <ul class="nav nav-pills nav-fill gap-2 p-1">
        <li class="nav-item">
          <a class="nav-link active fw-medium" href="/student">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-medium" href="/student/profile.php">Hồ sơ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-medium" href="/student/wishlist.php">Nguyện vọng</a>
        </li>
        <li class="nav-item dropstart">
          <a class="nav-link dropdown-toggle fw-medium" href="#" data-bs-toggle="dropdown">Tài khoản</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item fw-medium" href="/student/user.php">Thông tin tài khoản</a></li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li><a class="dropdown-item fw-medium" href="/student/logout.php">Đăng xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <main style="margin-top: 6rem; min-height: calc(100vh - 6rem)">
    <div class="container-fluid py-3">
      <h2 class="text-primary">Danh sách ngành nghề tuyển sinh</h2>
      <h3 class="text-primary">
        <a href="#">Trường Đại học Công nghệ Đông Á</a>
      </h3>

      <form class="input-group my-3" action="/student" method="get">
        <input class="form-control" type="search" name="search" placeholder="Tìm theo mã ngành và tên ngành..." />
        <button class="btn btn-warning" type="submit">Tìm kiếm</button>
      </form>

      <div>
        <table id="tableMajorList" class="table table-striped-columns table-hover">
          <thead>
            <tr class="table-primary">
              <th class="align-middle">STT</th>
              <th class="align-middle">
                <label class="btn fw-bold">
                  <input type="radio" name="sort" data-sort="majorId" hidden />
                  Mã ngành
                  <span>&#9660;</span>
                </label>
              </th>
              <th class="align-middle">
                <label class="btn fw-bold">
                  <input type="radio" name="sort" data-sort="majorName" hidden />
                  Tên ngành
                  <span>&#9660;</span>
                </label>
              </th>
              <th class="align-middle">
                <label class="btn fw-bold">
                  <input type="radio" name="sort" data-sort="score" hidden />
                  Điểm chuẩn
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

  <hr class="table-group-divider my-5" />

  <footer>
    <h3 class="text-center">
      Bản quyền &copy; <a href="#">Trường Đại học Công nghệ Đông Á</a>
    </h3>
  </footer>

  <script>
    $(document).ready(() => {
      const majorList = [
        <?php
        foreach ($majorList as $major) {
          $studentHasWish = WishCtrl::studentHasWish($studentProfile->id, $major->id);
          echo "{ majorId: " . $major->id . ", majorName: '" . $major->name . "', score: " . $major->score . ", studentHas: " . ($studentHasWish ? 1 : 0) . " },";
        }
        ?>
      ];

      function createARow(index, item) {
        return `
          <tr>
            <td>${index + 1}</td>
            <td>${item.majorId}</td>
            <td>${item.majorName}</td>
            <td>${item.score}</td>
            <td>
              <form action="/student/wishlist.php" method="post">
                <input type="hidden" name="majorId" value="${item.majorId}"/>
                <button class="btn btn-success" type="submit" name="addWish" ${item.studentHas === 1 ? "disabled" : ""} >Thêm vào NV</button>
              </form>
            </td>
          </tr>`;
      }

      function sortList(target) {
        if (target === 'majorName') {
          majorList.sort(function (a, b) {
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
          majorList.sort((a, b) => {
            return a.target - b.target;
          });
        }
      }

      $.each(majorList, (index, item) => {
        row = createARow(index, item);
        $('#tableMajorList tbody').append(row);
      });

      $('#tableMajorList thead th input[type="radio"]').change((evt) => {
        const sortTarget = $(evt.target).attr('data-sort');
        sortList(sortTarget);

        $('#tableMajorList tbody').empty();

        $.each(majorList, (index, item) => {
          row = createARow(index, item);
          $('#tableMajorList tbody').append(row);
        });
      });
    });
  </script>
</body>

</html>