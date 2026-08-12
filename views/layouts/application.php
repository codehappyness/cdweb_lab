 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Admin</title>
   <!-- Custom fonts for this template-->
   <link href="resource/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link
     href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
     rel="stylesheet">
   <!-- Custom styles for this template-->
   <link href="resource/assets/css/sb-admin-2.min.css" rel="stylesheet">
   
   <style>
     body, .table, .card-body, p, span, div {
       color: #2a2a2a;
     }
     .text-gray-800, .text-gray-600, .text-gray-900 {
       color: #1a1a1a !important;
     }
     .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
       color: #111 !important;
       font-weight: 700 !important;
     }
     /* Fix sidebar text colors that were overridden */
     .sidebar span, .sidebar div, .sidebar i, .sidebar a {
       color: rgba(255, 255, 255, 0.8) !important;
     }
     .sidebar .nav-item .nav-link span {
       font-weight: 600;
       color: #fff !important;
     }
     .sidebar .sidebar-heading {
       color: rgba(255, 255, 255, 0.4) !important;
     }
   </style>
 </head>
 <body id="page-top">
   <!-- Page Wrapper -->
   <div id="wrapper">
     <!-- Sidebar -->
     <?php include_once('sidebar.php'); ?>
     <!-- End of Sidebar -->
     <!-- Content Wrapper -->
     <div id="content-wrapper" class="d-flex flex-column">
       <!-- Main Content -->
       <div id="content">
         <!-- Topbar -->
         <?php include_once('header.php'); ?>
         <!-- End of Topbar -->
         <!-- Begin Page Content -->
         <div class="container-fluid">
           <!-- Page Heading -->
           <?= @$content ?>
         </div>
         <!-- /.container-fluid -->
       </div>
       <!-- End of Main Content -->
       <!-- Footer -->
       <?php include_once('footer.php'); ?>
       <!-- End of Footer -->
     </div>
     <!-- End of Content Wrapper -->
   </div>
   <!-- End of Page Wrapper -->
   <!-- Scroll to Top Button-->
   <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
   </a>
   <!-- Logout Modal-->
   <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="exampleModalLabel">Xác nhận đăng xuất</h5>
           <button class="close" type="button" data-dismiss="modal" aria-label="Đóng">
             <span aria-hidden="true">×</span>
           </button>
         </div>
         <div class="modal-body">Bạn có chắc chắn muốn đăng xuất khỏi phiên làm việc hiện tại không?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
            <a class="btn btn-primary" href="index.php?controller=auth&action=logout">Đăng xuất</a>
          </div>
       </div>
     </div>
   </div>

   <!-- Bootstrap core JavaScript-->
   <script src="resource/assets/vendor/jquery/jquery.min.js"></script>
   <script src="resource/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

   <!-- Core plugin JavaScript-->
   <script src="resource/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

   <!-- Custom scripts for all pages-->
   <script src="resource/assets/js/sb-admin-2.min.js"></script>

 </body>

 </html>
