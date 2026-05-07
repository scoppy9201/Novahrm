<?php

return [

    'badge' => [
        'free' => 'Miễn phí — Không ràng buộc',
    ],

    'left' => [
        'title' => 'Nhận <span>tư vấn & demo</span><br>miễn phí từ<br>chuyên gia của Nova',
        'description' => 'NovaHRM cung cấp nền tảng tùy biến sâu, dễ dàng triển khai, và đáp ứng nhu cầu đặc thù của từng lĩnh vực.',
        'checks' => [
            'customized' => 'Trải nghiệm ứng dụng thiết kế theo đúng nhu cầu doanh nghiệp',
            'consulting' => 'Tư vấn giải pháp quản trị theo ngành & quy mô',
            'support' => 'Giải đáp mọi thắc mắc về triển khai và sử dụng',
        ],

        'partners' => [
            'label' => '10,000+ Doanh nghiệp đối tác',
        ],
    ],

    'form' => [

        'title' => 'Đăng ký tư vấn miễn phí',
        'subtitle' => 'Điền thông tin để chuyên gia liên hệ trong vòng 24 giờ',
        'fields' => [

            'name' => [
                'label' => 'Họ và tên',
                'placeholder' => 'Nhập tên của bạn',
            ],

            'product' => [
                'label' => 'Sản phẩm bạn quan tâm',
                'placeholder' => 'Lựa chọn sản phẩm',

                'options' => [
                    'e_hiring' => 'Nova E-Hiring',
                    'hrm' => 'Nova HRM',
                    'payroll' => 'Nova Payroll',
                    'schedule' => 'Nova Schedule',
                    'checkin' => 'Nova Checkin',
                    'timeoff' => 'Nova Timeoff',
                    'all' => 'Toàn bộ nền tảng',
                ],
            ],

            'email' => [
                'label' => 'Email',
                'placeholder' => 'Nhập email của bạn',
            ],

            'phone' => [
                'label' => 'Số điện thoại',
                'placeholder' => 'Nhập số điện thoại',
            ],

            'position' => [
                'label' => 'Vị trí công việc',
                'placeholder' => 'Lựa chọn vị trí',
                'options' => [
                    'ceo' => 'Giám đốc / CEO',
                    'hr_manager' => 'Trưởng phòng HR',
                    'hr_staff' => 'Nhân viên HR',
                    'finance' => 'Kế toán / Tài chính',
                    'it' => 'IT / Kỹ thuật',
                    'other' => 'Khác',
                ],
            ],

            'company' => [
                'label' => 'Tên công ty',
                'placeholder' => 'Nhập tên công ty của bạn',
            ],

            'city' => [
                'label' => 'Tỉnh/Thành phố',
                'placeholder' => 'Lựa chọn khu vực',
                'options' => [
                    'hn' => 'Hà Nội',
                    'hcm' => 'TP. Hồ Chí Minh',
                    'dn' => 'Đà Nẵng',
                    'ct' => 'Cần Thơ',
                    'other' => 'Khác',
                ],
            ],

            'size' => [
                'label' => 'Quy mô nhân sự',
                'placeholder' => 'Lựa chọn quy mô',
                'options' => [
                    'under_50' => 'Dưới 50 người',
                    '50_200' => '50 - 200 người',
                    '200_500' => '200 - 500 người',
                    '500_1000' => '500 - 1000 người',
                    'over_1000' => 'Trên 1000 người',
                ],
            ],

        ],

        'submit' => 'Nhận tư vấn giải pháp',
        'note' => 'Bằng cách nhấn "nhận tư vấn giải pháp", tôi xác nhận rằng tôi đã đọc và đồng ý với',
        'privacy_policy' => 'Chính sách quyền riêng tư',
        'note_suffix' => 'của NovaHRM',
    ],

    'meta' => [
        'title' => 'NovaHRM - Hệ thống quản lý nhân sự',
    ],

    'products' => [
        'eyebrow' => 'Hệ sinh thái sản phẩm',
        'title_line_1' => 'Hệ thống quản trị nhân sự',
        'title_highlight' => 'toàn diện cho doanh nghiệp',
        'subtitle' => 'Bộ giải pháp khép kín từ tuyển dụng, vận hành đến phát triển nhân sự — tất cả trong một nền tảng.',

        'items' => [
            'e_hiring'  => ['name' => 'Nova E-Hiring',  'desc' => 'Quản trị tuyển dụng'],
            'hrm'       => ['name' => 'Nova HRM',        'desc' => 'Quản trị & phát triển nhân sự'],
            'referral'  => ['name' => 'Nova Referral',   'desc' => 'Giới thiệu ứng viên từ nội bộ'],
            'payroll'   => ['name' => 'Nova Payroll',    'desc' => 'Quản lý & tính lương tự động'],
            'checkin'   => ['name' => 'Nova Checkin',    'desc' => 'Quản lý thời gian checkin'],
            'schedule'  => ['name' => 'Nova Schedule',   'desc' => 'Quản lý & tính toán ngày công'],
            'timeoff'   => ['name' => 'Nova Timeoff',    'desc' => 'Quản lý tình trạng nghỉ phép'],
            'asset'     => ['name' => 'Nova Asset',      'desc' => 'Quản lý tài sản doanh nghiệp'],
            'review'    => ['name' => 'Nova Review',     'desc' => 'Đánh giá nhân sự'],
            'goal'      => ['name' => 'Nova Goal',       'desc' => 'Quản trị mục tiêu'],
            'run'       => ['name' => 'Nova Run',        'desc' => 'Tổ chức giải chạy nội bộ'],
            'onboard'   => ['name' => 'Nova Onboard',    'desc' => 'Hội nhập nhân sự'],
            'case'      => ['name' => 'Nova Case',       'desc' => 'Quản lý các sự vụ & vi phạm'],
            'test'      => ['name' => 'Nova Test',       'desc' => 'Quản lý bài thi & chứng chỉ'],
            'me'        => ['name' => 'Nova Me',         'desc' => 'Cổng thông tin cho nhân viên'],
            'pit'       => ['name' => 'Nova PIT',        'desc' => 'Quản lý thuế thu nhập cá nhân'],
            'reward'    => ['name' => 'Nova Reward',     'desc' => 'Ghi nhận thành tích & vinh danh'],
            'vss'       => ['name' => 'Nova VSS',        'desc' => 'Quản lý bảo hiểm xã hội'],
        ],
    ],

    'navbar' => [
        'products'       => 'Sản phẩm',
        'solutions'      => 'Giải pháp & Giá',
        'industries'     => 'Lĩnh vực',
        'news'           => 'Tin tức',
        'customers'      => 'Khách hàng',
        'about'          => 'Về chúng tôi',
        'login'          => 'Đăng nhập',
        'register_demo'  => 'Đăng ký Demo',
    ],

    'mega' => [
        'products' => [
            'group_hrm'  => 'Nova HRM+',
            'group_dev'  => 'Nova Phát triển',
            'group_ops'  => 'Nova Vận hành',

            'cta' => [
                'title'    => 'Khám phá',
                'highlight'=> 'Nền tảng Nova',
                'desc'     => 'Bộ giải pháp khép kín đồng hành cùng 10,000+ doanh nghiệp Việt chuyên minh.',
                'btn'      => 'Xem thêm',
            ],

            'hrm_plus' => [
                'e_hiring'  => ['name' => 'Nova E-Hiring',  'desc' => 'Quản trị tuyển dụng'],
                'hrm'       => ['name' => 'Nova HRM',        'desc' => 'Quản trị & phát triển nhân sự'],
                'payroll'   => ['name' => 'Nova Payroll',    'desc' => 'Quản lý & tính lương tự động'],
                'schedule'  => ['name' => 'Nova Schedule',   'desc' => 'Quản lý & tính toán ngày công'],
                'checkin'   => ['name' => 'Nova Checkin',    'desc' => 'Quản lý thời gian checkin'],
                'timeoff'   => ['name' => 'Nova Timeoff',    'desc' => 'Quản lý tình trạng nghỉ phép'],
            ],

            'dev' => [
                'referral'  => ['name' => 'Nova Referral',  'desc' => 'Giới thiệu ứng viên nội bộ'],
                'onboard'   => ['name' => 'Nova Onboard',   'desc' => 'Hội nhập nhân sự'],
                'goal'      => ['name' => 'Nova Goal',      'desc' => 'Quản trị mục tiêu'],
                'review'    => ['name' => 'Nova Review',    'desc' => 'Đánh giá nhân sự'],
                'reward'    => ['name' => 'Nova Reward',    'desc' => 'Ghi nhận thành tích & vinh danh'],
                'test'      => ['name' => 'Nova Test',      'desc' => 'Quản lý bài thi & chứng chỉ'],
            ],

            'ops' => [
                'asset'     => ['name' => 'Nova Asset',     'desc' => 'Quản lý tài sản doanh nghiệp'],
                'pit'       => ['name' => 'Nova PIT',       'desc' => 'Quản lý thuế thu nhập cá nhân'],
                'vss'       => ['name' => 'Nova VSS',       'desc' => 'Quản lý bảo hiểm xã hội'],
                'case'      => ['name' => 'Nova Case',      'desc' => 'Quản lý sự vụ & vi phạm'],
                'me'        => ['name' => 'Nova Me',        'desc' => 'Cổng thông tin cho nhân viên'],
                'run'       => ['name' => 'Nova Run',       'desc' => 'Tổ chức giải chạy nội bộ'],
            ],
        ],

        'solutions' => [
            'group_scale' => 'Theo quy mô',

            'cta' => [
                'title'    => 'Tư vấn',
                'highlight'=> 'Miễn phí',
                'desc'     => 'Đội ngũ chuyên gia sẵn sàng tư vấn giải pháp phù hợp nhất cho doanh nghiệp.',
                'btn'      => 'Đăng ký ngay',
            ],

            'items' => [
                'sme'      => ['name' => 'Doanh nghiệp vừa & nhỏ', 'desc' => 'Giải pháp tinh gọn, dễ triển khai'],
                'enterprise'=> ['name' => 'Tập đoàn lớn',          'desc' => 'Giải pháp toàn diện, mở rộng linh hoạt'],
                'pricing'  => ['name' => 'Bảng giá',               'desc' => 'Minh bạch, linh hoạt theo nhu cầu'],
            ],
        ],

        'industries' => [
            'group_label' => 'Lĩnh vực',

            'cta' => [
                'title'    => 'Phù hợp với',
                'highlight'=> 'mọi ngành nghề',
                'desc'     => 'NovaHRM linh hoạt theo đặc thù từng lĩnh vực, dễ dàng tùy chỉnh theo nhu cầu.',
                'btn'      => 'Tìm hiểu thêm',
            ],

            'items' => [
                'manufacturing' => ['name' => 'Sản xuất',    'desc' => 'Quản lý nhân sự nhà máy, ca kíp'],
                'pharma'        => ['name' => 'Dược phẩm',   'desc' => 'Tuân thủ quy định, quản lý chứng chỉ'],
                'construction'  => ['name' => 'Xây dựng',    'desc' => 'Quản lý lao động công trình'],
                'fnb'           => ['name' => 'F&B',          'desc' => 'Chuỗi nhà hàng, quán ăn'],
                'education'     => ['name' => 'Giáo dục',    'desc' => 'Trường học, trung tâm đào tạo'],
                'healthcare'    => ['name' => 'Y tế',         'desc' => 'Bệnh viện, phòng khám'],
                'furniture'     => ['name' => 'Nội thất',    'desc' => 'Showroom, xưởng sản xuất'],
                'other'         => ['name' => 'Khác',         'desc' => 'Mọi loại hình doanh nghiệp'],
            ],
        ],
    ],

    'journey' => [
        'title_line1'  => 'Đồng hành cùng doanh nghiệp',
        'title_line2'  => 'xuyên suốt',
        'title_line3'  => 'lộ trình chuyển đổi số',
        'cta_btn'      => 'Tư vấn triển khai ngay',

        'tabs' => [
            'consulting'    => 'Tư vấn',
            'digitizing'    => 'Số hóa',
            'optimizing'    => 'Tối ưu hóa',
            'data_driven'   => 'Dữ liệu hóa',
        ],

        'slides' => [
            'consulting' => [
                'title' => 'Tư vấn',
                'desc'  => 'Khảo sát hiện trạng vận hành của doanh nghiệp. Tư vấn, đào tạo, xây dựng quy trình nâng cao khả năng vận hành & thiết kế lộ trình số hóa phù hợp.',
                'steps' => [
                    '1' => 'Khảo sát nhu cầu doanh nghiệp',
                    '2' => 'Thiết kế lộ trình & tối ưu quy trình',
                    '3' => 'Hướng dẫn & tư vấn chuyên sâu',
                    '4' => 'Tổng kết & đánh giá',
                ],
            ],
            'digitizing' => [
                'title' => 'Số hóa',
                'desc'  => 'Triển khai hệ thống NovaHRM, số hóa toàn bộ dữ liệu nhân sự, chấm công, lương thưởng. Đào tạo nhân viên sử dụng thành thạo nền tảng.',
                'steps' => [
                    '1' => 'Import dữ liệu nhân sự hàng loạt',
                    '2' => 'Cấu hình chấm công & ca làm',
                    '3' => 'Đào tạo nhân viên sử dụng',
                    '4' => 'Go-live & kiểm tra thực tế',
                ],
            ],
            'optimizing' => [
                'title' => 'Tối ưu hóa',
                'desc'  => 'Phân tích dữ liệu vận hành thực tế, tối ưu quy trình nhân sự, tự động hóa các tác vụ lặp lại và nâng cao hiệu suất toàn hệ thống.',
                'steps' => [
                    '1' => 'Phân tích báo cáo hiệu suất',
                    '2' => 'Tự động hóa quy trình lặp lại',
                    '3' => 'Tinh chỉnh chính sách lương thưởng',
                    '4' => 'Đánh giá & cải tiến liên tục',
                ],
            ],
            'data_driven' => [
                'title' => 'Dữ liệu hóa',
                'desc'  => 'Xây dựng kho dữ liệu nhân sự tập trung, phân tích xu hướng dài hạn và đưa ra dự báo thông minh hỗ trợ ra quyết định chiến lược.',
                'steps' => [
                    '1' => 'Tập trung hóa kho dữ liệu nhân sự',
                    '2' => 'Phân tích xu hướng dài hạn',
                    '3' => 'Cảnh báo & dự báo thông minh',
                    '4' => 'Báo cáo chiến lược cho lãnh đạo',
                ],
            ],
        ],
    ],

    'industries' => [
        'eyebrow' => 'Linh hoạt đáp ứng',
        'title'   => 'lĩnh vực trên một nền tảng duy nhất',
    
        'tabs' => [
            'manufacturing' => 'Sản xuất',
            'pharma'        => 'Dược phẩm',
            'construction'  => 'Xây dựng',
            'fnb'           => 'F&B',
            'education'     => 'Giáo dục',
            'healthcare'    => 'Y Tế',
            'furniture'     => 'Nội thất',
            'other'         => 'Khác',
        ],
    
        'panels' => [
    
            'manufacturing' => [
                'title'         => 'Ngành Sản xuất',
                'clients_label' => 'Khách hàng tiêu biểu',
                'cta'           => 'Tìm hiểu thêm',
                'clients'       => ['AMECC', 'AUTOTECH', 'HAWEE'],
                'features' => [
                    1 => 'Số hóa quy trình theo tiêu chuẩn ISO, chủ động kiểm soát tiến độ sản xuất.',
                    2 => 'Thiết lập & quản lý kế hoạch sản xuất khoa học, liên kết với quy trình xử lý đơn hàng, quy trình xuất nhập kho,...',
                    3 => 'Báo cáo doanh thu, chi phí, công nợ trực quan theo thời gian thực.',
                ],
                'mockup' => [
                    'header' => 'Đề xuất mua hàng',
                    'rows' => [
                        1 => ['label' => 'Dây chuyền A2',  'value' => 'Đã duyệt',  'badge' => 'badge-green'],
                        2 => ['label' => 'Linh kiện #3847', 'value' => 'Đang xét',  'badge' => 'badge-orange'],
                        3 => ['label' => 'Vật tư kho B',   'value' => 'Chờ duyệt', 'badge' => 'badge-blue'],
                        4 => ['label' => 'Thiết bị QC',    'value' => 'Đã duyệt',  'badge' => 'badge-green'],
                    ],
                ],
            ],
    
            'pharma' => [
                'title'         => 'Ngành Dược phẩm',
                'clients_label' => 'Khách hàng tiêu biểu',
                'cta'           => 'Tìm hiểu thêm',
                'clients'       => ['Pharmacity', 'Long Châu', 'An Khang'],
                'features' => [
                    1 => 'Quản lý lô hàng, hạn sử dụng và truy xuất nguồn gốc theo tiêu chuẩn GMP.',
                    2 => 'Kiểm soát quy trình phân phối, quản lý nhà thuốc và đại lý toàn quốc.',
                    3 => 'Cảnh báo tự động khi hàng sắp hết hạn hoặc tồn kho dưới ngưỡng an toàn.',
                ],
                'mockup' => [
                    'header' => 'Kiểm soát lô hàng',
                    'rows' => [
                        1 => ['label' => 'Lô #DP-2024-01',    'value' => 'Đạt chuẩn',  'badge' => 'badge-green'],
                        2 => ['label' => 'Hạn dùng: 12/2026', 'value' => 'Theo dõi',   'badge' => 'badge-blue'],
                        3 => ['label' => 'Kiểm định GMP',      'value' => 'Hoàn tất',   'badge' => 'badge-green'],
                        4 => ['label' => 'Phân phối vùng HN',  'value' => 'Đang giao',  'badge' => 'badge-orange'],
                    ],
                ],
            ],
    
            'construction' => [
                'title'         => 'Ngành Xây dựng',
                'clients_label' => 'Khách hàng tiêu biểu',
                'cta'           => 'Tìm hiểu thêm',
                'clients'       => ['Hòa Bình', 'Delta', 'Coteccons'],
                'features' => [
                    1 => 'Quản lý tiến độ dự án theo từng hạng mục, theo dõi nhân công và vật tư tại công trường.',
                    2 => 'Kiểm soát chi phí, dự toán và quyết toán công trình theo thời gian thực.',
                    3 => 'Phân bổ nguồn lực và máy móc thiết bị tối ưu giữa các công trình.',
                ],
                'mockup' => [
                    'header' => 'Tiến độ dự án',
                    'rows' => [
                        1 => ['label' => 'Tòa A - Móng',       'value' => '100%',    'badge' => 'badge-green'],
                        2 => ['label' => 'Tòa A - Thô',        'value' => '68%',     'badge' => 'badge-orange'],
                        3 => ['label' => 'Tòa B - Thiết kế',   'value' => 'Hoàn tất','badge' => 'badge-blue'],
                        4 => ['label' => 'Hạ tầng kỹ thuật',   'value' => '40%',     'badge' => 'badge-orange'],
                    ],
                ],
            ],
    
            'fnb' => [
                'title'         => 'Ngành F&B',
                'clients_label' => 'Khách hàng tiêu biểu',
                'cta'           => 'Tìm hiểu thêm',
                'clients'       => ['Jollibee', 'Phúc Long', 'Baemin'],
                'features' => [
                    1 => 'Quản lý chuỗi cửa hàng, phân ca nhân viên và kiểm soát doanh thu từng điểm bán.',
                    2 => 'Tự động cảnh báo tồn kho nguyên liệu, hỗ trợ đặt hàng nhà cung cấp kịp thời.',
                    3 => 'Phân tích hiệu suất từng cơ sở, hỗ trợ quyết định mở rộng chuỗi nhanh chóng.',
                ],
                'mockup' => [
                    'header' => 'Quản lý chuỗi',
                    'rows' => [
                        1 => ['label' => 'CS Hà Nội (12 điểm)', 'value' => 'Ổn định',  'badge' => 'badge-green'],
                        2 => ['label' => 'Doanh thu hôm nay',   'value' => '148 tr',   'badge' => 'badge-blue'],
                        3 => ['label' => 'Tồn kho nguyên liệu', 'value' => 'Cảnh báo', 'badge' => 'badge-orange'],
                        4 => ['label' => 'Nhân viên ca chiều',  'value' => 'Đủ ca',    'badge' => 'badge-green'],
                    ],
                ],
            ],
    
            'education' => [
                'title'         => 'Ngành Giáo dục',
                'clients_label' => 'Khách hàng tiêu biểu',
                'cta'           => 'Tìm hiểu thêm',
                'clients'       => ['RMIT', 'FPT Edu', 'IvyPrep'],
                'features' => [
                    1 => 'Quản lý học viên, lịch học, điểm danh và học phí tập trung trên một nền tảng.',
                    2 => 'Theo dõi hiệu suất giảng dạy, xếp lịch giáo viên và quản lý cơ sở vật chất.',
                    3 => 'Báo cáo tự động gửi phụ huynh và ban lãnh đạo định kỳ.',
                ],
                'mockup' => [
                    'header' => 'Quản lý học viên',
                    'rows' => [
                        1 => ['label' => 'Lớp K12-A1',        'value' => '38/40',  'badge' => 'badge-green'],
                        2 => ['label' => 'Học phí tháng 4',   'value' => '92%',    'badge' => 'badge-orange'],
                        3 => ['label' => 'GV nghỉ phép',      'value' => '3 người','badge' => 'badge-blue'],
                        4 => ['label' => 'Điểm danh hôm nay', 'value' => '98.5%',  'badge' => 'badge-green'],
                    ],
                ],
            ],
    
            'healthcare' => [
                'title'         => 'Ngành Y Tế',
                'clients_label' => 'Khách hàng tiêu biểu',
                'cta'           => 'Tìm hiểu thêm',
                'clients'       => ['Vinmec', 'Thu Cúc', 'Medlatec'],
                'features' => [
                    1 => 'Xếp lịch trực, quản lý ca làm cho bác sĩ và điều dưỡng theo từng khoa, phòng.',
                    2 => 'Tự động cảnh báo thiếu nhân sự ca trực, hỗ trợ điều phối kịp thời.',
                    3 => 'Quản lý chứng chỉ hành nghề, đào tạo và phát triển chuyên môn nhân viên y tế.',
                ],
                'mockup' => [
                    'header' => 'Lịch trực bệnh viện',
                    'rows' => [
                        1 => ['label' => 'Ca sáng - Khoa Nội', 'value' => 'Đủ nhân sự', 'badge' => 'badge-green'],
                        2 => ['label' => 'Ca chiều - Cấp cứu', 'value' => '-1 BS',       'badge' => 'badge-orange'],
                        3 => ['label' => 'Trực đêm 22/4',      'value' => 'Đã xếp',      'badge' => 'badge-blue'],
                        4 => ['label' => 'Nghỉ phép BS Tuấn',  'value' => 'Đã duyệt',    'badge' => 'badge-green'],
                    ],
                ],
            ],
    
            'furniture' => [
                'title'         => 'Ngành Nội thất',
                'clients_label' => 'Khách hàng tiêu biểu',
                'cta'           => 'Tìm hiểu thêm',
                'clients'       => ['JYSK', 'Savimex', 'Maxhome'],
                'features' => [
                    1 => 'Quản lý đơn hàng thi công, tiến độ từng dự án và đội thợ theo địa bàn.',
                    2 => 'Kiểm soát vật tư, phụ kiện và chi phí phát sinh theo từng công trình.',
                    3 => 'Chăm sóc khách hàng sau bán hàng, quản lý bảo hành sản phẩm tự động.',
                ],
                'mockup' => [
                    'header' => 'Đơn hàng thi công',
                    'rows' => [
                        1 => ['label' => 'Dự án nhà anh Minh', 'value' => '75%',     'badge' => 'badge-orange'],
                        2 => ['label' => 'Căn hộ Vinhomes',    'value' => 'Hoàn tất','badge' => 'badge-green'],
                        3 => ['label' => 'Showroom Hà Nội',    'value' => 'Đang đo', 'badge' => 'badge-blue'],
                        4 => ['label' => 'Văn phòng FPT',      'value' => '40%',     'badge' => 'badge-orange'],
                    ],
                ],
            ],
    
            'other' => [
                'title'         => 'Mọi lĩnh vực khác',
                'clients_label' => 'Liên hệ tư vấn',
                'cta'           => 'Liên hệ ngay',
                'clients'       => ['Logistics', 'Bảo hiểm', 'Bán lẻ'],
                'features' => [
                    1 => 'NovaHRM linh hoạt tùy chỉnh theo đặc thù vận hành của từng ngành nghề.',
                    2 => 'Đội ngũ tư vấn chuyên sâu hỗ trợ triển khai phù hợp với mô hình doanh nghiệp.',
                    3 => 'API mở, tích hợp linh hoạt với hệ thống ERP, CRM và phần mềm kế toán hiện có.',
                ],
                'mockup' => [
                    'header' => '60+ lĩnh vực',
                    'rows' => [
                        1 => ['label' => 'Logistics', 'value' => 'Hỗ trợ', 'badge' => 'badge-green'],
                        2 => ['label' => 'Bảo hiểm',  'value' => 'Hỗ trợ', 'badge' => 'badge-green'],
                        3 => ['label' => 'Bán lẻ',    'value' => 'Hỗ trợ', 'badge' => 'badge-green'],
                        4 => ['label' => 'Tài chính',  'value' => 'Hỗ trợ', 'badge' => 'badge-green'],
                    ],
                ],
            ],
        ],
    ],

    'hero' => [
        'badge'       => 'Hệ thống quản lý nhân sự hiện đại',
        'title' => [
            'line1_blue'  => 'Tự động hoá',
            'line1_white' => 'tuyển dụng',
            'line2_white' => 'Vận hành công ca',
            'line2_blue'  => 'linh hoạt',
            'line3_white' => 'Giữ chân',
            'line3_blue'  => 'nhân tài',
        ],
        'desc'         => 'Xây dựng chiến lược phát triển nhân sự hoàn chỉnh, từ tuyển dụng, hội nhập, đào tạo. Xử lý công lương linh hoạt & trọn vẹn, biến các thủ tục C&B phức tạp thành hạnh phúc',
        'btn_demo'     => 'Đăng ký Demo',
        'btn_features' => 'Xem tính năng',
    
        'preview' => [
            // breadcrumb
            'breadcrumb_list'   => 'Danh sách nhân sự',
            'breadcrumb_detail' => 'Chi tiết',
    
            // employee card
            'emp_name'     => 'Bùi Mạnh Hưng',
            'emp_position' => 'Trưởng phòng Kinh doanh',
            'emp_tenure'   => '1 năm 2 tháng 22 ngày làm việc',
            'live'         => 'Live',
    
            // timeline
            'work_history'  => 'Lịch sử làm việc',
            'tl_date'       => 'Thứ 5, 30/03/2025',
            'tl_hours'      => '8 giờ làm việc',
            'tl_leave_warn' => '11 ngày tới hết phép',
            'tl_leave_sub'  => 'Phép năm còn lại',
    
            // quick actions
            'quick_actions' => 'Thao tác nhanh',
            'qi_profile'    => 'Hồ sơ',
            'qi_payroll'    => 'Bảng lương',
            'qi_checkin'    => 'Chấm công',
            'qi_leave'      => 'Nghỉ phép',
    
            // payroll mini
            'your_payroll' => 'Bảng lương của bạn',
            'payroll_tag'  => 'Payroll 02/2025',
            'payroll_val'  => '11,440,000đ',
    
            // bottom nav
            'nav_profile'  => 'Hồ sơ',
            'nav_payroll'  => 'Bảng lương',
            'nav_policy'   => 'Chính sách',
            'nav_leave'    => 'Nghỉ phép',
            'nav_settings' => 'Cài đặt',
    
            // desktop topbar
            'desk_breadcrumb' => 'Danh sách nhân sự',
            'online'          => 'Trực tuyến',
    
            // desktop sidebar
            'sidebar' => [
                'personal_info' => 'Thông tin cá nhân',
                'job_info'      => 'Thông tin công việc',
                'salary'        => 'Lương & Phúc lợi',
                'leave_list'    => 'Danh sách nghỉ vụ',
                'achievements'  => 'Thành tựu & giải thưởng',
                'violations'    => 'Vi phạm',
                'review'        => 'Đánh giá & phân hối',
            ],
    
            // desktop main
            'desk_page_title'    => 'Các thông tin về công việc & sự nghiệp',
            'btn_edit_job'       => 'Sửa thông tin công việc',
            'btn_edit_salary'    => 'Sửa thông tin lương',
            'section_job_info'   => 'THÔNG TIN CÔNG VIỆC',
            'section_achievements' => 'THÀNH TỰU, CÔNG HIẾN',
    
            // job info grid
            'job' => [
                'position'          => 'Vị trí công việc',
                'office'            => 'Văn phòng',
                'office_val'        => 'Tổng công ty',
                'type'              => 'Phân loại nhân sự',
                'type_val'          => 'Toàn thời gian',
                'area'              => 'Khu vực / Chuyển nơi',
                'area_val'          => 'Logistic',
                'salary_policy'     => 'Chính sách lương',
                'salary_policy_val' => 'BL Tây Bắc',
                'start_date'        => 'Ngày bắt đầu',
                'start_date_val'    => '12/04/2024',
                'official_date'     => 'Ngày chính thức',
                'official_date_val' => '01/07/2020',
                'schedule'          => 'Mẫu lịch Văn phòng',
                'schedule_val'      => 'Mẫu lịch VP',
                'gross'             => 'Lương',
                'gross_val'         => '35,000,000',
                'basic'             => 'Lương cơ bản',
                'basic_val'         => '20,000,000',
            ],
    
            // achievements
            'achievement_list' => [
                ['icon' => '🏆', 'label' => 'Nhân viên xuất sắc của năm'],
                ['icon' => '🥇', 'label' => '1,000,000,000đ doanh thu'],
                ['icon' => '🔥', 'label' => 'Sự cạnh tranh'],
                ['icon' => '💙', 'label' => 'Người đồng đội tuyệt vời'],
                ['icon' => '🎯', 'label' => '100 khách hàng'],
                ['icon' => '⭐', 'label' => 'Nghị lực hành trình mới'],
            ],
    
            // salary card
            'sal_header'       => 'Bảng lương',
            'sal_tab_overview' => 'Tổng quan',
            'sal_tab_allowance'=> 'Phụ lương',
            'sal_tab_benefit'  => 'Phúc lợi',
            'sal_label'        => 'Thực nhận gần đây',
            'sal_amount'       => '23,648,547',
            'sal_unit'         => '.73 đ',
            'sal_basic'        => 'Lương cơ bản',
            'sal_basic_val'    => '20,000,000đ',
            'sal_allowance'    => 'Phụ cấp',
            'sal_allowance_val'=> '+4,848,547đ',
            'sal_tax'          => 'Thuế TNCN',
            'sal_tax_val'      => '-1,200,000đ',
            'sal_distribution' => 'PHÂN BỔ LƯƠNG',
            'sal_net_pct'      => 'Thực nhận 83%',
            'sal_deduct_pct'   => 'Khấu trừ 17%',
    
            // chart months
            'chart_months' => ['T9', 'T10', 'T11', 'T12', 'T1', 'T2'],
        ],
    ],

    'footer' => [
        'brand_desc'     => 'Nền tảng quản lý nhân sự hiện đại, giúp doanh nghiệp Việt vận hành hiệu quả và chuyên nghiệp hơn.',

        'features' => [
            'title'               => 'Tính năng',
            'employee_management' => 'Quản lý nhân viên',
            'attendance'          => 'Chấm công & Ca làm',
            'payroll'             => 'Tính lương tự động',
            'reports'             => 'Báo cáo & Thống kê',
            'roles'               => 'Phân quyền vai trò',
        ],

        'tools' => [
            'title'         => 'Công cụ',
            'import'        => 'Import nhân viên',
            'export_pdf'    => 'Xuất phiếu lương PDF',
            'dashboard'     => 'Dashboard quản trị',
            'leave_calendar'=> 'Lịch nghỉ phép',
            'contract'      => 'Hợp đồng lao động',
        ],

        'company' => [
            'title'   => 'Công ty',
            'about'   => 'Về chúng tôi',
            'blog'    => 'Blog',
            'contact' => 'Liên hệ',
            'careers' => 'Tuyển dụng',
        ],

        'support' => [
            'title'       => 'Hỗ trợ',
            'help_center' => 'Trung tâm hỗ trợ',
            'docs'        => 'Tài liệu hướng dẫn',
            'technical'   => 'Hỗ trợ kỹ thuật',
            'community'   => 'Cộng đồng',
            'report_bug'  => 'Báo lỗi',
        ],

        'copyright'     => '© 2026 NovaHRM. All rights reserved.',
        'system_status' => 'Tất cả hệ thống hoạt động bình thường',
        'terms'         => 'Điều khoản sử dụng',
        'privacy'       => 'Chính sách bảo mật',
        'data_protection' => 'Bảo vệ dữ liệu',
    ],

    'fab' => [
        'ai_tooltip'    => 'Hỏi AI',
        'zalo_tooltip'  => 'Chat Zalo',
        'phone_tooltip' => 'Gọi ngay',
    ],

    'cta' => [
        'badge'     => 'Miễn phí · Không cần thẻ tín dụng',
        'title'     => 'Sẵn sàng đưa nhân sự<br>lên tầm cao mới?',
        'sub'       => 'Hàng trăm doanh nghiệp đã tin dùng NovaHRM.<br>Đến lượt bạn trải nghiệm sự khác biệt.',
        'btn_demo'  => 'Đăng ký Demo miễn phí',
        'btn_login' => 'Đăng nhập',
    ],

    'clients' => [
        'label' => 'doanh nghiệp đã tin dùng NovaHRM',
    ],

    'features' => [
        'eyebrow'    => 'Tính năng nổi bật',
        'title'      => 'Một nền tảng <span class="feat-divider">|</span> <span class="feat-glow-text">Mọi giải pháp</span>',
        'btn_detail' => 'Xem chi tiết',
        'btn_demo'   => 'Demo tính năng',

        'slides' => [
            'hrm' => [
                'tag'   => 'QUẢN LÝ NHÂN SỰ',
                'title' => 'Quản trị nhân viên toàn diện, hồ sơ đầy đủ',
                'items' => [
                    0 => 'Hồ sơ nhân viên đầy đủ, hợp đồng lao động số',
                    1 => 'Phân quyền vai trò Admin, HR, Trưởng phòng',
                    2 => 'Theo dõi lịch sử công việc và hiệu suất',
                ],
                'preview' => [
                    'header'     => 'Danh sách nhân viên',
                    'count'      => '1,248 người',
                    'col_name'   => 'Họ tên',
                    'col_dept'   => 'Phòng ban',
                    'col_status' => 'Trạng thái',
                    'rows' => [
                        ['abbr' => 'BH', 'name' => 'Bùi Mạnh Hưng',    'bg' => 'linear-gradient(135deg,#1565C0,#60A5FA)', 'dept' => 'Kỹ thuật',  'status' => 'Đang làm', 'badge' => 'badge-green'],
                        ['abbr' => 'TX', 'name' => 'Trần Xuân Huyền',   'bg' => 'linear-gradient(135deg,#7c3aed,#a78bfa)', 'dept' => 'Marketing', 'status' => 'Nghỉ phép','badge' => 'badge-blue'],
                        ['abbr' => 'NA', 'name' => 'Nguyễn Ngọc Anh',   'bg' => 'linear-gradient(135deg,#065f46,#22c55e)', 'dept' => 'Kinh doanh','status' => 'Tăng ca',  'badge' => 'badge-orange'],
                        ['abbr' => 'PA', 'name' => 'Bùi Phương Anh',    'bg' => 'linear-gradient(135deg,#1e3a5f,#2196F3)', 'dept' => 'Kế toán',  'status' => 'Đang làm', 'badge' => 'badge-green'],
                    ],
                ],
            ],

            'attendance' => [
                'tag'   => 'CHẤM CÔNG & LỊCH LÀM',
                'title' => 'Theo dõi giờ làm chính xác, tăng ca tự động',
                'items' => [
                    0 => 'Chấm công qua app, QR code, khuôn mặt',
                    1 => 'Quản lý ca làm, lịch trực theo phòng ban',
                    2 => 'Báo cáo tổng hợp theo tuần, tháng, quý',
                ],
                'preview' => [
                    'header' => 'Biểu đồ chấm công tuần này',
                    'rate'   => '98.4% đúng giờ',
                    'bars'   => [
                        ['label' => 'T2', 'height' => '65%',  'active' => false],
                        ['label' => 'T3', 'height' => '80%',  'active' => false],
                        ['label' => 'T4', 'height' => '70%',  'active' => false],
                        ['label' => 'T5', 'height' => '100%', 'active' => true],
                        ['label' => 'T6', 'height' => '85%',  'active' => false],
                        ['label' => 'T7', 'height' => '50%',  'active' => false, 'opacity' => 'opacity:0.5'],
                    ],
                    'stats' => [
                        ['label' => 'Đúng giờ', 'value' => '1,228', 'color' => '#22c55e', 'bg' => 'rgba(34,197,94,0.08)',  'border' => 'rgba(34,197,94,0.2)'],
                        ['label' => 'Trễ giờ',  'value' => '14',    'color' => '#fb923c', 'bg' => 'rgba(251,146,60,0.08)', 'border' => 'rgba(251,146,60,0.2)'],
                        ['label' => 'Tăng ca',  'value' => '38',    'color' => 'var(--accent)', 'bg' => 'rgba(96,165,250,0.08)', 'border' => 'rgba(96,165,250,0.2)'],
                    ],
                ],
            ],

            'payroll' => [
                'tag'   => 'TÍNH LƯƠNG TỰ ĐỘNG',
                'title' => 'Tính lương chính xác, xuất phiếu lương PDF',
                'items' => [
                    0 => 'Tính lương, thưởng, phụ cấp tự động',
                    1 => 'Xuất phiếu lương PDF chuyên nghiệp',
                    2 => 'Tự động khấu trừ BHXH, thuế TNCN',
                ],
                'preview' => [
                    'header'      => 'Bảng lương tháng 4/2026',
                    'status'      => '✓ Đã duyệt',
                    'col_name'    => 'Nhân viên',
                    'col_basic'   => 'Lương cơ bản',
                    'col_net'     => 'Thực lãnh',
                    'total_label' => 'Tổng chi lương tháng này',
                    'total_val'   => '4.2 <span style="color:var(--accent)">tỷ</span>',
                    'rows' => [
                        ['abbr' => 'BH', 'name' => 'Bùi Mạnh Hưng',  'bg' => 'linear-gradient(135deg,#1565C0,#60A5FA)', 'basic' => '18,000,000', 'net' => '21,500,000'],
                        ['abbr' => 'TX', 'name' => 'Trần Xuân Huyền', 'bg' => 'linear-gradient(135deg,#7c3aed,#a78bfa)', 'basic' => '15,000,000', 'net' => '15,000,000'],
                        ['abbr' => 'NA', 'name' => 'Nguyễn Ngọc Anh', 'bg' => 'linear-gradient(135deg,#065f46,#22c55e)', 'basic' => '20,000,000', 'net' => '26,800,000'],
                    ],
                ],
            ],

            'reports' => [
                'tag'   => 'BÁO CÁO & THỐNG KÊ',
                'title' => 'Dashboard trực quan, báo cáo chi tiết realtime',
                'items' => [
                    0 => 'Dashboard tổng hợp theo phòng ban, thời gian',
                    1 => 'Xuất báo cáo Excel, PDF chỉ 1 click',
                    2 => 'Cảnh báo thông minh, nhắc nhở tự động',
                ],
                'preview' => [
                    'header' => 'Tổng quan hiệu suất',
                    'period' => 'Tháng 4/2026',
                    'stats'  => [
                        ['label' => 'Chấm công đúng giờ',  'value' => '98.4%', 'color' => '#22c55e',      'bg' => 'rgba(34,197,94,0.08)',   'border' => 'rgba(34,197,94,0.2)',   'pct' => '98%'],
                        ['label' => 'Xử lý lương chính xác','value' => '99.1%', 'color' => 'var(--accent)','bg' => 'rgba(96,165,250,0.08)',  'border' => 'rgba(96,165,250,0.2)',  'pct' => '99%'],
                        ['label' => 'Nhân viên active',     'value' => '50k+',  'color' => '#a78bfa',      'bg' => 'rgba(167,139,250,0.08)', 'border' => 'rgba(167,139,250,0.2)', 'pct' => '85%'],
                        ['label' => 'Uptime hệ thống',      'value' => '99.9%', 'color' => '#fb923c',      'bg' => 'rgba(251,146,60,0.08)',  'border' => 'rgba(251,146,60,0.2)',  'pct' => '99%'],
                    ],
                ],
            ],
        ],
    ],

    'ai' => [
        'title'    => 'Thông tin <span>tức thời</span> <span class="ai-title-divider">|</span> quyết định <span>chính xác</span>',
        'badge'    => '✦ Nova AI Coming Soon',
        'greeting' => 'Hey <span>Nova AI</span>',

        'chat_items' => [
            [
                'text' => 'Có đề xuất nào đang cần phê duyệt không?',
                'icon' => '<svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
            ],
            [
                'text' => 'Tóm tắt công việc của team tôi trong tuần này',
                'icon' => '<svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>',
            ],
            [
                'text' => 'Tình hình tài chính của công ty, doanh thu và chi phí có đang đi theo kế hoạch không?',
                'icon' => '<svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
            ],
            [
                'text' => 'Hôm nay tôi có những cuộc họp nào quan trọng?',
                'icon' => '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
            ],
        ],

        'results' => [
            0 => [
                'title'   => 'Đề xuất cần phê duyệt',
                'summary' => 'Hiện tại bạn có <strong>9 đề xuất</strong> cần phê duyệt:',
                'rows' => [
                    ['color' => '#f59e0b', 'text' => '<strong style="color:#fbbf24">3 đề xuất</strong> được gắn dấu sao'],
                    ['color' => '#ef4444', 'text' => '<strong style="color:#f87171">3 đề xuất</strong> quá hạn'],
                    ['color' => '#fb923c', 'text' => '<strong style="color:#fb923c">2 đề xuất</strong> có thời hạn dưới 1 ngày'],
                    ['color' => '#60A5FA', 'text' => '<strong style="color:#93c5fd">5 đề xuất</strong> đã được cấp dưới của bạn phê duyệt và bạn là người duyệt cuối cùng'],
                    ['color' => '#34d399', 'text' => '<strong style="color:#6ee7b7">3 đề xuất</strong> liên quan đến phê duyệt chi phí — khoản tiền ra cần bạn phê duyệt để có thể tiếp tục dự án'],
                ],
            ],
            // Thêm result cho các chat_item 1, 2, 3 tương tự khi cần
        ],
    ],
];