@extends('nova-dashboard::layouts')
@section('title', 'Dashboard — NovaHRM')
@section('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Dashboard/src/resources/js/app.js',
    ])
@endsection
@section('content')

    {{-- Topbar 2 hàng --}}
    <header class="topbar">
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
        <div class="topbar-tabs">
            <div class="topbar-tab active">NHÂN VIÊN</div>
            <div class="topbar-tabs">
                <div class="topbar-tab active">NHÂN VIÊN</div>
                <a href="{{ route('org-chart.index') }}" class="topbar-tab">SƠ ĐỒ TỔ CHỨC</a>
                <div class="topbar-tab">ỨNG DỤNG HRM</div>
            </div>
            <div class="topbar-tab">ỨNG DỤNG HRM</div>
        </div>
    </header>

    {{-- Page body --}}
    <div class="page-body">

        <div class="charts-row">
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
                <div class="chart-canvas-wrap"><canvas id="chart1"></canvas></div>
            </div>
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
                <div class="chart-canvas-wrap"><canvas id="chart2"></canvas></div>
            </div>
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
                <div class="chart-canvas-wrap"><canvas id="chart3"></canvas></div>
            </div>
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
                <div class="chart-canvas-wrap"><canvas id="chart4"></canvas></div>
            </div>
        </div>

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
                        <th><div class="th-inner">Khu vực<svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg></div></th>
                        <th><div class="th-inner">Văn phòng<svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg></div></th>
                        <th><div class="th-inner">Vị trí<svg viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg></div></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#6366f1">NT</div>Nguyễn Phương Ta</div></td>
                        <td><span class="emp-code">NNV-000</span></td>
                        <td><span class="status-dot dot-gray"></span></td>
                        <td>Admin</td><td>—</td>
                        <td><span class="badge badge-blue">Sales</span></td>
                        <td>HCM Office</td><td>—</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#0891b2">LA</div>Lưu Phương Anh</div></td>
                        <td><span class="emp-code">NNV-001</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>BA</td><td>—</td>
                        <td><span class="badge badge-blue">Sales</span></td>
                        <td>Hà Nội Office</td><td>—</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#7c3aed">VP</div>Vũ Phương</div></td>
                        <td><span class="emp-code">NNV-001</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>Developer</td><td>—</td>
                        <td><span class="badge badge-purple">Product</span></td>
                        <td>HCM Office</td><td>—</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#0f766e">LH</div>Lương Đỗ Hà</div></td>
                        <td><span class="emp-code">NNV-002</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>CEO</td><td>—</td>
                        <td><span class="badge badge-purple">Product</span></td>
                        <td>Hà Nội Office</td><td>—</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#b45309">LS</div>Lê Song Trúc</div></td>
                        <td><span class="emp-code">NNV-002</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>CMO</td><td>—</td>
                        <td><span class="badge badge-green">Marketing</span></td>
                        <td>Hà Nội Office</td>
                        <td><span class="badge badge-green">CMO</span></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#be185d">BT</div>Bùi Thanh Tâm</div></td>
                        <td><span class="emp-code">NNV-003</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>Trưởng nhóm kinh doanh</td><td>—</td>
                        <td><span class="badge badge-blue">Sales</span></td>
                        <td>Đà Nẵng Office</td><td>—</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#1d4ed8">HM</div>Huỳnh Minh Phúc</div></td>
                        <td><span class="emp-code">NNV-004</span></td>
                        <td><span class="status-dot dot-red"></span></td>
                        <td>Trưởng phòng Marketing</td><td>—</td>
                        <td><span class="badge badge-green">Marketing</span></td>
                        <td>HCM Office</td>
                        <td><span class="badge badge-green">Trưởng phòng MKT</span></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#065f46">TB</div>Trần Bá Thần</div></td>
                        <td><span class="emp-code">NNV-005</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>Trưởng phòng kinh doanh</td><td>—</td>
                        <td><span class="badge badge-blue">Sales</span></td>
                        <td>HCM Office</td>
                        <td><span class="badge badge-blue">Trưởng phòng KD</span></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#7e22ce">TH</div>Trần Thị Tuyết Hồng</div></td>
                        <td><span class="emp-code">NNV-006</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>Trưởng phòng CSKH</td><td>—</td>
                        <td><span class="badge badge-amber">Customer Success</span></td>
                        <td>Hà Nội Office</td>
                        <td><span class="badge badge-amber">Trưởng phòng CSKH</span></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" style="width:13px;height:13px;cursor:pointer"/></td>
                        <td><div class="emp-name"><div class="emp-av" style="background:#0369a1">LL</div>Lê Văn Liêm</div></td>
                        <td><span class="emp-code">NNV-007</span></td>
                        <td><span class="status-dot dot-green"></span></td>
                        <td>Trưởng phòng HCNS</td><td>—</td>
                        <td><span class="badge badge-red">Back Office</span></td>
                        <td>Đà Nẵng Office</td>
                        <td><span class="badge badge-red">Trưởng phòng HCNS</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection