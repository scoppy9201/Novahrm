function switchTab(tabId) {
    document.querySelectorAll('.emp-tab[data-tab]').forEach(t =>
        t.classList.toggle('active', t.dataset.tab === tabId)
    );
    document.querySelectorAll('.emp-tab-panel').forEach(p => {
        if (p.id === tabId) {
            p.style.display = 'flex';
            p.style.flexDirection = 'column';
        } else {
            p.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Tab switching 
    const tabs   = document.querySelectorAll('.emp-tab[data-tab]');
    const panels = document.querySelectorAll('.emp-tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', e => {
            e.preventDefault();
            switchTab(tab.dataset.tab);
        });
    });

    // Default tab
    switchTab('tab-personal');

    // Avatar preview 
    const avatarInput = document.getElementById('avatar-input');
    const avPreview   = document.getElementById('av-preview');

    avatarInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            avPreview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%"/>`;
        };
        reader.readAsDataURL(file);
    });

    // Same address toggle 
    const sameAddr   = document.getElementById('same-address');
    const curFields  = document.getElementById('current-address-fields');

    sameAddr?.addEventListener('change', function () {
        if (this.checked) {
            curFields.style.display = 'none';
            // Copy values
            curFields.querySelectorAll('input').forEach(input => {
                const permName = input.name.replace('current_', 'permanent_');
                const permInput = document.querySelector(`[name="${permName}"]`);
                if (permInput) input.value = permInput.value;
            });
        } else {
            curFields.style.display = 'block';
        }
    });

    // Salary format preview 
    const salaryInput   = document.getElementById('salary-input');
    const salaryPreview = document.getElementById('salary-preview');

    salaryInput?.addEventListener('input', function () {
        const val = parseInt(this.value);
        if (!val || isNaN(val)) {
            salaryPreview.textContent = '—';
            return;
        }
        salaryPreview.textContent = val.toLocaleString('vi-VN') + ' ₫';
    });

    // Autocomplete manager 
    const managerSearch   = document.getElementById('manager-search');
    const managerIdInput  = document.getElementById('manager-id-input');
    const managerDropdown = document.getElementById('manager-dropdown');

    let managerTimer;

    managerSearch?.addEventListener('input', function () {
        const q = this.value.trim();
        if (q.length < 2) {
            managerDropdown.classList.remove('open');
            return;
        }
        clearTimeout(managerTimer);
        managerTimer = setTimeout(async () => {
            try {
                const res  = await fetch(`{{ route('hr.employees.search') }}?q=${encodeURIComponent(q)}`);
                const data = await res.json();

                if (!data.length) {
                    managerDropdown.innerHTML = `<div style="padding:12px 14px;font-size:12px;color:#94a3b8">Không tìm thấy</div>`;
                } else {
                    managerDropdown.innerHTML = data.map(e => `
                        <div class="emp-autocomplete-item" data-id="${e.id}" data-name="${e.name}">
                            <img src="${e.avatar}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0" onerror="this.style.display='none'"/>
                            <div>
                                <div class="emp-autocomplete-item-name">${e.name}</div>
                                <div class="emp-autocomplete-item-sub">${e.position || ''} ${e.department ? '· ' + e.department : ''}</div>
                            </div>
                        </div>
                    `).join('');
                }
                managerDropdown.classList.add('open');

                // Click item
                managerDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
                    item.addEventListener('click', () => {
                        managerSearch.value  = item.dataset.name;
                        managerIdInput.value = item.dataset.id;
                        managerDropdown.classList.remove('open');
                    });
                });

            } catch (e) {
                console.error(e);
            }
        }, 300);
    });

    // Đóng dropdown khi click ngoài
    document.addEventListener('click', e => {
        if (!e.target.closest('.emp-autocomplete')) {
            managerDropdown.classList.remove('open');
        }
    });

    // Keyboard navigation autocomplete 
    managerSearch?.addEventListener('keydown', function (e) {
        const items = managerDropdown.querySelectorAll('.emp-autocomplete-item');
        const focused = managerDropdown.querySelector('.focused');
        let idx = Array.from(items).indexOf(focused);

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            focused?.classList.remove('focused');
            items[Math.min(idx + 1, items.length - 1)]?.classList.add('focused');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            focused?.classList.remove('focused');
            items[Math.max(idx - 1, 0)]?.classList.add('focused');
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (focused) focused.click();
        } else if (e.key === 'Escape') {
            managerDropdown.classList.remove('open');
        }
    });
});

const addrDataNew  = window.EMP_DATA.provincesNew;
const addrDataOld  = window.EMP_DATA.provincesOld;
let currentAddrVersion = 'new';

