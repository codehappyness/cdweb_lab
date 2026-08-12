<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Đăng ký tài khoản</title>

  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .register-image {
      background: url('https://source.unsplash.com/Mv9hjnEUHR4/600x800') center;
      background-size: cover;
    }
    .form-control-user {
      border-radius: 10rem;
      padding: 1.5rem 1rem;
    }
    .btn-user {
      border-radius: 10rem;
      padding: 0.75rem 1rem;
      font-size: 1.1rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block register-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Tạo Tài Khoản Mới!</h1>
                  </div>
                  <?php if (!empty($error)): ?>
                    <div class="alert alert-danger text-center">
                      <?= htmlspecialchars($error) ?>
                    </div>
                  <?php endif; ?>
                  <form class="user" method="POST" action="index.php?controller=auth&action=registerPost">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="ho_ten" placeholder="Họ và tên" required>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="ten_dang_nhap" placeholder="Tên đăng nhập" required>
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" name="email" placeholder="Địa chỉ Email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="mat_khau" placeholder="Mật khẩu" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-user btn-block font-weight-bold">
                      Đăng Ký
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="index.php?controller=auth&action=login">Đã có tài khoản? Đăng nhập!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>
