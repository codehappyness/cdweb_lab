# ĐẶC TẢ CÁC MÔ HÌNH UML KHÁC (THỰC THỂ & HOẠT ĐỘNG)

Tài liệu này cung cấp mô tả chi tiết cho Biểu đồ Thực thể - Mối kết hợp (ER / Class Diagram) và Biểu đồ Hoạt động (Activity Diagram).

---

## I. ĐẶC TẢ THỰC THỂ (ENTITY SPECIFICATIONS) VÀ MỐI QUAN HỆ

Dựa vào Sơ đồ Lớp (Class / ER Diagram), cơ sở dữ liệu được thiết kế thành 5 thực thể chính.

### 1. Thực thể `NGUOI_DUNG` (Người dùng)
* **Ý nghĩa:** Lưu trữ thông tin tài khoản dùng để đăng nhập và phân quyền trên hệ thống. Tất cả các dữ liệu khác đều quy chiếu về bảng này (Multi-tenant).
* **Các thuộc tính quan trọng:**
  * `id` (PK): Khóa chính định danh người dùng.
  * `ten_dang_nhap`, `mat_khau`: Xác thực tài khoản.
  * `vai_tro`: Kiểu TinyInt (0 là Người dùng thường, 1 là Quản trị viên).
  * `lan_dang_nhap_cuoi`: Ghi nhận thời gian cuối cùng truy cập hệ thống.

### 2. Thực thể `NHA_CUNG_CAP` (Nhà cung cấp)
* **Ý nghĩa:** Quản lý các đơn vị cung cấp dịch vụ tiện ích (Ví dụ: EVN, Viettel, VNPT, CTN Cần Thơ).
* **Các thuộc tính quan trọng:**
  * `id` (PK): Khóa chính định danh nhà cung cấp.
  * `ten`, `dia_chi`, `so_dien_thoai`: Thông tin liên lạc cơ bản.
  * `nguoi_dung_id` (FK): Khóa ngoại xác định nhà cung cấp này thuộc về User nào.

### 3. Thực thể `DICH_VU` (Dịch vụ)
* **Ý nghĩa:** Quản lý danh mục các loại dịch vụ cụ thể (Ví dụ: Tiền điện sinh hoạt, Cáp quang Internet).
* **Các thuộc tính quan trọng:**
  * `id` (PK): Định danh dịch vụ.
  * `nha_cung_cap_id` (FK): Khóa ngoại chỉ định dịch vụ thuộc về Nhà cung cấp nào.
  * `nguoi_dung_id` (FK): Thuộc về tài khoản người dùng nào.

### 4. Thực thể `HOA_DON` (Hóa đơn)
* **Ý nghĩa:** Là trung tâm của hệ thống, ghi nhận các khoản phải trả định kỳ.
* **Các thuộc tính quan trọng:**
  * `id` (PK): Định danh hóa đơn.
  * `ky_cuoc`: Tháng phát sinh chi phí (Định dạng MM/YYYY).
  * `so_tien_can_dong`: Giá trị tiền.
  * `ngay_han_chot`: Ngày cuối cùng để thanh toán trước khi bị phạt.
  * `trang_thai`: Cờ trạng thái (0: Chưa thanh toán, 1: Đã thanh toán).
  * Khóa ngoại: `dich_vu_id`, `nha_cung_cap_id`, `nguoi_dung_id`.

### 5. Thực thể `CHUNG_TU_DIEN_TU` (Chứng từ)
* **Ý nghĩa:** Lưu trữ bằng chứng thanh toán bằng hình ảnh hoặc file tải lên.
* **Các thuộc tính quan trọng:**
  * `duong_dan_file`: Đường dẫn lưu hình ảnh trên server (`assets/uploads/...`).
  * `hoa_don_id` (FK): Khóa ngoại liên kết duy nhất (Unique) 1-1 tới hóa đơn đã thanh toán.