function switchAddrVersion(ver) {
    currentAddrVersion = ver;

    document.getElementById('addr-btn-new').style.background = ver === 'new' ? '#1d4ed8' : 'transparent';
    document.getElementById('addr-btn-new').style.color      = ver === 'new' ? '#fff'    : '#64748b';
    document.getElementById('addr-btn-old').style.background = ver === 'old' ? '#1d4ed8' : 'transparent';
    document.getElementById('addr-btn-old').style.color      = ver === 'old' ? '#fff'    : '#64748b';

    const badge = document.getElementById('addr-version-badge');
    badge.textContent  = ver === 'new' ? '2 cấp: Tỉnh → Xã' : '3 cấp: Tỉnh → Huyện → Xã';
    badge.style.background  = ver === 'new' ? '#eff6ff' : '#fefce8';
    badge.style.color       = ver === 'new' ? '#1d4ed8' : '#854d0e';
    badge.style.borderColor = ver === 'new' ? '#bfdbfe' : '#fde68a';

    // Hiện/ẩn ô Quận/Huyện
    document.querySelectorAll('.addr-district-row').forEach(el => {
        el.style.display = ver === 'old' ? '' : 'none';
    });

    // Reset + render lại cả 2
    ['permanent', 'current'].forEach(prefix => {
        resetAddr(prefix);
        renderProvinces(prefix);
    });
}

function renderProvinces(prefix) {
    const sel = document.querySelector(`.addr-province-sel[data-prefix="${prefix}"]`);
    if (!sel) return;
    sel.innerHTML = '<option value="">— Chọn tỉnh/thành —</option>';

    if (currentAddrVersion === 'new') {
        addrDataNew.forEach(p => {
            const o = new Option(p.FullName || p.Name, p.Name);
            o.dataset.code = p.Code;
            sel.appendChild(o);
        });
    } else {
        // bộ cũ: level1_id, name
        addrDataOld.forEach(p => {
            const o = new Option(p.name, p.name);
            o.dataset.code = p.level1_id;
            sel.appendChild(o);
        });
    }
}

function onProvinceChange(sel) {
    const prefix = sel.dataset.prefix;
    const opt    = sel.options[sel.selectedIndex];
    const code   = opt?.dataset?.code || '';
    const name   = opt?.value || '';

    document.querySelector(`.addr-province-val[data-prefix="${prefix}"]`).value = name;
    document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = '';

    // Reset district input
    const distInp = document.querySelector(`.addr-district-inp[data-prefix="${prefix}"]`);
    if (distInp) distInp.value = '';

    // Reset ward select
    const wardSel = document.querySelector(`.addr-ward-sel[data-prefix="${prefix}"]`);
    wardSel.innerHTML = '<option value="">— Chọn phường/xã —</option>';
    wardSel.disabled  = true;

    if (!code) return;

    if (currentAddrVersion === 'new') {
        // bộ mới: không có huyện, load xã thẳng
        const prov = addrDataNew.find(p => p.Code === code);
        (prov?.Wards || []).forEach(w => {
            const o = new Option(w.FullName || w.Name, w.Name);
            o.dataset.code = w.Code;
            wardSel.appendChild(o);
        });
        wardSel.disabled = wardSel.options.length <= 1;

    } else {
        // bộ cũ: có huyện — render select huyện trước
        const prov = addrDataOld.find(p => p.level1_id === code);
        if (!prov) return;

        // Thay ward select thành district select tạm
        const distRow = document.querySelector(`.addr-district-row[data-prefix="${prefix}"]`);
        if (distRow) {
            // Đổi input thường trú thành select huyện
            const distWrap = distRow.querySelector('.addr-district-inp');
            if (distWrap) distWrap.readOnly = false;

            // Render dropdown huyện vào wardSel tạm — thực ra ta dùng select riêng cho huyện
            // Render huyện vào select huyện
            let distSel = distRow.querySelector('select.addr-district-sel');
            if (!distSel) {
                distSel = document.createElement('select');
                distSel.className = 'emp-select addr-district-sel';
                distSel.dataset.prefix = prefix;
                distSel.style.marginTop = '6px';
                distRow.appendChild(distSel);
            }
            distSel.innerHTML = '<option value="">— Chọn quận/huyện —</option>';
            (prov.level2s || []).forEach(d => {
                const o = new Option(d.name, d.name);
                o.dataset.id = d.level2_id;
                o.dataset.districts = JSON.stringify(d.level3s || []);
                distSel.appendChild(o);
            });

            distSel.onchange = function() {
                const dOpt = this.options[this.selectedIndex];
                if (distInp) distInp.value = dOpt?.value || '';

                // Load xã của huyện vừa chọn
                const level3s = JSON.parse(dOpt?.dataset?.districts || '[]');
                wardSel.innerHTML = '<option value="">— Chọn phường/xã —</option>';
                level3s.forEach(w => {
                    const o = new Option(w.name, w.name);
                    o.dataset.code = w.level3_id;
                    wardSel.appendChild(o);
                });
                wardSel.disabled = level3s.length === 0;
                document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = '';
            };
        }
    }
}

function onWardChange(sel) {
    const prefix = sel.dataset.prefix;
    document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = sel.options[sel.selectedIndex]?.value || '';
}

