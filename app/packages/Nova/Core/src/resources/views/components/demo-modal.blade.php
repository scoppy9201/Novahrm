<!-- DEMO MODAL -->
<div class="demo-modal-overlay" id="demoModalOverlay">
    <div class="demo-modal">
        <button class="demo-modal-close" id="demoModalClose">&#x2715;</button>

        <!-- LEFT -->
        <div class="demo-modal-left">
            <div class="demo-left-badge">
                <span class="demo-left-badge-dot"></span>
                Miễn phí — Không ràng buộc
            </div>
            <div class="demo-left-title">
                Nhận <span>tư vấn & demo</span><br>miễn phí từ<br>chuyên gia của Nova
            </div>
            <div class="demo-left-desc">
                NovaHRM cung cấp nền tảng tùy biến sâu, dễ dàng triển khai, và đáp ứng nhu cầu đặc thù của từng lĩnh vực.
            </div>
            <div class="demo-left-checks">
                <div class="demo-left-check">
                    <div class="demo-left-check-icon">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    Trải nghiệm ứng dụng thiết kế theo đúng nhu cầu doanh nghiệp
                </div>
                <div class="demo-left-check">
                    <div class="demo-left-check-icon">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    Tư vấn giải pháp quản trị theo ngành &amp; quy mô
                </div>
                <div class="demo-left-check">
                    <div class="demo-left-check-icon">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    Giải đáp mọi thắc mắc về triển khai và sử dụng
                </div>
            </div>
            <div class="demo-left-partners">
                <div class="demo-left-partners-label">10,000+ Doanh nghiệp đối tác</div>
                <div class="demo-left-logos">
                    <div class="demo-left-logo">AUTOTECH</div>
                    <div class="demo-left-logo">NEX</div>
                    <div class="demo-left-logo">WinCommerce</div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Form -->
        <div class="demo-modal-right">
            <div class="demo-form-title">Đăng ký tư vấn miễn phí</div>
            <div class="demo-form-sub">Điền thông tin để chuyên gia liên hệ trong vòng 24 giờ</div>

            <form id="demoForm">
                @csrf

                <div class="demo-form-group">
                    <label class="demo-form-label">Họ và tên <span>*</span></label>
                    <input id="df_name" class="demo-input" type="text" placeholder="Nhập tên của bạn">
                </div>

                <div class="demo-form-group">
                    <label class="demo-form-label">Sản phẩm bạn quan tâm <span>*</span></label>
                    <div class="demo-select-wrap">
                        <select id="df_product" class="demo-select">
                            <option value="" disabled selected>Lựa chọn sản phẩm</option>
                            <option>Nova E-Hiring</option>
                            <option>Nova HRM</option>
                            <option>Nova Payroll</option>
                            <option>Nova Schedule</option>
                            <option>Nova Checkin</option>
                            <option>Nova Timeoff</option>
                            <option>Toàn bộ nền tảng</option>
                        </select>
                    </div>
                </div>

                <div class="demo-form-row">
                    <div class="demo-form-group">
                        <label class="demo-form-label">Email <span>*</span></label>
                        <input id="df_email" class="demo-input" type="email" placeholder="Nhập email của bạn">
                    </div>
                    <div class="demo-form-group">
                        <label class="demo-form-label">Số điện thoại <span>*</span></label>
                        <input id="df_phone" class="demo-input" type="tel" placeholder="Nhập số điện thoại">
                    </div>
                </div>

                <div class="demo-form-row">
                    <div class="demo-form-group">
                        <label class="demo-form-label">Vị trí công việc <span>*</span></label>
                        <div class="demo-select-wrap">
                            <select id="df_position" class="demo-select">
                                <option value="" disabled selected>Lựa chọn vị trí</option>
                                <option>Giám đốc / CEO</option>
                                <option>Trưởng phòng HR</option>
                                <option>Nhân viên HR</option>
                                <option>Kế toán / Tài chính</option>
                                <option>IT / Kỹ thuật</option>
                                <option>Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="demo-form-group">
                        <label class="demo-form-label">Tên công ty <span>*</span></label>
                        <input id="df_company" class="demo-input" type="text" placeholder="Nhập tên công ty của bạn">
                    </div>
                </div>

                <div class="demo-form-row">
                    <div class="demo-form-group">
                        <label class="demo-form-label">Tỉnh/Thành phố <span>*</span></label>
                        <div class="demo-select-wrap">
                            <select id="df_city" class="demo-select">
                                <option value="" disabled selected>Lựa chọn khu vực</option>
                                <option>Hà Nội</option>
                                <option>TP. Hồ Chí Minh</option>
                                <option>Đà Nẵng</option>
                                <option>Cần Thơ</option>
                                <option>Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="demo-form-group">
                        <label class="demo-form-label">Quy mô nhân sự <span>*</span></label>
                        <div class="demo-select-wrap">
                            <select id="df_size" class="demo-select">
                                <option value="" disabled selected>Lựa chọn quy mô</option>
                                <option>Dưới 50 người</option>
                                <option>50 - 200 người</option>
                                <option>200 - 500 người</option>
                                <option>500 - 1000 người</option>
                                <option>Trên 1000 người</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" id="demoSubmitBtn" class="demo-submit-btn">
                    Nhận tư vấn giải pháp
                </button>

                <div class="demo-form-note">
                    Bằng cách nhấn "nhận tư vấn giải pháp", tôi xác nhận rằng tôi đã đọc và đồng ý với
                    <a href="#">Chính sách quyền riêng tư</a> của NovaHRM
                </div>
            </form>
        </div>
    </div>
</div>