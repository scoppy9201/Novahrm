<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; margin: 0; padding: 40px 0; }
        .wrap { max-width: 480px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1565C0, #2196F3); padding: 32px; text-align: center; }
        .header svg { width: 48px; height: 48px; fill: #fff; }
        .header h1 { color: #fff; font-size: 22px; margin: 12px 0 0; font-weight: 800; }
        .body { padding: 32px; }
        .body p { color: #475569; font-size: 14px; line-height: 1.7; margin: 0 0 20px; }
        .btn-wrap { text-align: center; margin: 28px 0; }
        .btn { display: inline-block; padding: 14px 36px; background: linear-gradient(135deg, #1565C0, #2196F3); color: #fff; text-decoration: none; border-radius: 10px; font-size: 15px; font-weight: 700; }
        .link-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 16px; font-size: 11px; color: #64748b; word-break: break-all; }
        .expire-note { font-size: 12px; color: #94a3b8; text-align: center; margin-top: 8px; }
        .footer { background: #f8fafc; padding: 20px 32px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">
            <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            <h1>NovaHRM</h1>
        </div>
        <div class="body">
            <p>Xin chào,</p>
            <p>Bạn vừa yêu cầu <strong>đăng nhập</strong> vào NovaHRM bằng Nova ID. Nhấn vào nút bên dưới để đăng nhập ngay — không cần mật khẩu.</p>
            <div class="btn-wrap">
                <a href="{{ $link }}" class="btn">Đăng nhập vào NovaHRM</a>
            </div>
            <p class="expire-note">Liên kết có hiệu lực trong <strong>15 phút</strong> và chỉ dùng được 1 lần.</p>
            <div class="link-box">{{ $link }}</div>
            <p style="margin-top:20px">Nếu bạn không yêu cầu đăng nhập, vui lòng bỏ qua email này.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} NovaHRM. Hệ thống quản lý nhân sự.
        </div>
    </div>
</body>
</html>