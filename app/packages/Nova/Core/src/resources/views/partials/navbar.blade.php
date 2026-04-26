<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <a href="/" class="logo">
        <div class="logo-icon">
            <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
        </div>
        Nova<span>HRM</span>
    </a>

    <div class="nav-center">
        <!-- Sản phẩm -->
        <button class="nav-item nav-toggle" data-menu="menu-sanpham">
            Sản phẩm
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>

        <!-- Giải pháp & Giá -->
        <button class="nav-item nav-toggle" data-menu="menu-giaiphap">
            Giải pháp & Giá
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>

        <!-- Lĩnh vực -->
        <button class="nav-item nav-toggle" data-menu="menu-linhvuc">
            Lĩnh vực
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>

        <a href="#" class="nav-item">Tin tức</a>
        <a href="#" class="nav-item">Khách hàng</a>
        <a href="#" class="nav-item">Về chúng tôi</a>
    </div>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-login">Đăng nhập</a>
        <a href="#" class="btn-demo" id="btnOpenDemo">Đăng ký Demo</a>
    </div>
</nav>

<!-- MEGA MENU OVERLAY -->
<div class="mega-overlay" id="megaOverlay"></div>

<!-- MEGA MENU: Sản phẩm -->
<div class="mega-menu" id="menu-sanpham">
    <div class="mega-inner">
        <div class="mega-col">
            <div class="mega-group-title">Nova HRM+</div>
            <div class="mega-links">
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#2563EB,#60A5FA)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova E-Hiring</div>
                        <div class="mega-link-desc">Quản trị tuyển dụng</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#4F46E5,#818CF8)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova HRM</div>
                        <div class="mega-link-desc">Quản trị & phát triển nhân sự</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#059669,#34D399)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Payroll</div>
                        <div class="mega-link-desc">Quản lý & tính lương tự động</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#0284C7,#38BDF8)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Schedule</div>
                        <div class="mega-link-desc">Quản lý & tính toán ngày công</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#D97706,#FBBF24)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Checkin</div>
                        <div class="mega-link-desc">Quản lý thời gian checkin</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#DC2626,#F87171)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Timeoff</div>
                        <div class="mega-link-desc">Quản lý tình trạng nghỉ phép</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="mega-col">
            <div class="mega-group-title">Nova Phát triển</div>
            <div class="mega-links">
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Referral</div>
                        <div class="mega-link-desc">Giới thiệu ứng viên nội bộ</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#065F46,#34D399)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Onboard</div>
                        <div class="mega-link-desc">Hội nhập nhân sự</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#6D28D9,#A78BFA)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Goal</div>
                        <div class="mega-link-desc">Quản trị mục tiêu</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#047857,#10B981)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Review</div>
                        <div class="mega-link-desc">Đánh giá nhân sự</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#065F46,#10B981)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Reward</div>
                        <div class="mega-link-desc">Ghi nhận thành tích & vinh danh</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#1D4ED8,#60A5FA)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Test</div>
                        <div class="mega-link-desc">Quản lý bài thi & chứng chỉ</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="mega-col">
            <div class="mega-group-title">Nova Vận hành</div>
            <div class="mega-links">
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#1D4ED8,#60A5FA)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Asset</div>
                        <div class="mega-link-desc">Quản lý tài sản doanh nghiệp</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#991B1B,#F87171)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova PIT</div>
                        <div class="mega-link-desc">Quản lý thuế thu nhập cá nhân</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#1E3A8A,#3B82F6)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova VSS</div>
                        <div class="mega-link-desc">Quản lý bảo hiểm xã hội</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#1E40AF,#3B82F6)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Case</div>
                        <div class="mega-link-desc">Quản lý sự vụ & vi phạm</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#0369A1,#38BDF8)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Me</div>
                        <div class="mega-link-desc">Cổng thông tin cho nhân viên</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#B45309,#F59E0B)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Nova Run</div>
                        <div class="mega-link-desc">Tổ chức giải chạy nội bộ</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- CTA Card -->
        <div class="mega-cta-card">
            <div class="mega-cta-glow"></div>
            <div class="mega-cta-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="mega-cta-title">Khám phá<br><span>Nền tảng Nova</span></div>
            <div class="mega-cta-desc">Bộ giải pháp khép kín đồng hành cùng 10,000+ doanh nghiệp Việt chuyên minh.</div>
            <a href="#" class="mega-cta-btn">
                Xem thêm
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- MEGA MENU: Giải pháp & Giá -->
<div class="mega-menu" id="menu-giaiphap">
    <div class="mega-inner">
        <div class="mega-col">
            <div class="mega-group-title">Theo quy mô</div>
            <div class="mega-links">
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#1D4ED8,#60A5FA)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Doanh nghiệp vừa & nhỏ</div>
                        <div class="mega-link-desc">Giải pháp tinh gọn, dễ triển khai</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Tập đoàn lớn</div>
                        <div class="mega-link-desc">Giải pháp toàn diện, mở rộng linh hoạt</div>
                    </div>
                </a>
                <a href="#" class="mega-link">
                    <div class="mega-link-icon" style="background:linear-gradient(135deg,#059669,#34D399)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <div class="mega-link-name">Bảng giá</div>
                        <div class="mega-link-desc">Minh bạch, linh hoạt theo nhu cầu</div>
                    </div>
                </a>
            </div>
        </div>
        <div class="mega-cta-card" style="margin-left:auto">
            <div class="mega-cta-glow"></div>
            <div class="mega-cta-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="mega-cta-title">Tư vấn<br><span>Miễn phí</span></div>
            <div class="mega-cta-desc">Đội ngũ chuyên gia sẵn sàng tư vấn giải pháp phù hợp nhất cho doanh nghiệp.</div>
            <a href="#" class="mega-cta-btn">Đăng ký ngay <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        </div>
    </div>