function resetAddr(prefix) {
    const provSel = document.querySelector(`.addr-province-sel[data-prefix="${prefix}"]`);
    if (provSel) provSel.value = '';
    document.querySelector(`.addr-province-val[data-prefix="${prefix}"]`).value = '';

    const wardSel = document.querySelector(`.addr-ward-sel[data-prefix="${prefix}"]`);
    if (wardSel) { wardSel.innerHTML = '<option value="">— Chọn tỉnh trước —</option>'; wardSel.disabled = true; }
    document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = '';

    const distInp = document.querySelector(`.addr-district-inp[data-prefix="${prefix}"]`);
    if (distInp) distInp.value = '';

    // Xóa select huyện động nếu có
    document.querySelectorAll(`.addr-district-sel[data-prefix="${prefix}"]`).forEach(el => el.remove());
}

// Init
renderProvinces('permanent');
renderProvinces('current');

// Same address
const sameAddr  = document.getElementById('same-address');
const curFields = document.getElementById('current-address-fields');
sameAddr?.addEventListener('change', function () {
    curFields.style.display = this.checked ? 'none' : '';
    if (this.checked) {
        document.querySelector('[name="current_address"]').value =
            document.querySelector('[name="permanent_address"]').value;
        document.querySelector('.addr-province-val[data-prefix="current"]').value =
            document.querySelector('.addr-province-val[data-prefix="permanent"]').value;
        document.querySelector('.addr-ward-val[data-prefix="current"]').value =
            document.querySelector('.addr-ward-val[data-prefix="permanent"]').value;
    }
});

// Validation số điện thoại 
function validatePhone(input, errId) {
    const errEl = document.getElementById(errId);
    if (!errEl) return true;

    // Chỉ cho nhập số
    input.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

    const val = input.value.trim();
    if (!val) { clearErr(input, errEl); return true; } // Không bắt buộc

    if (!/^0\d{9}$/.test(val)) {
        showErr(input, errEl,
            val.length < 10
                ? `Cần đủ 10 chữ số (hiện ${val.length} số)`
                : 'Số điện thoại phải bắt đầu bằng 0 và đủ 10 chữ số'
        );
        return false;
    }
    clearErr(input, errEl);
    return true;
}

// Validation số CCCD 
function validateCccd(input, errId) {
    const errEl = document.getElementById(errId);
    if (!errEl) return true;

    input.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 12);
    });

    const val = input.value.trim();
    if (!val) { clearErr(input, errEl); return true; }

    if (!/^\d{12}$/.test(val)) {
        showErr(input, errEl,
            `CCCD cần đúng 12 chữ số (hiện ${val.length} số)`
        );
        return false;
    }
    clearErr(input, errEl);
    return true;
}

function showErr(input, errEl, msg) {
    input.classList.add('error');
    errEl.textContent = msg;
    errEl.style.display = 'block';
}
function clearErr(input, errEl) {
    input.classList.remove('error');
    errEl.style.display = 'none';
}

// Gắn real-time validation
const phoneInput    = document.getElementById('field-phone');
const phoneAltInput = document.getElementById('field-phone-alt');
const cccdInput     = document.getElementById('field-national-id');

// Chỉ cho nhập số vào các field này
[phoneInput, phoneAltInput, cccdInput].forEach(el => {
    el?.addEventListener('input', function () {
        const maxLen = el === cccdInput ? 12 : 10;
        this.value = this.value.replace(/\D/g, '').slice(0, maxLen);
    });
});

phoneInput?.addEventListener('blur', () => validatePhone(phoneInput, 'err-phone'));
phoneAltInput?.addEventListener('blur', () => validatePhone(phoneAltInput, 'err-phone-alt'));
cccdInput?.addEventListener('blur', () => validateCccd(cccdInput, 'err-cccd'));

// Validate trước khi submit 
document.getElementById('emp-create-form')?.addEventListener('submit', function (e) {
    switchTab('tab-personal');
    const okPhone          = validatePhone(phoneInput,          'err-phone');
    const okPhoneAlt       = validatePhone(phoneAltInput,       'err-phone-alt');
    const okEmergencyPhone = validatePhone(emergencyPhoneInput, 'err-emergency-phone');
    const okCccd           = validateCccd(cccdInput,            'err-cccd');
    const okPassport       = validatePassport(passportInput,    'err-passport');
    const okEmail          = validateGmail(emailInput,          'err-email');          
    const okWorkEmail      = validateGmail(workEmailInput,      'err-work-email');     
    const okWorkEmail2     = validateGmail(workEmailInput2,     'err-work-email-2');   

    if (!okPhone || !okPhoneAlt || !okEmergencyPhone || !okCccd || !okPassport
        || !okEmail || !okWorkEmail || !okWorkEmail2) {
        e.preventDefault();

        // Chuyển đúng tab chứa lỗi đầu tiên
        if (!okEmail || !okWorkEmail || !okPhone || !okPhoneAlt 
            || !okEmergencyPhone || !okCccd || !okPassport) {
            document.querySelector('[data-tab="tab-personal"]')?.click();
        } else if (!okWorkEmail2) {
            document.querySelector('[data-tab="tab-work"]')?.click();
        }

        const firstErr = document.querySelector('.emp-input.error');
        firstErr?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstErr?.focus();
    }
});

