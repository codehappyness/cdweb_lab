# Xây dựng Ứng dụng Web Quản lý Chi tiêu và Tiện ích cá nhân

**Môn học:** Chuyên đề Web
**Giảng viên Hướng dẫn:** ThS. Phạm Thị Hồng Thu
**Thực hiện bởi (Nhóm 2):**
- Trương Nam Trung – MSSV: 06130200005
- Bùi Hải Dương - MSSV: 06130200006
- Phan Thanh Lợi - MSSV: 06130200007
- Nguyễn Huỳnh Thanh Sơn - MSSV: 06130200008
- Lê Minh Trí - MSSV: 06130200010
**Lớp:** ĐHCNTT – K6

---

## 1. Giới thiệu tổng quan
Trong cuộc sống hiện đại, việc theo dõi và thanh toán đúng hạn các hóa đơn sinh hoạt định kỳ (điện, nước, internet, phí dịch vụ...) là một nhu cầu thiết yếu. Việc ghi chép thủ công dễ dẫn đến sai sót, thất lạc biên lai hoặc quên hạn thanh toán gây phát sinh phí phạt.

Hệ thống quản lý chi tiêu cá nhân được xây dựng bằng ngôn ngữ **PHP (Mô hình MVC thuần)** và cơ sở dữ liệu **MySQL**, giao diện **Bootstrap 4 (SB Admin 2)**. Ứng dụng cung cấp các công cụ trực quan giúp người dùng dễ dàng quản lý danh mục dịch vụ, theo dõi hóa đơn từng kỳ cước, lưu trữ chứng từ thanh toán điện tử (hình ảnh/biên lai) và thống kê dòng tiền thông qua biểu đồ tự động. Hệ thống hỗ trợ đa người dùng (Multi-tenant), mỗi người dùng có không gian dữ liệu độc lập.

## 2. Tính năng nổi bật
* **Quản lý Danh mục (Nhà cung cấp & Dịch vụ):** Tổ chức dữ liệu theo quan hệ 1-N (1 Nhà cung cấp có thể có nhiều dịch vụ như Internet, Truyền hình).
* **Quản lý Hóa đơn & Lưu trữ chứng từ:** Quản lý kỳ cước, cho phép upload biên lai/hình ảnh giao dịch chuyển khoản khi cập nhật trạng thái thanh toán.
* **Cảnh báo Thông minh:** Tự động đối chiếu `Ngày hạn chót` với thời gian thực để đưa ra các cảnh báo bằng khung đỏ trên trang chủ khi hóa đơn sắp đến hạn (hoặc quá hạn).
* **Bảng điều khiển & Thống kê Trực quan:** Tính toán tự động tổng tiền và số hóa đơn chưa thanh toán. Hỗ trợ chọn tháng để tự động vẽ **Biểu đồ cột (Bar Chart)** hoặc **Biểu đồ tròn (Pie Chart)**.
* **Bảo mật & Phân quyền:** Quản lý người dùng, cho phép sửa đổi hồ sơ cá nhân và giới hạn tính năng quản trị hệ thống. Đã áp dụng xử lý **PDO Prepared Statements** để phòng chống SQL Injection.

---

## 3. Cấu trúc thư mục (MVC Architecture)

Mã nguồn được tổ chức theo chuẩn mô hình **Model - View - Controller (MVC)** giúp tách biệt logic xử lý và giao diện:

```text
/
├── resource/assets/                 # (Public) Chứa các tài nguyên tĩnh tĩnh của giao diện.
│   ├── css/                # File CSS tùy chỉnh và SB Admin 2.
│   ├── js/                 # File JavaScript xử lý logic Frontend và Biểu đồ.
│   ├── uploads/            # Nơi lưu trữ chứng từ (hình ảnh biên lai) người dùng tải lên.
│   └── vendor/             # Thư viện bên thứ ba (FontAwesome, Bootstrap, jQuery).
│
├── controllers/            # (Controllers) Nơi tiếp nhận Request và điều phối nghiệp vụ.
│   ├── auth_controller.php       # Xử lý Đăng nhập, Đăng ký, Đăng xuất.
│   ├── profile_controller.php    # Xử lý cập nhật thông tin cá nhân.
│   ├── base_controller.php       # Lớp cơ sở (Base Class) xử lý việc render Views.
│   ├── hoadon_controller.php     # Xử lý toàn bộ logic Thêm/Sửa/Xóa và Thanh toán hóa đơn.
│   ├── nhacungcap_controller.php # Xử lý danh mục nhà cung cấp dịch vụ.
│   ├── dichvu_controller.php     # Xử lý danh mục dịch vụ.
│   └── thongke_controller.php    # Cung cấp dữ liệu cho Bảng điều khiển và biểu đồ.
│
├── models/                 # (Models) Nơi tương tác trực tiếp với cơ sở dữ liệu.
│   ├── chungtu.php         # Tương tác bảng 'chung_tu_dien_tu' (Quản lý File upload).
│   ├── dichvu.php          # Tương tác bảng 'dich_vu'.
│   ├── hoadon.php          # Tương tác bảng 'hoa_don'.
│   ├── nguoidung.php       # Tương tác bảng 'nguoi_dung'.
│   └── nhacungcap.php      # Tương tác bảng 'nha_cung_cap'.
│
├── views/                  # (Views) Nơi chứa giao diện người dùng hiển thị (HTML + PHP).
│   ├── auth/               # Giao diện cho đăng nhập, đăng ký và cập nhật hồ sơ cá nhân.
│   ├── dichvu/             # Giao diện danh sách, form nhập liệu dịch vụ.
│   ├── hoadon/             # Giao diện quản lý và thanh toán hóa đơn.
│   ├── home/               # Giao diện trang chủ (Dashboard).
│   ├── layouts/            # Cấu trúc khung giao diện gốc (Master layout).
│   │   ├── application.php # Giao diện chính chứa phần khung (CSS/JS imports).
│   │   ├── header.php      # Thanh điều hướng phía trên (Topbar).
│   │   └── sidebar.php     # Thanh điều hướng Menu bên trái (Sidebar).
│   └── thongke/            # Giao diện hiển thị thống kê.
│
├── docs/                   # Tài liệu đồ án
│   └── doc.md              # Báo cáo chi tiết của đề tài
│
├── connection.php          # Lớp Singleton khởi tạo kết nối CSDL (PDO).
├── router.php              # Bộ định tuyến (Routing) điều hướng URL đến đúng Controller.
└── index.php               # Front Controller (Điểm bắt đầu duy nhất của mọi request).
```

## 4. Hướng dẫn cài đặt

1. Import tệp cơ sở dữ liệu vào MySQL/MariaDB (Ví dụ: `database.sql` hoặc sử dụng cơ sở dữ liệu `qltaichinh` có sẵn).
2. Kiểm tra lại thông tin kết nối CSDL trong file `connection.php` (Tên DB, Username, Password).
3. Đảm bảo thư mục `resource/assets/uploads/` có quyền ghi (Write Permission) để hỗ trợ tính năng Upload biên lai.
4. Chạy hệ thống trên Localhost (XAMPP/Laragon) hoặc máy chủ Apache/Nginx.
