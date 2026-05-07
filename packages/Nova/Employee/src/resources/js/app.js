import QrScanner from 'qr-scanner';

// Biến trạng thái 
let cccdReader   = null;
let cccdScanning = false;
let torchOn      = false;

// Expose ra window để blade gọi được 
window.switchCccdMode = function(mode) {
    const isManual = mode === 'manual';
    document.getElementById('cccd-btn-manual').style.background = isManual ? '#1d4ed8' : 'transparent';
    document.getElementById('cccd-btn-manual').style.color      = isManual ? '#fff'    : '#64748b';
    document.getElementById('cccd-btn-scan').style.background   = !isManual ? '#1d4ed8' : 'transparent';
    document.getElementById('cccd-btn-scan').style.color        = !isManual ? '#fff'    : '#64748b';
    document.getElementById('cccd-manual-panel').style.display  = isManual ? '' : 'none';
    document.getElementById('cccd-scan-panel').style.display    = !isManual ? '' : 'none';
    if (isManual) window.stopCccdScan();
}

window.startCccdScan = async function() {
    document.getElementById('cccd-camera-wrap').style.display = '';
    document.getElementById('cccd-start-btn').style.display   = 'none';
    document.getElementById('cccd-stop-btn').style.display    = '';
    document.getElementById('cccd-torch-btn').style.display   = '';
    document.getElementById('cccd-scan-status').innerHTML =
        '<span style="color:#1d4ed8">🔍 Đang quét... giữ thẳng và cách QR ~15cm</span>';

    const video = document.getElementById('cccd-video');

    try {
        cccdReader = new QrScanner(video, result => {
            if (!cccdScanning) return;
            console.log('QR raw:', result.data);
            cccdScanning = false;
            window.stopCccdScan();
            window.parseCccdQR(result.data);
        }, {
            highlightScanRegion: true,
            highlightCodeOutline: true,
        });

        cccdScanning = true;
        await cccdReader.start();

    } catch(e) {
        console.error(e);
        document.getElementById('cccd-scan-status').innerHTML =
            '<span style="color:#ef4444">Không mở được camera. Thử upload ảnh QR.</span>';
        window.stopCccdScan();
    }
}

window.stopCccdScan = function() {
    cccdScanning = false;
    cccdReader?.stop();
    cccdReader?.destroy();
    cccdReader = null;
    torchOn = false;

    document.getElementById('cccd-camera-wrap').style.display = 'none';
    document.getElementById('cccd-start-btn').style.display   = '';
    document.getElementById('cccd-stop-btn').style.display    = 'none';
    const torchBtn = document.getElementById('cccd-torch-btn');
    if (torchBtn) torchBtn.style.display = 'none';
    document.getElementById('cccd-scan-status').innerHTML =
        'Hướng camera vào mã QR trên CCCD để tự động điền thông tin';
}

window.toggleTorch = async function() {
    if (!cccdReader) return;
    try {
        torchOn = !torchOn;
        await cccdReader.toggleFlash();
        document.getElementById('cccd-torch-btn').style.background = torchOn ? '#fbbf24' : '#f1f5f9';
        document.getElementById('cccd-torch-btn').style.color      = torchOn ? '#78350f' : '#475569';
    } catch(e) { /* không hỗ trợ */ }
}

window.scanCccdFromFile = async function(input) {
    const file = input.files[0];
    if (!file) return;
    document.getElementById('cccd-scan-status').innerHTML =
        '<span style="color:#1d4ed8">Đang phân tích ảnh...</span>';

    try {
        const result = await QrScanner.scanImage(file, { returnDetailedScanResult: true });
        console.log('QR raw:', result.data);
        window.parseCccdQR(result.data);
    } catch(e) {
        console.error(e);
        document.getElementById('cccd-scan-status').innerHTML =
            '<span style="color:#ef4444">Không đọc được QR. Chụp rõ hơn, đủ sáng nhé.</span>';
    }
}

window.parseCccdQR = function(raw) {
    const parts = raw.split('|');
    const cccdNo    = parts[0]?.trim() || '';
    const fullName  = parts[1]?.trim() || '';
    const dob       = parts[2]?.trim() || '';
    const gender    = parts[3]?.trim() || '';
    const hometown  = parts[4]?.trim() || '';
    const issueDate = parts[5]?.trim() || '';

    if (cccdNo) {
        const el = document.getElementById('field-national-id');
        if (el) el.value = cccdNo;
    }
    if (issueDate) {
        const el = document.getElementById('field-issued-date');
        if (el) el.value = formatDateToInput(issueDate);
    }
    if (fullName) {
        const nameParts = fullName.trim().split(' ');
        const lastName  = nameParts.pop() || '';
        const firstName = nameParts.join(' ') || '';
        const firstEl = document.querySelector('[name="first_name"]');
        const lastEl  = document.querySelector('[name="last_name"]');
        if (firstEl) firstEl.value = firstName;
        if (lastEl)  lastEl.value  = lastName;
    }
    if (dob) {
        const dobEl = document.querySelector('[name="date_of_birth"]');
        if (dobEl) dobEl.value = formatDateToInput(dob);
    }
    if (gender) {
        const genderEl = document.querySelector('[name="gender"]');
        if (genderEl) {
            const map = { 'Nam': 'male', 'Nữ': 'female', 'nu': 'female', 'nam': 'male' };
            genderEl.value = map[gender] || gender.toLowerCase();
        }
    }
    if (hometown) {
        const pobEl = document.querySelector('[name="place_of_birth"]');
        if (pobEl) pobEl.value = hometown;
    }

    document.getElementById('cccd-result-box').style.display = '';
    document.getElementById('cccd-result-text').innerHTML = [
        cccdNo    ? `Số CCCD: <b>${cccdNo}</b>`    : '',
        fullName  ? `Họ tên: <b>${fullName}</b>`    : '',
        dob       ? `Ngày sinh: <b>${dob}</b>`      : '',
        gender    ? `Giới tính: <b>${gender}</b>`   : '',
        hometown  ? `Quê quán: <b>${hometown}</b>`  : '',
        issueDate ? `Ngày cấp: <b>${issueDate}</b>` : '',
    ].filter(Boolean).join('<br>');

    document.getElementById('cccd-scan-status').innerHTML =
        '<span style="color:#16a34a">✓ Quét thành công!</span>';

    window.switchCccdMode('manual');
}

function formatDateToInput(dateStr) {
    const p = dateStr.split('/');
    if (p.length === 3) return `${p[2]}-${p[1].padStart(2,'0')}-${p[0].padStart(2,'0')}`;
    return '';
}