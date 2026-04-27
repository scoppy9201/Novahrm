<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — NovaHRM</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:400,500,600,700,800,900" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Dashboard/src/resources/js/app.js',
    ])
</head>
<body>

<div class="hrm-layout">
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>
            <span class="logo-text">Nova<span>HRM</span></span>
        </div>

        <nav class="sidebar-nav">
            <a href="#" class="sidebar-item active" title="Bảng điều khiển">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                <span class="sidebar-item-label">Bảng điều khiển</span>
            </a>
            <a href="#" class="sidebar-item" title="Nhân viên">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="sidebar-item-label">Nhân viên</span>
            </a>
            <a href="#" class="sidebar-item" title="Sơ đồ tổ chức">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="5" r="2"/><circle cx="5" cy="19" r="2"/><circle cx="19" cy="19" r="2"/><line x1="12" y1="7" x2="12" y2="13"/><line x1="12" y1="13" x2="5" y2="17"/><line x1="12" y1="13" x2="19" y2="17"/></svg>
                <span class="sidebar-item-label">Sơ đồ tổ chức</span>
            </a>
            <a href="#" class="sidebar-item" title="Vị trí & Phòng ban">
                <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                <span class="sidebar-item-label">Vị trí & Phòng ban</span>
            </a>
            <a href="#" class="sidebar-item" title="Tài liệu">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span class="sidebar-item-label">Tài liệu</span>
            </a>
            <a href="#" class="sidebar-item" title="Chấm công">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span class="sidebar-item-label">Chấm công</span>
            </a>
            <a href="#" class="sidebar-item" title="Bảng lương">
                <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <span class="sidebar-item-label">Bảng lương</span>
            </a>
            <a href="#" class="sidebar-item" title="Tuyển dụng">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span class="sidebar-item-label">Tuyển dụng</span>
            </a>
            <a href="#" class="sidebar-item" title="Đào tạo">
                <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                <span class="sidebar-item-label">Đào tạo</span>
            </a>
            <a href="#" class="sidebar-item" title="Chính sách">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span class="sidebar-item-label">Chính sách</span>
            </a>
            <a href="#" class="sidebar-item" title="Cài đặt">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                <span class="sidebar-item-label">Cài đặt</span>
            </a>
        </nav>

        <div class="sidebar-avatar-btn" id="sidebar-avatar-btn">
            <div class="av-circle">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="av-info">
                <div class="av-name">{{ Auth::user()->name }}</div>
                <div class="av-role">{{ Auth::user()->role ?? 'Quản trị viên' }}</div>
            </div>
        </div>
                <div class="user-menu" id="user-menu">
            <a href="/profile" class="user-menu-item">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Thông tin cá nhân
            </a>
            <a href="/logout" class="user-menu-item danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Đăng xuất
            </a>
        </div>
        <form id="logout-form" action="/logout" method="POST" style="display:none">
            @csrf
        </form>
        <button class="sidebar-toggle" id="sidebar-toggle" type="button">
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>

    </aside>

    <div class="hrm-main">

        {{-- Topbar 2 hàng --}}
        <header class="topbar">
            {{-- Hàng 1: Tiêu đề + actions --}}
            <div class="topbar-row1">
                <div class="topbar-title">Nhân viên</div>
                <div class="topbar-actions">
                    <div class="topbar-search">
                        <svg viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" placeholder="Tìm tên, văn phòng, vị trí..."/>
                    </div>
                    <button class="btn-icon" title="Thông báo">
                        <svg viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                    </button>
                    <button class="btn-primary" type="button">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Thêm nhân viên
                    </button>
                </div>
            </div>
            {{-- Hàng 2: Tabs --}}
            <div class="topbar-tabs">
                <div class="topbar-tab active">NHÂN VIÊN</div>
                <div class="topbar-tab">SƠ ĐỒ TỔ CHỨC</div>
                <div class="topbar-tab">ỨNG DỤNG HRM</div>
            </div>
        </header>

        {{-- Page body --}}
        <div class="page-body">

            {{-- Chart cards --}}
            <div class="charts-row">

                {{-- Card 1: Tổng nhân viên - Bar chart --}}
                <div class="chart-card">
                    <div class="chart-card-top">
                        <div class="chart-card-info">
                            <div class="chart-label">Tổng nhân viên</div>
                            <div class="chart-val">1,284</div>
                            <div class="chart-tag tag-green">↑ +12 hôm nay</div>
                        </div>
                        <div class="chart-icon icon-green">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="chart1"></canvas>
                    </div>
                </div>

                {{-- Card 2: Đang hoạt động - Line chart --}}
                <div class="chart-card">
                    <div class="chart-card-top">
                        <div class="chart-card-info">
                            <div class="chart-label">Đang hoạt động</div>
                            <div class="chart-val">1,247</div>
                            <div class="chart-tag tag-blue">97.1% tỷ lệ</div>
                        </div>
                        <div class="chart-icon icon-blue">
                            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>

                {{-- Card 3: Chấm công - Doughnut --}}
                <div class="chart-card">
                    <div class="chart-card-top">
                        <div class="chart-card-info">
                            <div class="chart-label">Chấm công hôm nay</div>
                            <div class="chart-val">96.4%</div>
                            <div class="chart-tag tag-green">● Đúng giờ</div>
                        </div>
                        <div class="chart-icon icon-amber">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="chart3"></canvas>
                    </div>
                </div>

                {{-- Card 4: Lương - Bar --}}
                <div class="chart-card">
                    <div class="chart-card-top">
                        <div class="chart-card-info">
                            <div class="chart-label">Lương tháng này</div>
                            <div class="chart-val">2.4 tỷ</div>
                            <div class="chart-tag tag-amber">↑ Đã xử lý</div>
                        </div>
                        <div class="chart-icon icon-purple">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="chart4"></canvas>
                    </div>
                </div>

            </div>

            {{-- Sub tabs --}}
            <div class="sub-tabs-bar">
                <div class="sub-tab active">TỔNG QUAN</div>
                <div class="sub-tab">LƯƠNG & THĂNG CHỨC</div>
                <div class="sub-tab">ĐỀ XUẤT</div>
                <div class="sub-tab">NHÓM & QUẢN LÝ</div>
                <div class="sub-tab">THUẾ & PHÁP LÝ</div>
                <div class="sub-tab">GIỜ LÀM & CHẤM CÔNG</div>
                <div class="sub-tab">LIÊN HỆ & CÁ NHÂN</div>
                <div class="sub-tab">THỬ VIỆC</div>
                <div class="sub-tab">ĐANG NGHỈ PHÉP</div>
                <div class="sub-tab danger">NGHỈ VIỆC</div>
                <div class="sub-tab">DỮ LIỆU THÔ</div>
            </div>

            {{-- Table --}}
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:36px"><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></th>
                            <th>Nhân viên</th>
                            <th>Mã NV</th>
                            <th>Trạng thái</th>
                            <th>Chức danh</th>
                            <th>Quản lý</th>
                            <th>
                                <div class="th-inner">
                                    Khu vực
                                    <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                                </div>
                            </th>
                            <th>
                                <div class="th-inner">
                                    Văn phòng
                                    <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                                </div>
                            </th>
                            <th>
                                <div class="th-inner">
                                    Vị trí
                                    <svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#6366f1">NT</div>Nguyễn Phương Ta</div></td>
                            <td><span class="emp-code">NNV-000</span></td>
                            <td><span class="status-dot dot-gray"></span></td>
                            <td>Admin</td>
                            <td>—</td>
                            <td><span class="badge badge-blue">Sales</span></td>
                            <td>HCM Office</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#0891b2">LA</div>Lưu Phương Anh</div></td>
                            <td><span class="emp-code">NNV-001</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>BA</td>
                            <td>—</td>
                            <td><span class="badge badge-blue">Sales</span></td>
                            <td>Hà Nội Office</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#7c3aed">VP</div>Vũ Phương</div></td>
                            <td><span class="emp-code">NNV-001</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>Developer</td>
                            <td>—</td>
                            <td><span class="badge badge-purple">Product</span></td>
                            <td>HCM Office</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#0f766e">LH</div>Lương Đỗ Hà</div></td>
                            <td><span class="emp-code">NNV-002</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>CEO</td>
                            <td>—</td>
                            <td><span class="badge badge-purple">Product</span></td>
                            <td>Hà Nội Office</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#b45309">LS</div>Lê Song Trúc</div></td>
                            <td><span class="emp-code">NNV-002</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>CMO</td>
                            <td>—</td>
                            <td><span class="badge badge-green">Marketing</span></td>
                            <td>Hà Nội Office</td>
                            <td><span class="badge badge-green">CMO</span></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#be185d">BT</div>Bùi Thanh Tâm</div></td>
                            <td><span class="emp-code">NNV-003</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>Trưởng nhóm kinh doanh</td>
                            <td>—</td>
                            <td><span class="badge badge-blue">Sales</span></td>
                            <td>Đà Nẵng Office</td>
                            <td>—</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#1d4ed8">HM</div>Huỳnh Minh Phúc</div></td>
                            <td><span class="emp-code">NNV-004</span></td>
                            <td><span class="status-dot dot-red"></span></td>
                            <td>Trưởng phòng Marketing</td>
                            <td>—</td>
                            <td><span class="badge badge-green">Marketing</span></td>
                            <td>HCM Office</td>
                            <td><span class="badge badge-green">Trưởng phòng MKT</span></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#065f46">TB</div>Trần Bá Thần</div></td>
                            <td><span class="emp-code">NNV-005</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>Trưởng phòng kinh doanh</td>
                            <td>—</td>
                            <td><span class="badge badge-blue">Sales</span></td>
                            <td>HCM Office</td>
                            <td><span class="badge badge-blue">Trưởng phòng KD</span></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#7e22ce">TH</div>Trần Thị Tuyết Hồng</div></td>
                            <td><span class="emp-code">NNV-006</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>Trưởng phòng CSKH</td>
                            <td>—</td>
                            <td><span class="badge badge-amber">Customer Success</span></td>
                            <td>Hà Nội Office</td>
                            <td><span class="badge badge-amber">Trưởng phòng CSKH</span></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                            <td><div class="emp-name"><div class="emp-av" style="background:#0369a1">LL</div>Lê Văn Liêm</div></td>
                            <td><span class="emp-code">NNV-007</span></td>
                            <td><span class="status-dot dot-green"></span></td>
                            <td>Trưởng phòng HCNS</td>
                            <td>—</td>
                            <td><span class="badge badge-red">Back Office</span></td>
                            <td>Đà Nẵng Office</td>
                            <td><span class="badge badge-red">Trưởng phòng HCNS</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>