// Validation số hộ chiếu 
const passportInput = document.getElementById('field-passport');

// Tự động uppercase + lọc ký tự đặc biệt khi nhập
passportInput?.addEventListener('input', function () {
    const cursor = this.selectionStart;
    this.value = this.value
        .toUpperCase()
        .replace(/[^A-Z0-9]/g, '')  // Chỉ giữ chữ và số
        .slice(0, 20);
    // Giữ vị trí con trỏ
    this.setSelectionRange(cursor, cursor);
});

function validatePassport(input, errId) {
    const errEl = document.getElementById(errId);
    if (!errEl) return true;

    const val = input.value.trim();
    if (!val) { clearErr(input, errEl); return true; } // Không bắt buộc

    if (val.length < 6) {
        showErr(input, errEl, `Số hộ chiếu quá ngắn (tối thiểu 6 ký tự, hiện ${val.length})`);
        return false;
    }
    if (!/^[A-Z0-9]{6,20}$/.test(val)) {
        showErr(input, errEl, 'Số hộ chiếu chỉ được chứa chữ cái và chữ số');
        return false;
    }
    clearErr(input, errEl);
    return true;
}

passportInput?.addEventListener('blur', () => validatePassport(passportInput, 'err-passport'));

// Validation số điện thoại liên hệ
const emergencyPhoneInput = document.getElementById('field-emergency-phone');

// Chỉ cho nhập số, giới hạn 10 ký tự
emergencyPhoneInput?.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 10);
});

emergencyPhoneInput?.addEventListener('blur', () => 
    validatePhone(emergencyPhoneInput, 'err-emergency-phone')
);

// Validation Email @gmail.com 
function validateGmail(input, errId) {
    const errEl = document.getElementById(errId);
    if (!errEl) return true;

    const val = input.value.trim().toLowerCase();
    if (!val) { clearErr(input, errEl); return true; } // Không bắt buộc

    // Kiểm tra đúng format email cơ bản trước
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        showErr(input, errEl, 'Email không đúng định dạng');
        return false;
    }

    // Kiểm tra đuôi @gmail.com
    if (!val.endsWith('@gmail.com')) {
        showErr(input, errEl, 'Email phải có đuôi @gmail.com');
        return false;
    }

    // Kiểm tra phần trước @ không rỗng và hợp lệ
    const localPart = val.split('@')[0];
    if (localPart.length < 6) {
        showErr(input, errEl, `Phần tên email quá ngắn (tối thiểu 6 ký tự, hiện ${localPart.length})`);
        return false;
    }
    if (!/^[a-z0-9._]+$/.test(localPart)) {
        showErr(input, errEl, 'Tên email chỉ được chứa chữ thường, số, dấu chấm và dấu gạch dưới');
        return false;
    }

    clearErr(input, errEl);
    return true;
}

// Lấy các field email
const emailInput      = document.getElementById('field-email');
const workEmailInput  = document.getElementById('field-work-email');
const workEmailInput2 = document.getElementById('field-work-email-2');

// Tự động lowercase khi nhập
[emailInput, workEmailInput, workEmailInput2].forEach(el => {
    el?.addEventListener('input', function () {
        const cursor = this.selectionStart;
        this.value = this.value.toLowerCase().trim();
        this.setSelectionRange(cursor, cursor);
    });
});

// Validate khi rời field
emailInput?.addEventListener('blur',      () => validateGmail(emailInput,      'err-email'));
workEmailInput?.addEventListener('blur',  () => validateGmail(workEmailInput,  'err-work-email'));
workEmailInput2?.addEventListener('blur', () => validateGmail(workEmailInput2, 'err-work-email-2'));

// Đồng bộ 2 field work_email (tab Cá nhân ↔ tab Công việc)
workEmailInput?.addEventListener('input', function () {
    if (workEmailInput2) workEmailInput2.value = this.value;
});
workEmailInput2?.addEventListener('input', function () {
    if (workEmailInput) workEmailInput.value = this.value;
});

let bankList = [];

// Load danh sách ngân hàng
async function loadBanks() {
    try {
        const res  = await fetch('{{ route("hr.bank.banks") }}');
        bankList   = await res.json();
    } catch (e) {
        console.error('Không load được danh sách ngân hàng', e);
    }
}
loadBanks();

const bankSearchInput = document.getElementById('bank-search-input');
const bankDropdown    = document.getElementById('bank-dropdown');
const bankBinVal      = document.getElementById('bank-bin-val');
const bankNameVal     = document.getElementById('bank-name-val');
const btnLookup       = document.getElementById('btn-lookup-bank');
const bankAccountInp  = document.getElementById('field-bank-account');

