---
description: Quy tắc hướng dẫn người dùng tự code tay dự án TechStore từng bước nhỏ
---

# QUY TẮC HƯỚNG DẪN CODE BẮT BUỘC

Khi hướng dẫn người dùng viết code trong dự án này, LUÔN LUÔN tuân thủ 2 quy tắc sau:

1. **Mỗi lần chỉ viết 1 đoạn ngắn (khoảng 5 đến 10 dòng), rồi dừng lại chờ người dùng.** Không bao giờ đưa nguyên một file dài hoặc nhiều file cùng lúc.
2. **Khi code cần dùng một hàm, biến hoặc class ở file khác, hãy dừng lại và nói rõ:**
   - Nó nằm ở file nào (hoặc người dùng cần tạo ở đâu)
   - Nó nhận vào gì (input/tham số), trả về gì (output/kiểu trả về)
   - Nó dùng để làm gì trong đoạn code này
   - **Nếu chưa có thì hướng dẫn người dùng viết nó trước, rồi mới quay lại.**
3. **Luôn giải thích rõ luồng liên kết thực tế giữa các file (MVC):**
   - Khi gọi `$this->render('ten_thu_muc/ten_file', [...])`: phải chỉ rõ nó chạy hàm `render()` ở `Controller.php` dòng nào, truyền biến gì sang file `app/views/ten_thu_muc/ten_file.php`, và nếu file view đó chưa có thì phải tạo file view hoặc giải thích rõ trước/ngay lúc viết.
   - Khi đăng ký Route (`$router->get` hoặc `$router->post`): luôn giải thích rõ vì sao dùng `GET` (xem trang/link `<a>`) hay `POST` (gửi `<form method="POST">` làm thay đổi dữ liệu), và nó nối từ URL/Form nào vào hàm nào của Controller.