### 6. Mô tả các Mối kết hợp (Relationships)
* **1 - N (Người dùng - Dữ liệu):** 1 Người dùng có thể tạo ra và quản lý nhiều (N) Nhà cung cấp, Dịch vụ và Hóa đơn. Ngược lại, mỗi Nhà cung cấp, Dịch vụ, Hóa đơn chỉ thuộc quyền sở hữu của 1 Người dùng duy nhất.
* **1 - N (Nhà cung cấp - Dịch vụ):** 1 Nhà cung cấp (Ví dụ VNPT) có thể cung cấp nhiều (N) dịch vụ khác nhau (Cáp quang, Truyền hình, Sim data). 
* **1 - N (Dịch vụ - Hóa đơn):** 1 Dịch vụ (Tiền điện) sẽ phát sinh ra nhiều (N) hóa đơn ứng với từng kỳ cước (từng tháng).
* **1 - 1 (Hóa đơn - Chứng từ):** Mỗi 1 Hóa đơn sau khi thanh toán chỉ cho phép đính kèm 1 Chứng từ duy nhất làm minh chứng.

---

## II. ĐẶC TẢ SƠ ĐỒ HOẠT ĐỘNG (ACTIVITY SPECIFICATIONS)

### 1. Luồng hoạt động: Thanh toán Hóa đơn & Upload Chứng từ
* **Bối cảnh:** Khi người dùng có tiền và tiến hành thanh toán cho một hóa đơn tiện ích.
* **Diễn giải quy trình:**
  1. Từ giao diện Dashboard hoặc trang Quản lý Hóa đơn, người dùng nhìn thấy các hóa đơn đang ở trạng thái `Chưa thanh toán` (hoặc bị cảnh báo đỏ do quá hạn).
  2. Người dùng nhấn vào nút **Thanh toán**. Hệ thống chuyển sang giao diện Form Chi tiết Thanh toán.
  3. Người dùng rà soát lại số tiền, nhập Ghi chú.
  4. Người dùng sử dụng nút "Chọn tệp" để tải hình ảnh chụp màn hình ứng dụng ngân hàng (hoặc biên lai giấy).
  5. Hệ thống kích hoạt module xử lý File:
     * Kiểm tra đuôi mở rộng (Extension) có phải là hình ảnh (jpg, jpeg, png).
     * Kiểm tra dung lượng (Size) không vượt quá 2MB.
     * Nếu lỗi: Trả về trạng thái từ chối, yêu cầu người dùng đổi file.
  6. Nếu File hợp lệ, hệ thống sử dụng cơ chế Upload của PHP để chuyển tệp vật lý vào thư mục `/assets/uploads/`.
  7. Hệ thống tự động mở Transaction (SQL), cập nhật cột `trang_thai = 1` ở bảng Hóa Đơn, đồng thời `INSERT` đường dẫn file vào bảng `chung_tu_dien_tu`.
  8. Kết thúc luồng hoạt động, hệ thống hiển thị thông báo "Thanh toán thành công" và loại bỏ hóa đơn khỏi danh sách nợ.

### 2. Luồng hoạt động: Xem Dashboard, Thống kê và Cảnh báo
* **Bối cảnh:** Người dùng vừa đăng nhập vào trang chủ (Trang Dashboard).
* **Diễn giải quy trình:**
  1. Controller ngay lập tức đọc thông tin Session của User.
  2. Hệ thống gọi truy vấn 1: Chạy vòng lặp tính tổng `so_tien_can_dong` của toàn bộ hóa đơn đang nợ.
  3. Hệ thống gọi truy vấn 2: Truy quét các hóa đơn nợ có `ngay_han_chot` nhỏ hơn hoặc bằng 7 ngày tính từ lúc hiện tại.
  4. Nếu kết quả truy vấn 2 > 0, hiển thị khối hộp màu đỏ `Alert Danger` cảnh báo gấp.
  5. Hệ thống kiểm tra tham số lọc tháng trên thanh công cụ:
     * **Trường hợp A (Không chọn tháng / Xem tổng quát):** Hệ thống dùng hàm `SUM()` kết hợp `GROUP BY ky_cuoc` để xuất ra mảng JSON doanh số từng tháng. Lệnh vẽ Biểu đồ Cột (Bar Chart) được kích hoạt để vẽ 12 tháng.
     * **Trường hợp B (Có chọn 1 tháng cụ thể):** Hệ thống lọc riêng hóa đơn của kỳ cước đó, dùng hàm `SUM()` kết hợp `GROUP BY dich_vu_id`. Lệnh vẽ Biểu đồ Tròn (Pie Chart) được kích hoạt để vẽ tỷ trọng dịch vụ (Điện 40%, Nước 20%, Internet 40%).
  6. Giao diện xuất ra màn hình trọn vẹn. Luồng hoạt động hoàn tất.