// Tìm ngân hàng khi gõ
bankSearchInput?.addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    if (!q) { bankDropdown.classList.remove('open'); return; }

    const matched = bankList.filter(b =>
        b.shortName?.toLowerCase().includes(q) ||
        b.name?.toLowerCase().includes(q) ||
        b.code?.toLowerCase().includes(q)
    ).slice(0, 8);

    if (!matched.length) {
        bankDropdown.innerHTML = `<div style="padding:12px 14px;font-size:12px;color:#94a3b8">Không tìm thấy ngân hàng</div>`;
    } else {
        bankDropdown.innerHTML = matched.map(b => `
            <div class="emp-autocomplete-item" 
                data-bin="${b.bin}" 
                data-name="${b.shortName}" 
                data-fullname="${b.name}"
                data-code="${b.code}"
                data-logo="https://api.vietqr.io/img/${b.code}.png"
                style="display:flex;align-items:center;gap:10px">
                <img src="https://api.vietqr.io/img/${b.code}.png" 
                    style="width:28px;height:28px;object-fit:contain;border-radius:4px;border:0.5px solid #e2e8f0;background:#fff;padding:2px"
                    onerror="this.style.display='none'"/>
                <div>
                    <div class="emp-autocomplete-item-name">${b.shortName}</div>
                    <div class="emp-autocomplete-item-sub">${b.name}</div>
                </div>
            </div>
        `).join('');
    }
    bankDropdown.classList.add('open');

    // Click chọn ngân hàng
    bankDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
        item.addEventListener('click', () => {
            selectBank(item.dataset);
            bankDropdown.classList.remove('open');
        });
    });
});

function selectBank(data) {
    // Cập nhật hidden inputs
    bankBinVal.value  = data.bin;
    bankNameVal.value = data.name;

    // Ẩn search, hiện preview
    bankSearchInput.style.display = 'none';
    const preview = document.getElementById('bank-selected-preview');
    preview.style.display = 'block';
    document.getElementById('bank-logo-img').src         = data.logo;
    document.getElementById('bank-selected-name').textContent = data.name;
    document.getElementById('bank-selected-code').textContent = data.code + ' · BIN: ' + data.bin;

    // Kích hoạt nút tra cứu nếu đã có số TK
    updateLookupBtn();
}

function clearBankSelection() {
    bankBinVal.value  = '';
    bankNameVal.value = '';
    bankSearchInput.value = '';
    bankSearchInput.style.display = '';
    document.getElementById('bank-selected-preview').style.display = 'none';
    updateLookupBtn();
    clearBankResult();
}

// Kích hoạt nút Tra cứu khi có đủ ngân hàng + số TK
bankAccountInp?.addEventListener('input', () => {
    bankAccountInp.value = bankAccountInp.value.replace(/\D/g, '').slice(0, 19);
    updateLookupBtn();
});

function updateLookupBtn() {
    const ready = bankBinVal.value && bankAccountInp.value.length >= 6;
    btnLookup.disabled = !ready;
    btnLookup.style.opacity = ready ? '1' : '0.4';
    btnLookup.style.cursor  = ready ? 'pointer' : 'not-allowed';
}

// Thực hiện tra cứu
async function lookupBankAccount() {
    const bin    = bankBinVal.value;
    const accNum = bankAccountInp.value.trim();

    if (!bin || !accNum) return;

    // UI loading
    btnLookup.disabled = true;
    btnLookup.innerHTML = `
        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;animation:spin 1s linear infinite">
            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
        </svg>
        Đang tra...`;

    showBadge('loading', '⏳ Đang kiểm tra...');

    try {
        const res  = await fetch('{{ route("hr.bank.lookup") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ bin, accountNumber: accNum }),
        });
        const data = await res.json();

        if (data.success) {
            // Điền tên chủ TK
            const nameField = document.getElementById('field-bank-account-name');
            nameField.value = data.accountName;
            nameField.style.background = '#f0fdf4';
            nameField.style.borderColor = '#86efac';

            document.getElementById('bank-account-name-badge').style.display = 'inline';
            showBadge('success', '✓ Tài khoản hợp lệ');
            document.getElementById('bank-account-hint').textContent = 
                'Tên tài khoản đã được xác minh qua VietQR';
        } else {
            clearBankResult();
            showBadge('error', '✗ ' + data.message);
        }
    } catch (e) {
        showBadge('error', '✗ Lỗi kết nối');
    } finally {
        btnLookup.disabled = false;
        btnLookup.innerHTML = `
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Tra cứu`;
        updateLookupBtn();
    }
}

