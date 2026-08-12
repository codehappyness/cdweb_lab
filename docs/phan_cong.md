# BẢNG PHÂN CÔNG CÔNG VIỆC ĐỒ ÁN MÔN HỌC

**MÔN HỌC:** CHUYÊN ĐỀ WEB
**NHÓM THỰC HIỆN:** NHÓM 2
**ĐỀ TÀI:** XÂY DỰNG ỨNG DỤNG WEB QUẢN LÝ CHI TIÊU VÀ TIỆN ÍCH CÁ NHÂN

---

## I. DANH SÁCH THÀNH VIÊN VÀ CÁC CHỨC NĂNG

### 1. Thành viên nhóm 2
* Trương Nam Trung – MSSV: 06130200005
* Bùi Hải Dương - MSSV: 06130200006
* Phan Thanh Lợi - MSSV: 06130200007
* Nguyễn Huỳnh Thanh Sơn - MSSV: 06130200008
* Lê Minh Trí - MSSV: 06130200010

### 2. Các chức năng phía Người dùng
* **Quản lý danh mục dịch vụ:** Xem, thêm, sửa, xóa danh sách các đơn vị cung cấp dịch vụ tiện ích.
* **Quản lý hóa đơn và chỉ số:** Nhập liệu số tiền, cập nhật trạng thái hóa đơn định kỳ, theo dõi chỉ số điện/nước.
* **Cập nhật thanh toán:** Cập nhật trạng thái và upload chứng từ (biên lai giấy, ảnh chụp màn hình giao dịch chuyển khoản).
* **Xem thống kê và cảnh báo:** Xem các cảnh báo hóa đơn sắp đến hạn chót và biểu đồ trực quan chi phí tổng hợp.

---

## II. CHI TIẾT PHÂN CÔNG CÔNG VIỆC
*(Tất cả các thành viên đều tham gia lập trình hệ thống theo từng module riêng biệt)*

### 1. Phân tích yêu cầu & Code Module Danh mục
* **Thành viên thực hiện:** Bùi Hải Dương
* **Phụ trách:** Viết Chương 1, Chương 2 và Lập trình quản lý Danh mục
* **Công việc cụ thể:**
  * **Tài liệu:** Khảo sát hiện trạng, thu thập yêu cầu hệ thống. Xây dựng yêu cầu chức năng, phi chức năng.
  * **Code:** Code các module Quản lý Nhà cung cấp và Quản lý Dịch vụ (Thêm, Sửa, Xóa). Thiết kế giao diện danh sách cho 2 module này.

### 2. Thiết kế UML & Code Module Hóa đơn
* **Thành viên thực hiện:** Phan Thanh Lợi
* **Phụ trách:** Vẽ Biểu đồ hệ thống (Chương 3) và Lập trình quản lý Hóa đơn
* **Công việc cụ thể:**
  * **Tài liệu:** Vẽ biểu đồ Use Case, Class Diagram, Activity Diagram. Lập danh sách thực thể và mô tả mối kết hợp.
  * **Code:** Code module Quản lý Hóa đơn (Thêm, Sửa, Xóa). Lập trình logic kiểm tra ngày hạn chót và xử lý trạng thái.

### 3. Thiết kế CSDL & Code Module Quản lý Người dùng
* **Thành viên thực hiện:** Trương Nam Trung
* **Phụ trách:** Thiết kế Database (Chương 3) và Lập trình Auth & User Management
* **Công việc cụ thể:**
  * **Tài liệu:** Thiết kế Database, mô hình vật lý, khóa chính (PK), khóa ngoại (FK) và quan hệ giữa các bảng.
  * **Code:** Code chức năng Đăng ký, Đăng nhập, Đăng xuất, và cập nhật Thông tin Hồ sơ cá nhân (Profile). Đặc biệt xây dựng Module Quản lý Người dùng (dành cho Admin): Thêm, Sửa, Xóa, Cấp quyền tài khoản.

### 4. Cấu trúc MVC & Code Module Thanh toán
* **Thành viên thực hiện:** Nguyễn Huỳnh Thanh Sơn
* **Phụ trách:** Cấu trúc Core MVC và Lập trình Thanh toán
* **Công việc cụ thể:**
  * **Tài liệu:** Đóng gói mã nguồn.
  * **Code:** Xây dựng cấu trúc MVC lõi (Router, Base Controller). Code chức năng cập nhật trạng thái thanh toán và Upload hình ảnh chứng từ.

### 5. Viết Báo cáo & Code Module Thống kê
* **Thành viên thực hiện:** Lê Minh Trí
* **Phụ trách:** Báo cáo tổng kết và Lập trình Dashboard
* **Công việc cụ thể:**
  * **Tài liệu:** Viết Hướng dẫn sử dụng, đánh giá Ưu/Nhược điểm. Chụp ảnh màn hình ứng dụng và format file Word báo cáo cuối cùng.
  * **Code:** Code giao diện trang chủ (Dashboard). Xử lý truy vấn tính toán tổng tiền, và lập trình vẽ Biểu đồ bằng Chart.js (Biểu đồ Cột, Tròn). Đổ dữ liệu cảnh báo ra trang chủ.
