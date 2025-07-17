### PHẦN 1: TÓM TẮT VỀ WEBSITE
- Bài tập lớn giữa kỳ môn Web nâng cao là một dự án quan trọng nhằm rèn luyện kỹ năng thiết kế và xây dựng một trang web hoàn chỉnh, giải quyết các bài toán thực tiễn hoặc hỗ trợ hoạt động quản lý, kinh doanh như hệ thống bán hàng, quản lý kho, hoặc đặt lịch dịch vụ. Trong bài tập lớn này, quá trình phát triển được bắt đầu bằng việc phân tích yêu cầu, xác định rõ mục tiêu của hệ thống, nhu cầu của người dùng, cũng như các tính năng cần thiết để đáp ứng những yêu cầu đó.
- Tiếp theo, chúng em tiến hành thiết kế giao diện với tiêu chí đơn giản, dễ sử dụng và thân thiện với người dùng, sử dụng HTML, CSS kết hợp với framework Tailwind để tối ưu trải nghiệm người dùng. Về mặt xử lý logic và phía server, đồ án sử dụng JavaScript thuần cho tương tác phía client và PHP với framework Laravel cho phần backend. Dữ liệu được lưu trữ và truy xuất hiệu quả thông qua hệ quản trị cơ sở dữ liệu MySQL. 

### PHẦN 2: GIỚI THIỆU
- Trong bối cảnh thương mại điện tử phát triển mạnh mẽ, đặc biệt là trong ngành thời trang và giày dép, việc sở hữu một website bán hàng chuyên nghiệp là yếu tố quan trọng để doanh nghiệp cạnh tranh và phát triển. Người tiêu dùng hiện đại không chỉ tìm kiếm sự tiện lợi mà còn yêu cầu trải nghiệm mua sắm trực tuyến đơn giản, nhanh chóng và đáng tin cậy. 
- Đề tài “Xây dựng trang web bán giày 2PSS Sneaker” được lựa chọn nhằm đáp ứng xu hướng thị trường hiện nay, giúp người dùng dễ dàng tiếp cận sản phẩm, đồng thời hỗ trợ doanh nghiệp quảng bá thương hiệu, mở rộng thị trường và tăng doanh số. Đây là một hướng đi phù hợp, thiết thực và giàu tiềm năng phát triển trong thời đại số hóa. 

### PHẦN 3: PHÂN TÍCH VÀ THIẾT KẾ HỆ THỐNG
#### 3.1 Công nghệ sử dụng 
##### 3.1.1 HTML, CSS 
ML (HyperText Markup Language) là ngôn ngữ đánh dấu chuẩn dùng để mô tả cấu trúc của trang web hiển thị trên trình duyệt. CSS (Cascading Style Sheets) là ngôn ngữ thiết kế dùng để tạo kiểu dáng cho website như màu sắc, phông chữ, bố cục, khoảng cách và hiệu ứng. Ra đời năm 1996 bởi W3C, CSS giúp tách phần nội dung (HTML) và phần trình bày. HTML và CSS luôn đi kèm, trong đó HTML là khung nền, còn CSS tạo nên tính thẩm mỹ cho toàn bộ trang web. 
##### 3.1.2 JavaScript 
JavaScript (JS) là một ngôn ngữ lập trình mạnh mẽ và linh hoạt, thường được sử dụng để tăng tính tương tác cho các trang web. Ban đầu JS chủ yếu hoạt động ở phía trình duyệt (client-side), nhưng hiện nay còn được sử dụng rộng rãi ở phía máy chủ (server-side) thông qua nền tảng Node.js. JS thuộc nhóm ngôn ngữ động, không yêu cầu khai báo kiểu dữ liệu cố định, chạy được trên nhiều môi trường khác nhau, hỗ trợ lập trình hướng đối tượng và dễ dàng kết hợp với các thư viện, framework hiện đại như React, Angular, Vue ở giao diện người dùng, hay PHP Laravel ở phía backend. 
##### 3.1.3 Laravel 
Giới thiệu:  
 Laravel là một framework PHP mạnh mẽ, được thiết kế để phát triển các ứng dụng web hiện đại. Framework này tuân theo mô hình MVC (Model-View-Controller) và cung cấp nhiều công cụ tích hợp giúp lập trình viên làm việc nhanh chóng và hiệu quả. 