function showBadge(type, text) {
    const badge = document.getElementById('bank-lookup-badge');
    badge.style.display = 'block';
    badge.textContent   = text;
    const styles = {
        loading: { bg: '#fef9c3', color: '#854d0e', border: '#fde68a' },
        success: { bg: '#dcfce7', color: '#16a34a', border: '#86efac' },
        error:   { bg: '#fee2e2', color: '#dc2626', border: '#fca5a5' },
    };
    const s = styles[type];
    badge.style.background   = s.bg;
    badge.style.color        = s.color;
    badge.style.border       = `0.5px solid ${s.border}`;
}

function clearBankResult() {
    const nameField = document.getElementById('field-bank-account-name');
    nameField.style.background  = '';
    nameField.style.borderColor = '';
    document.getElementById('bank-account-name-badge').style.display = 'none';
}

// CSS cho animation loading
const style = document.createElement('style');
style.textContent = `@keyframes spin { to { transform: rotate(360deg); } }`;
document.head.appendChild(style);

// Đóng dropdown ngân hàng khi click ngoài
document.addEventListener('click', e => {
    if (!e.target.closest('#bank-search-input') && !e.target.closest('#bank-dropdown')) {
        bankDropdown.classList.remove('open');
    }
});

const eduMajorData = window.EMP_DATA.educationMajors;
const eduUnivData  = window.EMP_DATA.universities;

const univTypeLabel = {
    dai_hoc:   'Đại học',
    cao_dang:  'Cao đẳng',
    trung_cap: 'Trung cấp',
    hoc_vien:  'Học viện',
};

// Flat list chuyên ngành
const majorFlatList = [];
eduMajorData.forEach(cat => {
    (cat.industries || []).forEach(ind => {
        majorFlatList.push({
            id:       ind.id,
            name:     ind.name,
            code:     ind.code,
            category: cat.category_name,
        });
    });
});

//  CHUYÊN NGÀNH 
const majorSearch   = document.getElementById('major-search');
const majorDropdown = document.getElementById('major-dropdown');
const majorVal      = document.getElementById('major-val');

// Restore old() value vào preview nếu có
if (majorVal.value) {
    const found = majorFlatList.find(m => m.name === majorVal.value);
    if (found) selectMajor({ name: found.name, code: found.code, cat: found.category });
    else majorSearch.value = majorVal.value;
}

majorSearch?.addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    if (!q) { majorDropdown.classList.remove('open'); return; }

    const matched = majorFlatList.filter(m =>
        m.name.toLowerCase().includes(q) ||
        m.category.toLowerCase().includes(q) ||
        m.code.toLowerCase().includes(q)
    ).slice(0, 12);

    if (!matched.length) {
        majorDropdown.innerHTML = `<div style="padding:12px 14px;font-size:12px;color:#94a3b8">Không tìm thấy chuyên ngành</div>`;
    } else {
        const grouped = {};
        matched.forEach(m => {
            if (!grouped[m.category]) grouped[m.category] = [];
            grouped[m.category].push(m);
        });
        majorDropdown.innerHTML = Object.entries(grouped).map(([cat, items]) => `
            <div style="padding:5px 12px 3px;font-size:10px;font-weight:700;color:#94a3b8;
                        text-transform:uppercase;letter-spacing:0.05em;background:#f8fafc;
                        border-bottom:0.5px solid #f1f5f9;pointer-events:none">
                ${cat}
            </div>
            ${items.map(m => `
                <div class="emp-autocomplete-item"
                    data-name="${m.name}" data-code="${m.code}" data-cat="${m.category}">
                    <div>
                        <div class="emp-autocomplete-item-name">${m.name}</div>
                        <div class="emp-autocomplete-item-sub" style="font-family:'Courier New',monospace">${m.code}</div>
                    </div>
                </div>
            `).join('')}
        `).join('');
    }

    majorDropdown.classList.add('open');
    majorDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
        item.addEventListener('click', () => selectMajor(item.dataset));
    });
});

function selectMajor(data) {
    majorVal.value = data.name;
    majorSearch.style.display = 'none';
    majorDropdown.classList.remove('open');
    document.getElementById('major-selected-name').textContent = data.name;
    document.getElementById('major-selected-cat').textContent  = data.cat;
    document.getElementById('major-selected-code').textContent = 'Mã: ' + data.code;
    document.getElementById('major-selected-preview').style.display = 'block';
    document.getElementById('major-badge').style.display = 'inline';
}

function clearMajor() {
    majorVal.value = '';
    majorSearch.value = '';
    majorSearch.style.display = '';
    document.getElementById('major-selected-preview').style.display = 'none';
    document.getElementById('major-badge').style.display = 'none';
    majorSearch.focus();
}

document.addEventListener('click', e => {
    if (!e.target.closest('#major-search') && !e.target.closest('#major-dropdown'))
        majorDropdown.classList.remove('open');
});

// TRƯỜNG 
const univSearch   = document.getElementById('univ-search');
const univDropdown = document.getElementById('univ-dropdown');
const univVal      = document.getElementById('univ-val');

