# ĐẶC TẢ CÁC USE CASE (USE CASE SPECIFICATIONS)

Tài liệu này cung cấp mô tả chi tiết (đặc tả) cho các Use Case cốt lõi trong Hệ thống Quản lý Chi tiêu và Tiện ích cá nhân.

---

## 1. Đặc tả Use Case: Đăng nhập (UC_DangNhap)

* **Tác nhân (Actor):** Người dùng, Quản trị viên (Admin).
* **Mô tả:** Cho phép người dùng truy cập vào hệ thống với phân quyền tương ứng để quản lý dữ liệu cá nhân hoặc quản trị hệ thống.
* **Tiền điều kiện:** Người dùng phải có tài khoản đã được đăng ký và kích hoạt trong hệ thống.
* **Luồng sự kiện chính (Basic Flow):**
  1. Người dùng truy cập trang Đăng nhập.
  2. Người dùng nhập `Tên đăng nhập` và `Mật khẩu`.
  3. Người dùng nhấn nút "Đăng nhập".
  4. Hệ thống kiểm tra thông tin đối chiếu với cơ sở dữ liệu `nguoi_dung`.
  5. Nếu thông tin chính xác, hệ thống thiết lập Session, cập nhật thời gian `lan_dang_nhap_cuoi` và chuyển hướng người dùng đến trang chủ (Dashboard).
* **Luồng sự kiện rẽ nhánh (Alternate Flow):**
  * *Sai thông tin:* Ở bước 4, nếu Tên đăng nhập hoặc Mật khẩu sai, hệ thống từ chối đăng nhập, giữ nguyên trang và hiển thị thông báo lỗi "Tên đăng nhập hoặc mật khẩu không chính xác".
* **Hậu điều kiện:** Người dùng truy cập thành công vào hệ thống.

---

## 2. Đặc tả Use Case: Quản lý danh mục (Nhà cung cấp / Dịch vụ)

* **Tác nhân (Actor):** Người dùng.
* **Mô tả:** Cho phép người dùng Thêm, Xem, Sửa, Xóa thông tin các nhà cung cấp và các loại dịch vụ tiện ích mà họ đang sử dụng.
* **Tiền điều kiện:** Người dùng đã Đăng nhập thành công.
* **Luồng sự kiện chính (Basic Flow):**
  1. Người dùng chọn menu "Nhà cung cấp" hoặc "Dịch vụ" trên thanh Sidebar.
  2. Hệ thống hiển thị danh sách các mục thuộc sở hữu của người dùng đó (lọc theo `nguoi_dung_id`).
  3. Người dùng chọn thao tác (Thêm mới, Sửa, hoặc Xóa).
  4. Hệ thống hiển thị Form nhập liệu tương ứng (nếu Thêm/Sửa) hoặc Hộp thoại xác nhận (nếu Xóa).
  5. Người dùng điền thông tin và nhấn Lưu.
  6. Hệ thống kiểm tra tính hợp lệ của dữ liệu, tiến hành cập nhật vào Database và thông báo thành công.
* **Luồng sự kiện rẽ nhánh (Alternate Flow):**
  * *Ràng buộc khóa ngoại khi Xóa:* Ở bước 6, nếu người dùng Xóa một Nhà cung cấp đã có Hóa đơn hoặc Dịch vụ liên kết, hệ thống sẽ chặn thao tác và báo lỗi "Không thể xóa vì đã có dữ liệu liên kết".
* **Hậu điều kiện:** Danh sách Nhà cung cấp / Dịch vụ được cập nhật chính xác trong cơ sở dữ liệu.

---

## 3. Đặc tả Use Case: Quản lý và Cập nhật Hóa đơn

* **Tác nhân (Actor):** Người dùng.
* **Mô tả:** Cho phép người dùng ghi nhận thông tin hóa đơn tiện ích của từng kỳ cước, cập nhật số tiền và trạng thái thanh toán.
* **Tiền điều kiện:** Đã Đăng nhập; Đã khai báo ít nhất 1 Dịch vụ / Nhà cung cấp.
* **Luồng sự kiện chính (Basic Flow):**
  1. Người dùng vào chức năng "Danh sách Hóa đơn".
  2. Người dùng nhấn nút "Thêm mới".
  3. Hệ thống hiển thị Form nhập liệu (Chọn Dịch vụ, Kỳ cước, Số tiền, Hạn chót).
  4. Người dùng điền thông tin và Lưu.
  5. Hệ thống lưu Hóa đơn với trạng thái mặc định là "Chưa thanh toán" (0).
