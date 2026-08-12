<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Đăng nhập - Quản lý Tài chính</title>

  <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
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
    .login-image {
      background: url('https://source.unsplash.com/K4mSJ7kc0As/600x800') center;
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
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Chào mừng trở lại!</h1>
                  </div>
                  <?php if (!empty($success)): ?>
                    <div class="alert alert-success text-center">
                      <?= htmlspecialchars($success) ?>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($error)): ?>
                    <div class="alert alert-danger text-center">
                      <?= htmlspecialchars($error) ?>
                    </div>
                  <?php endif; ?>
                  <form class="user" method="POST" action="index.php?controller=auth&action=loginPost">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="ten_dang_nhap" aria-describedby="emailHelp" placeholder="Tên đăng nhập..." required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="mat_khau" placeholder="Mật khẩu" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold">
                      Đăng nhập
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="index.php?controller=auth&action=register">Chưa có tài khoản? Đăng ký!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>