// Restore old() value
if (univVal.value) {
    const found = eduUnivData.find(u => u.name === univVal.value);
    if (found) selectUniv({ name: found.name, type: found.type || '', city: found.city || '', short: found.short || '' });
    else univSearch.value = univVal.value;
}

univSearch?.addEventListener('input', function () {
    const q = this.value.trim().toLowerCase();
    if (!q) { univDropdown.classList.remove('open'); return; }

    const matched = eduUnivData.filter(u =>
        u.name.toLowerCase().includes(q) ||
        (u.short && u.short.toLowerCase().includes(q)) ||
        (u.city  && u.city.toLowerCase().includes(q))
    ).slice(0, 10);

    if (!matched.length) {
        univDropdown.innerHTML = `<div style="padding:12px 14px;font-size:12px;color:#94a3b8">Không tìm thấy trường</div>`;
    } else {
        univDropdown.innerHTML = matched.map(u => `
            <div class="emp-autocomplete-item"
                data-name="${u.name}"
                data-type="${u.type || ''}"
                data-city="${u.city || ''}"
                data-short="${u.short || ''}">
                <div style="display:flex;align-items:center;justify-content:space-between;width:100%;gap:8px">
                    <div>
                        <div class="emp-autocomplete-item-name">${u.name}</div>
                        <div class="emp-autocomplete-item-sub">
                            ${[u.city, u.short].filter(Boolean).join(' · ')}
                        </div>
                    </div>
                    ${u.type ? `
                        <span style="flex-shrink:0;font-size:10px;font-weight:600;background:#eff6ff;color:#1d4ed8;
                                    padding:2px 7px;border-radius:4px;border:0.5px solid #bfdbfe">
                            ${univTypeLabel[u.type] || u.type}
                        </span>` : ''}
                </div>
            </div>
        `).join('');
    }

    univDropdown.classList.add('open');
    univDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
        item.addEventListener('click', () => selectUniv(item.dataset));
    });
});

function selectUniv(data) {
    univVal.value = data.name;
    univSearch.style.display = 'none';
    univDropdown.classList.remove('open');
    document.getElementById('univ-selected-name').textContent = data.name;
    document.getElementById('univ-selected-meta').textContent =
        [univTypeLabel[data.type] || data.type, data.city, data.short].filter(Boolean).join(' · ');
    document.getElementById('univ-selected-preview').style.display = 'block';
    document.getElementById('univ-badge').style.display = 'inline';
}

function clearUniv() {
    univVal.value = '';
    univSearch.value = '';
    univSearch.style.display = '';
    document.getElementById('univ-selected-preview').style.display = 'none';
    document.getElementById('univ-badge').style.display = 'none';
    univSearch.focus();
}

document.addEventListener('click', e => {
    if (!e.target.closest('#univ-search') && !e.target.closest('#univ-dropdown'))
        univDropdown.classList.remove('open');
});

// TRÌNH ĐỘ 
const eduLevelData = window.EMP_DATA.educationLevels;
const levelSearch   = document.getElementById('level-search');
const levelDropdown = document.getElementById('level-dropdown');
const levelVal      = document.getElementById('level-val');

// Build dropdown HTML 1 lần
function buildLevelDropdown() {
    levelDropdown.innerHTML = Object.entries(eduLevelData).map(([key, label]) => `
        <div class="emp-autocomplete-item" data-key="${key}" data-label="${label}">
            <div class="emp-autocomplete-item-name">${label}</div>
        </div>
    `).join('');

    levelDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
        item.addEventListener('click', () => selectLevel(item.dataset));
    });
}
buildLevelDropdown();

function toggleLevelDropdown() {
    if (levelDropdown.classList.contains('open')) {
        levelDropdown.classList.remove('open');
    } else {
        levelDropdown.classList.add('open');
    }
}

function selectLevel(data) {
    levelVal.value = data.key;
    levelSearch.style.display = 'none';
    levelDropdown.classList.remove('open');
    document.getElementById('level-selected-name').textContent = data.label;
    document.getElementById('level-selected-preview').style.display = 'block';
    document.getElementById('level-badge').style.display = 'inline';
}

function clearLevel() {
    levelVal.value = '';
    levelSearch.style.display = '';
    levelSearch.value = '';
    document.getElementById('level-selected-preview').style.display = 'none';
    document.getElementById('level-badge').style.display = 'none';
}

// Restore old() value
if (levelVal.value) {
    const label = eduLevelData[levelVal.value];
    if (label) selectLevel({ key: levelVal.value, label });
}

document.addEventListener('click', e => {
    if (!e.target.closest('#level-search') && !e.target.closest('#level-dropdown'))
        levelDropdown.classList.remove('open');
});

// TRA CỨU MÃ SỐ THUẾ 
const taxCodeInput = document.getElementById('field-tax-code');
const btnLookupTax = document.getElementById('btn-lookup-tax');

