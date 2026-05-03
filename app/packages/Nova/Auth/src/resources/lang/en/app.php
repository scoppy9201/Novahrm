<?php

return [

    'brand' => [
        'name' => 'NovaID',
        'powered_by' => 'Powered by Nova Inc.',
    ],

    'auth' => [
        'login_title' => 'Sign in',
        'login_subtitle' => 'to continue to :platform',
        'platform' => 'Nova Platform',

        'email' => 'Email',
        'email_placeholder' => 'employee@example.com',
        'email_invalid' => 'Please enter a valid email address.',

        'password' => 'Password',
        'password_placeholder' => 'Your password',
        'forgot_password' => 'Forgot password?',

        'remember_me' => 'Keep me signed in',
        'login_button' => 'Sign in',

        'continue' => 'Continue',
        'try_other_method' => 'Try another method',
        'confirm' => 'Confirm',
        'back' => 'Back',

        'login_with_nova_id' => 'Sign in with Nova ID',

        'magic_link_sent' => 'Nova ID has sent a sign-in link to',
        'magic_link_check' => 'Please check your email to continue signing in.',
        'resend' => 'Resend',
        'resend_otp' => 'Resend OTP',

        'otp_title' => 'Enter the OTP sent to your email',
        'otp_invalid' => 'Invalid OTP code.',
        'otp_not_received' => 'Didn’t receive the OTP?',

        'incognito_notice' => 'If this is not your computer, sign in using',
        'incognito_highlight' => 'a private browsing window',
        'incognito_suffix' => 'to protect your account.',
    ],

    'sso' => [
        'divider' => 'Or continue with SSO',

        'google' => 'Sign in with Google',
        'microsoft' => 'Sign in with Microsoft',
        'apple' => 'Sign in with Apple',
        'saml' => 'Sign in with SAML',
    ],

    'support' => [
        'need_help' => 'Need help?',
        'contact_admin' => 'Contact administrator',
    ],

    'dashboard' => [
        'employees_active' => 'Active employees',
        'today_up' => '↑ +12 today',

        'system_status' => 'System status',
        'system_online' => 'Running normally',

        'today_approval' => 'Today approvals',
        'approved' => '✓ 24 approved',
        'pending' => '⏳ 6 pending',

        'salary_this_month' => 'Payroll this month',
        'salary_processed' => '↑ Processed',

        'recruitment' => 'Recruitment',
        'candidates' => '12 candidates',
        'offers' => '3 offers',

        'attendance_today' => 'Attendance today',
        'attendance_ontime' => '● On time',

        'training' => 'Training',
        'courses' => '8 courses',
        'training_running' => 'In progress',
    ],

    'hero' => [
        'title_line_1' => 'Complete HR',
        'title_line_2' => 'management',
        'title_highlight' => 'platform',

        'description' => 'Automate HR workflows, process payroll accurately, and grow talent with NovaHRM.',

        'businesses' => 'Businesses',
        'uptime' => 'Uptime',
        'employees' => 'Employees',
    ],

    'footer' => [
        'protected_by' => 'Protected by',
        'terms' => 'Terms',
        'privacy' => 'Privacy',
        'help' => 'Help',
    ],

    'language' => [
        'vi' => 'Tiếng Việt',
        'en' => 'English',
    ],

    'title' => 'Forgot Password',

    'steps' => [

        'email' => [
            'title' => 'Forgot password?',
            'description' => 'Enter your email to receive a password reset OTP.',
            'send_otp' => 'Send OTP',
            'email_required' => 'Please enter your email address.',
            'otp_sent' => 'The OTP has been sent to your email.',
        ],

        'otp' => [
            'title' => 'Enter OTP',
            'description' => 'We sent a 6-digit code to',
            'not_received' => 'Didn’t receive the code?',
            'resend' => 'Resend',
            'confirm' => 'Confirm',
            'otp_required' => 'Please enter all 6 digits.',
            'otp_invalid' => 'Invalid OTP code.',
            'otp_success' => 'OTP verified successfully.',
        ],

        'reset' => [
            'title' => 'Reset Password',
            'description' => 'Enter a new password for your account.',

            'new_password' => 'New Password',
            'new_password_placeholder' => 'Minimum 8 characters',

            'confirm_password' => 'Confirm Password',
            'confirm_password_placeholder' => 'Re-enter your password',

            'submit' => 'Reset Password',

            'password_min' => 'Password must be at least 8 characters.',
            'password_not_match' => 'Password confirmation does not match.',

            'reset_success' => 'Password reset successfully. Redirecting to login...',
        ],

    ],

    'navigation' => [
        'back_login' => 'Back to login',
        'back' => 'Back',
    ],

    'toast' => [
        'login_success' => 'Login successful! Welcome back.',
        'logout_success' => 'Logged out successfully. See you again!',
        'logging_out' => 'Logging out...',
    ],

    'confirm' => [
        'logout' => [
            'title' => 'Logout',
            'message' => 'Are you sure you want to logout?',
            'confirm_text' => 'Logout',
            'cancel_text' => 'Cancel',
        ],
    ],
];