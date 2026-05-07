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
        .otp-box { background: #eff6ff; border: 2px dashed #3b82f6; border-radius: 12px; padding: 24px; text-align: center; margin: 24px 0; }
        .otp-code { font-size: 40px; font-weight: 900; letter-spacing: 12px; color: #1d4ed8; font-family: monospace; }
        .otp-note { font-size: 12px; color: #94a3b8; margin-top: 8px; }
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

            @if(($type ?? 'login') === 'forgot_password')
                <p>Bạn vừa yêu cầu <strong>đặt lại mật khẩu</strong> cho tài khoản <strong>{{ $email }}</strong>. Sử dụng mã OTP bên dưới để tiếp tục:</p>
            @else
                <p>Bạn vừa yêu cầu <strong>đăng nhập</strong> vào NovaHRM bằng Nova ID với tài khoản <strong>{{ $email }}</strong>. Sử dụng mã OTP bên dưới để tiếp tục:</p>
            @endif

            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-note">
                    Mã có hiệu lực trong
                    <strong>{{ ($type ?? 'login') === 'forgot_password' ? '10' : '15' }} phút</strong>
                </div>
            </div>

            @if(($type ?? 'login') === 'forgot_password')
                <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
            @else
                <p>Nếu bạn không yêu cầu đăng nhập, vui lòng bỏ qua email này và bảo mật tài khoản của bạn.</p>
            @endif
        </div>
        <div class="footer">
            © {{ date('Y') }} NovaHRM. Hệ thống quản lý nhân sự.
        </div>
    </div>
</body>
</html>