taxCodeInput?.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9\-]/g, '').slice(0, 14);
    const ready = this.value.replace(/-/g, '').length >= 10;
    btnLookupTax.disabled = !ready;
    btnLookupTax.style.opacity = ready ? '1' : '0.4';
    btnLookupTax.style.cursor  = ready ? 'pointer' : 'not-allowed';
});

async function lookupTaxCode() {
    const taxCode = taxCodeInput.value.trim();
    if (!taxCode) return;

    btnLookupTax.disabled = true;
    btnLookupTax.innerHTML = `
        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;animation:spin 1s linear infinite">
            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
        </svg>
        Đang tra...`;
    showTaxBadge('loading', '⏳ Đang kiểm tra...');
    document.getElementById('tax-result-box').style.display = 'none';

    try {
        const res  = await fetch(`https://api.xinvoice.vn/gdt-api/tax-payer-records/${taxCode}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (data.success && data.data?.length) {
            fillTaxResult(data.data);
            showTaxBadge('success', '✓ Tìm thấy thông tin');
            document.getElementById('tax-code-hint').textContent = 'MST đã được xác minh qua cổng GDT';
        } else {
            showTaxBadge('error', '✗ Không tìm thấy MST này');
        }

    } catch (e) {
        showTaxBadge('error', '✗ Lỗi kết nối');
    } finally {
        btnLookupTax.disabled = false;
        btnLookupTax.innerHTML = `
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Tra cứu MST`;
        const ready = taxCodeInput.value.replace(/-/g, '').length >= 10;
        btnLookupTax.disabled = !ready;
        btnLookupTax.style.opacity = ready ? '1' : '0.4';
    }
}

function fillTaxResult(records) {
    const r = records[0];

    document.getElementById('tax-res-name').textContent    = r.name;
    document.getElementById('tax-res-type').textContent    = r.orgType;
    document.getElementById('tax-res-address').textContent = r.address;
    document.getElementById('tax-res-dept').textContent    = r.taxDepartment;

    const statusEl = document.getElementById('tax-res-status');
    statusEl.textContent        = r.status;
    const isActive              = r.status?.includes('đang hoạt động');
    statusEl.style.color        = isActive ? '#16a34a' : '#dc2626';
    statusEl.style.background   = isActive ? '#dcfce7' : '#fee2e2';
    statusEl.style.padding      = '1px 8px';
    statusEl.style.borderRadius = '4px';
    statusEl.style.fontSize     = '11px';

    // Nhiều kết quả → hiện danh sách chọn
    const multiWrap = document.getElementById('tax-multi-wrap');
    const multiList = document.getElementById('tax-multi-list');
    if (records.length > 1) {
        multiWrap.style.display = 'block';
        multiList.innerHTML = records.map((r, i) => `
            <div onclick="applyTaxRecord(this, ${JSON.stringify(records).replace(/"/g, '&quot;')}, ${i})"
                style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;
                        background:#fff;border:0.5px solid #bbf7d0;border-radius:7px;cursor:pointer;
                        transition:background .12s"
                onmouseover="this.style.background='#f0fdf4'"
                onmouseout="this.style.background='#fff'">
                <div>
                    <div style="font-size:12px;font-weight:700;color:#1e293b">${r.name}</div>
                    <div style="font-size:11px;color:#64748b">${r.orgType} · ${r.taxDepartment}</div>
                </div>
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:#94a3b8;fill:none;stroke-width:2;flex-shrink:0">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </div>
        `).join('');
    } else {
        multiWrap.style.display = 'none';
    }

    document.getElementById('tax-result-box').style.display = 'block';
}

function applyTaxRecord(el, records, index) {
    const r = records[index];
    document.getElementById('tax-res-name').textContent    = r.name;
    document.getElementById('tax-res-type').textContent    = r.orgType;
    document.getElementById('tax-res-address').textContent = r.address;
    document.getElementById('tax-res-dept').textContent    = r.taxDepartment;
    const statusEl              = document.getElementById('tax-res-status');
    statusEl.textContent        = r.status;
    const isActive              = r.status?.includes('đang hoạt động');
    statusEl.style.color        = isActive ? '#16a34a' : '#dc2626';
    statusEl.style.background   = isActive ? '#dcfce7' : '#fee2e2';
    document.getElementById('tax-multi-wrap').style.display = 'none';
}

function showTaxBadge(type, text) {
    const badge  = document.getElementById('tax-lookup-badge');
    badge.style.display = 'block';
    badge.textContent   = text;
    const styles = {
        loading: { bg: '#fef9c3', color: '#854d0e', border: '#fde68a' },
        success: { bg: '#dcfce7', color: '#16a34a', border: '#86efac' },
        error:   { bg: '#fee2e2', color: '#dc2626', border: '#fca5a5' },
    };
    const s = styles[type];
    badge.style.background   = s.bg;
    badge.style.color        = s.color;
    badge.style.border       = `0.5px solid ${s.border}`;
    badge.style.borderRadius = '20px';
}