Đặc điểm chính:  
-	Mô hình MVC: Giúp tổ chức mã nguồn rõ ràng, tách biệt phần giao diện, xử lý logic và dữ liệu 
-	Routing: Cung cấp hệ thống định tuyến linh hoạt để xử lý các yêu cầu HTTP một cách dễ dàng 
-	Migration và ORM (Eloquent): Cho phép quản lý cơ sở dữ liệu có hệ thống và làm việc với dữ liệu như đối tượng 
-	Blade Template Engine: Công cụ template mạnh mẽ, hỗ trợ xây dựng giao diện nhanh và dễ bảo trì 
-	Bảo mật: Tích hợp sẵn các cơ chế bảo mật như mã hóa, CSRF token, phân quyền truy cập 
-	Thư viện tích hợp: Hỗ trợ sẵn các chức năng như xác thực người dùng, gửi email, lưu cache và nhiều tiện ích khác 
##### 3.1.4 MySQL
MySQL là một hệ quản trị cơ sở dữ liệu quan hệ (RDBMS) mã nguồn mở rất phổ biến, sử dụng ngôn ngữ SQL để lưu trữ, truy vấn và quản lý dữ liệu hiệu quả.
Đặc điểm chính
-	Hiệu suất cao: Được tối ưu hóa cho các ứng dụng xử lý khối lượng dữ liệu lớn
-	Mã nguồn mở: Miễn phí sử dụng và có thể tùy chỉnh, mở rộng theo nhu cầu
-	Hỗ trợ ACID: Đảm bảo tính toàn vẹn, nhất quán và an toàn trong các giao dịch dữ liệu
-	Đa nền tảng: Hoạt động trên nhiều hệ điều hành như Windows, Linux, macOS
-	Hỗ trợ phong phú: Tích hợp dễ dàng với nhiều ngôn ngữ lập trình như PHP, Java, Python.
##### 3.1.5 Cấu trúc cơ sở dữ liệu 
<img width="937" height="1229" alt="image" src="https://github.com/user-attachments/assets/85fd9c97-1ed0-465c-987d-b0d675b1c109" />

### PHẦN 4: DANH MỤC CÁC HÌNH ẢNH
Hình 1 UseCase Diagram của hệ thống
<img width="1009" height="521" alt="image" src="https://github.com/user-attachments/assets/a860d4e2-8fbd-4c6f-8353-5c5b426e59b9" />

Hình 2 Giao diện trang chủ
<img width="941" height="518" alt="image" src="https://github.com/user-attachments/assets/b39e876e-8f1d-478d-92d8-f7f11f412e22" />

Hình 3 Giao diện tổng quan trong admin dashboard
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/05fe1589-0eb4-4d18-a876-eb5dc6072c88" />

Hình 4 Giao diện quản lý đơn hàng
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/a8b77604-8d25-4e0a-a22b-6ae2a8c25263" />

Hình 5 Giao diện quản lý chi tiết đơn hàng
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/f7eef756-bfe4-45a7-86fc-c0fc11440295" />
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/670214e6-1924-4edd-a646-182cc4ca049c" />

Hình 6 Giao diện quản lý sản phẩm
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/25b29678-b42f-4195-a38e-2023172f2212" />

Hình 7 Giao diện cập nhật sửa sản phẩm
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/de693cad-2e01-4df3-98ec-4a5a4a4f8d1d" />

Hình 8 Giao diện quản lý khách hàng
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/361b6e75-4acd-4392-8c74-cde486577e8b" />

Hình 9 Giao diện sửa thông tin khách hàng
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/f6d8cc64-f319-4eda-b02c-9956369b08fc" />

Hình 10 Giao diện quản lí bài viết Blog
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/a4c8122b-8de1-4534-8606-7f5d03539c01" />

Hình 11 Giao diện sửa bài viết Blog 
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/6ad5ae83-2c12-47bf-9fba-e12f2a45295d" />

Hình 12 Giao diện quản lý thông tin quản trị viên
<img width="940" height="527" alt="image" src="https://github.com/user-attachments/assets/7ea31762-61d8-4e70-8c8f-a07a220eb81a" />

Hình 13 Giao diện sửa thông tin quản trị viên
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/d34e8f31-3623-4f6c-91f1-90c1a5097606" />

Hình 14 Giao diện trang sản phẩm
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/42402af2-e9a4-4ce1-a60c-dd8c0be69209" />

Hình 15 Giao diện chi tiết sản phẩm
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/5891ac92-ba58-4654-b045-f848f08650f3" />
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/316c7aab-b8fa-4f1d-80fe-47824e32aa76" />
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/41b998c3-b5bd-4824-81d5-f3f7415e8dba" />
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/ef596345-6c36-4445-b4ae-548c15fd2d80" />

Hình 16 Giao diện sau khi bấm mua ngay
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/44dbc0b0-1362-4e64-9234-15fca7d44bd8" />
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/144284fb-b03d-493b-b23c-04cef7d514c1" />

Hình 17 Giao diện trang blog
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/d946f0f8-daab-40fc-a4f3-07c507874a4a" />
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/f4a43f99-ffbb-487c-a171-0675331881fb" />
<img width="940" height="525" alt="image" src="https://github.com/user-attachments/assets/9d67f6f0-a5fe-4dc1-98f7-4ac91f5c0ef1" />

Hình 18 Giao diện trang liên hệ
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/97870dc4-e829-4ddf-9654-5db540ce4291" />

Hình 19 Giao diện sau khi sử dụng thanh tìm kiếm
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/a8d4177f-3139-4a46-9bf8-2634ef5767cc" />

Hình 20 Giao diện giỏ hàng
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/8ab3cff9-ad28-4762-8322-0443ab1dcc67" />

Hình 21 Giao diện sau khi bấm mua trong giỏ hàng
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/4a7ad46e-87b1-46be-843d-e306b9200aa0" />
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/4290a7d5-52b2-446e-845a-6091fc998fd4" />

Hình 22 Giao diện mã QR momo thanh toán
<img width="940" height="529" alt="image" src="https://github.com/user-attachments/assets/f471f790-0a58-472d-8048-d43ce303073c" />