* **Hậu điều kiện:** Hóa đơn mới xuất hiện trên hệ thống và có khả năng kích hoạt Cảnh báo nếu gần đến hạn.

---

## 4. Đặc tả Use Case: Thanh toán và Upload chứng từ

* **Tác nhân (Actor):** Người dùng.
* **Mô tả:** Người dùng cập nhật trạng thái hóa đơn thành "Đã thanh toán" và đính kèm biên lai điện tử.
* **Tiền điều kiện:** Tồn tại ít nhất 1 Hóa đơn "Chưa thanh toán".
* **Luồng sự kiện chính (Basic Flow):**
  1. Tại Danh sách Hóa đơn, người dùng bấm nút "Thanh toán" ở hóa đơn cần xử lý.
  2. Hệ thống hiển thị màn hình Chi tiết Thanh toán.
  3. Người dùng chọn hình thức thanh toán (Nền tảng giao dịch) và tải lên 1 tệp hình ảnh (.jpg, .png) làm biên lai chứng từ.
  4. Người dùng bấm "Xác nhận thanh toán".
  5. Hệ thống kiểm tra định dạng và dung lượng tệp. Nếu hợp lệ, hệ thống lưu tệp vào thư mục `resource/assets/uploads/`.
  6. Hệ thống chuyển trạng thái Hóa đơn sang "Đã thanh toán" và ghi đường dẫn file vào bảng `chung_tu_dien_tu`.
* **Luồng sự kiện rẽ nhánh (Alternate Flow):**
  * *Tệp không hợp lệ:* Nếu tệp tải lên vượt quá dung lượng hoặc sai định dạng, hệ thống từ chối và báo lỗi ngay trên giao diện.
* **Hậu điều kiện:** Hóa đơn được thanh toán xong, số liệu sẽ được tổng hợp vào Thống kê và biến mất khỏi bảng Cảnh báo.

---

## 5. Đặc tả Use Case: Xem Thống kê & Báo cáo (Dashboard)

* **Tác nhân (Actor):** Người dùng.
* **Mô tả:** Hệ thống tự động tổng hợp dữ liệu, đưa ra cảnh báo quá hạn và vẽ biểu đồ chi tiêu.
* **Tiền điều kiện:** Đã Đăng nhập.
* **Luồng sự kiện chính (Basic Flow):**
  1. Người dùng nhấp vào logo hoặc chọn menu "Dashboard" / "Thống kê".
  2. Hệ thống truy vấn CSDL để lấy Tổng số Hóa đơn nợ và Tổng tiền nợ. Hiển thị lên các Thẻ (Cards).
  3. Hệ thống kiểm tra các Hóa đơn có `ngay_han_chot` trong vòng 7 ngày tới hoặc đã quá hạn, sau đó hiển thị Alert cảnh báo màu đỏ.
  4. Hệ thống mặc định load dữ liệu gom nhóm theo tháng và render Biểu đồ Cột (Bar Chart).
  5. (Tùy chọn) Người dùng sử dụng công cụ "Chọn tháng" và nhấn Lọc.
  6. Hệ thống truy xuất dữ liệu riêng của tháng đó và chuyển đổi sang Biểu đồ Tròn (Pie Chart) thể hiện cơ cấu chi phí dịch vụ.
* **Hậu điều kiện:** Không làm thay đổi dữ liệu hệ thống (Chỉ đọc - Read only).

---

## 6. Đặc tả Use Case: Quản trị Hệ thống (Admin Only)

* **Tác nhân (Actor):** Quản trị viên (Admin).
* **Mô tả:** Admin quản lý toàn bộ danh sách tài khoản, có quyền cấp lại mật khẩu hoặc vô hiệu hóa người dùng.
* **Tiền điều kiện:** Đăng nhập bằng tài khoản có `vai_tro = 1`.
* **Luồng sự kiện chính (Basic Flow):**
  1. Admin chọn menu "Quản lý Người dùng".
  2. Hệ thống hiển thị danh sách tất cả các User, bao gồm số lần đăng nhập cuối.
  3. Admin có thể thực hiện thao tác Thêm người dùng mới, Sửa thông tin, hoặc Cấp quyền Admin cho người khác.
  4. Hệ thống cập nhật dữ liệu tài khoản vào Database.
* **Luồng sự kiện rẽ nhánh (Alternate Flow):**
  * *Truy cập trái phép:* Nếu một người dùng thông thường (`vai_tro = 0`) cố tình nhập URL truy cập vào trang này, hệ thống sẽ phát hiện và bắt buộc chuyển hướng (Redirect) về trang chủ kèm theo thông báo "Bạn không có quyền truy cập chức năng này!".
