# TÀI LIỆU ĐẶC TẢ USE CASE (USE CASE SPECIFICATIONS)

Tài liệu này cung cấp mô tả chi tiết (Kịch bản, Tiền/Hậu điều kiện, Luồng sự kiện chính/phụ) cho các Use Case cốt lõi của **Hệ thống Quản lý Chi tiêu và Tiện ích cá nhân**.

---

## 1. UC1 - Quản lý Danh mục (Nhà cung cấp & Dịch vụ)
*Dữ liệu Danh mục mang tính chất cá nhân hóa, mỗi người dùng tự quản lý danh sách của riêng mình.*

* **Tác nhân (Actor):** Quản trị viên (Admin) / Người dùng (User).
* **Mô tả:** Cho phép người dùng thêm, xem, sửa, xóa các đơn vị cung cấp dịch vụ (VD: EVN, VNPT) và các dịch vụ tương ứng (VD: Tiền điện, Internet) do chính họ tạo ra.
* **Tiền điều kiện:** Người dùng đã đăng nhập thành công.
* **Hậu điều kiện:** Dữ liệu danh mục được lưu vào CSDL, gắn với `nguoi_dung_id` và sẵn sàng để chọn khi tạo Hóa đơn.

**Luồng sự kiện chính (Basic Flow):**
1. Người dùng chọn menu "Nhà cung cấp" hoặc "Dịch vụ".
2. Hệ thống hiển thị danh sách các mục CỦA RIÊNG người dùng đó.
3. Người dùng nhấn nút "Thêm mới".
4. Hệ thống hiển thị Form nhập liệu.
5. Người dùng điền thông tin và nhấn Lưu.
6. Hệ thống kiểm tra dữ liệu hợp lệ, gắn `nguoi_dung_id` và lưu vào cơ sở dữ liệu.
7. Hệ thống quay về trang danh sách và thông báo thành công.

**Luồng rẽ nhánh (Alternate Flow):**
* *(5a) Bỏ trống trường bắt buộc:* Hệ thống chặn lại bằng HTML5 Validation và yêu cầu nhập đầy đủ.
* *(Thao tác Xóa - Delete):* Khi người dùng nhấn nút Xóa, hệ thống kiểm tra xem Nhà cung cấp/Dịch vụ này đã có Hóa đơn nào tham chiếu tới chưa. Nếu có, hệ thống hiển thị Alert từ chối xóa để bảo vệ toàn vẹn dữ liệu.

---

## 2. UC2 - Quản lý Hóa đơn và Chỉ số
*Dữ liệu Hóa đơn mang tính cá nhân hóa tuyệt đối (Data Isolation).*

* **Tác nhân (Actor):** Người dùng (User).
* **Mô tả:** Cho phép người dùng ghi nhận các khoản thu/chi phát sinh định kỳ (tiền điện, tiền nước).
* **Tiền điều kiện:** Người dùng đã đăng nhập. Đã có sẵn ít nhất 1 Nhà cung cấp và 1 Dịch vụ do mình tạo.
* **Hậu điều kiện:** Hóa đơn được tạo/cập nhật thành công và gắn cứng với `nguoi_dung_id`.

**Luồng sự kiện chính (Basic Flow):**
1. Người dùng chọn menu "Quản lý Hóa đơn".
2. Hệ thống hiển thị danh sách hóa đơn CỦA RIÊNG người dùng đó.
3. Người dùng chọn "Thêm Hóa đơn".
4. Người dùng chọn Nhà cung cấp từ Dropdown list.
5. Hệ thống hiển thị danh sách Dịch vụ tương ứng với Nhà cung cấp vừa chọn.
6. Người dùng nhập: Kỳ cước, Số tiền, Chỉ số tiêu thụ (nếu có), Ngày hạn chót.
7. Nhấn Lưu. Hệ thống gắn ID người dùng đang đăng nhập vào Hóa đơn và lưu xuống DB.

---

## 3. UC3 - Cập nhật Thanh toán & Upload Chứng từ
* **Tác nhân (Actor):** Người dùng (User).
* **Mô tả:** Thực hiện thanh toán cho Hóa đơn và tải lên biên lai, hình ảnh.
* **Tiền điều kiện:** Tồn tại ít nhất 1 Hóa đơn ở trạng thái "Chưa thanh toán".
* **Hậu điều kiện:** Hóa đơn chuyển trạng thái thành "Đã thanh toán" và File ảnh được lưu trữ an toàn.

**Luồng sự kiện chính (Basic Flow):**
1. Người dùng nhấn nút "Cập nhật thanh toán" trên một hóa đơn.
2. Hệ thống chuyển sang Form thanh toán và upload.
3. Người dùng chọn tệp từ thiết bị.
4. Nhấn "Xác nhận thanh toán".
5. Hệ thống kiểm tra tệp tin (Định dạng hợp lệ: jpg, png, pdf; Dung lượng < 5MB).
6. Hệ thống di chuyển (upload) file vào thư mục `resource/assets/uploads/`.
7. Hệ thống mở Transaction: Đổi trạng thái Hóa đơn -> Tạo mới Chứng từ (Lưu URL file).
8. Hiển thị thông báo "Thanh toán thành công".

---

## 4. UC4 - Xem Thống kê và Báo cáo (Dashboard)
* **Tác nhân (Actor):** Người dùng (User).
* **Mô tả:** Xem phân tích tài chính dạng biểu đồ và cảnh báo hạn chót.
* **Tiền điều kiện:** Người dùng đăng nhập thành công.
* **Hậu điều kiện:** Không làm thay đổi dữ liệu hệ thống (Read Only).

**Luồng sự kiện chính (Basic Flow):**
1. Người dùng truy cập Trang chủ (Thống kê).
2. Hệ thống quét hóa đơn chưa thanh toán của người dùng này.
3. Nếu có hóa đơn sắp/đã đến hạn, hiển thị Cảnh báo (Alert) màu đỏ/vàng.
4. Hệ thống kiểm tra tham số "Bộ lọc Tháng":
   * **Nếu không chọn tháng:** Truy vấn tổng tiền theo Kỳ cước -> Render **Biểu đồ Cột (Bar Chart)**.
   * **Nếu có chọn tháng:** Lọc dữ liệu của tháng đó, gom nhóm theo Dịch vụ -> Render **Biểu đồ Tròn (Pie Chart)**.

---

## 5. UC5 - Quản trị Hệ thống (Admin Only)
* **Tác nhân (Actor):** Quản trị viên (Admin).
* **Mô tả:** Quản lý toàn bộ tài khoản người dùng trên hệ thống.
* **Tiền điều kiện:** Tài khoản đăng nhập phải có `vai_tro = 1`.

**Luồng sự kiện chính (Basic Flow):**
1. Admin đăng nhập và truy cập trang Quản lý Người dùng.
2. Admin có thể "Thêm mới", "Chỉnh sửa" thông tin hoặc phân lại quyền.
3. Admin nhấn "Xóa" một người dùng.
4. Hệ thống thực thi **Cascade Delete (Xóa liên đới an toàn)**: Xóa toàn bộ File ảnh upload vật lý -> Xóa dữ liệu Chứng từ -> Xóa Hóa đơn -> Xóa Dịch vụ -> Xóa Nhà cung cấp -> Cuối cùng mới Xóa Tài khoản của người dùng đó để đảm bảo không để lại bất kỳ dữ liệu rác nào trên Database.