</div>

<!-- MEGA MENU: Lĩnh vực -->
<div class="mega-menu" id="menu-linhvuc">
    <div class="mega-inner">
        <div class="mega-col">
            <div class="mega-group-title">Lĩnh vực</div>
            <div class="mega-links">
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#1D4ED8,#60A5FA)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/></svg></div><div><div class="mega-link-name">Sản xuất</div><div class="mega-link-desc">Quản lý nhân sự nhà máy, ca kíp</div></div></a>
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#059669,#34D399)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><div><div class="mega-link-name">Dược phẩm</div><div class="mega-link-desc">Tuân thủ quy định, quản lý chứng chỉ</div></div></a>
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#D97706,#FBBF24)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"/></svg></div><div><div class="mega-link-name">Xây dựng</div><div class="mega-link-desc">Quản lý lao động công trình</div></div></a>
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#DC2626,#F87171)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg></div><div><div class="mega-link-name">F&B</div><div class="mega-link-desc">Chuỗi nhà hàng, quán ăn</div></div></a>
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#7C3AED,#A78BFA)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg></div><div><div class="mega-link-name">Giáo dục</div><div class="mega-link-desc">Trường học, trung tâm đào tạo</div></div></a>
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#0369A1,#38BDF8)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div><div><div class="mega-link-name">Y tế</div><div class="mega-link-desc">Bệnh viện, phòng khám</div></div></a>
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#B45309,#F59E0B)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg></div><div><div class="mega-link-name">Nội thất</div><div class="mega-link-desc">Showroom, xưởng sản xuất</div></div></a>
                <a href="#" class="mega-link"><div class="mega-link-icon" style="background:linear-gradient(135deg,#4F46E5,#818CF8)"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg></div><div><div class="mega-link-name">Khác</div><div class="mega-link-desc">Mọi loại hình doanh nghiệp</div></div></a>
            </div>
        </div>
        <div class="mega-cta-card" style="margin-left:auto">
            <div class="mega-cta-glow"></div>
            <div class="mega-cta-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="mega-cta-title">Phù hợp với<br><span>mọi ngành nghề</span></div>
            <div class="mega-cta-desc">NovaHRM linh hoạt theo đặc thù từng lĩnh vực, dễ dàng tùy chỉnh theo nhu cầu.</div>
            <a href="#" class="mega-cta-btn">Tìm hiểu thêm <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        </div>
    </div>
</div>