import './bootstrap';
import './nova-ui.js';
import provinces from '../../../../../../Data/provinces.json';
document.addEventListener('DOMContentLoaded', () => {

    // ── NAVBAR SCROLL ──
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });
    }

    // ── SCROLL REVEAL (dùng chung cho .reveal và .prod-item) ──
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.revealDelay || 0;
                setTimeout(() => entry.target.classList.add('visible'), delay);
            } else {
                if (!entry.target.classList.contains('prod-item')) {
                    entry.target.classList.remove('visible');
                }
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Products: stagger reveal
    document.querySelectorAll('.prod-item').forEach((el, i) => {
        el.dataset.revealDelay = i * 50;
        revealObserver.observe(el);
    });

    // ── SPOTLIGHT DASHBOARD ──
    const spotCards = [
        ...document.querySelectorAll('.dash-stat'),
        ...document.querySelectorAll('.dash-card')
    ];
    let spotIdx = 0;

    function runSpotlight() {
        if (spotCards.length === 0) return;
        spotCards.forEach(c => c.classList.remove('spotlight', 'dimmed'));
        spotCards.forEach(c => c.classList.add('dimmed'));
        spotCards[spotIdx].classList.remove('dimmed');
        spotCards[spotIdx].classList.add('spotlight');
        spotIdx = (spotIdx + 1) % spotCards.length;
        setTimeout(runSpotlight, 2400);
    }
    setTimeout(runSpotlight, 1000);

    // ── FEATURE SLIDER ──
    let featIdx = 0;
    const featSlides = document.querySelectorAll('.feat-slide');
    const featDots   = document.querySelectorAll('.feat-dot');

    function featGoTo(idx) {
        if (featSlides.length === 0) return;
        featSlides[featIdx].classList.remove('active');
        featDots[featIdx].classList.remove('active');
        featIdx = (idx + featSlides.length) % featSlides.length;
        featSlides[featIdx].classList.add('active');
        featDots[featIdx].classList.add('active');
    }

    document.querySelector('.feat-prev')?.addEventListener('click', () => featGoTo(featIdx - 1));
    document.querySelector('.feat-next')?.addEventListener('click', () => featGoTo(featIdx + 1));
    featDots.forEach((dot, i) => dot.addEventListener('click', () => featGoTo(i)));
    setInterval(() => featGoTo(featIdx + 1), 5000);

    // Cursor glow feat title
    const featTitle = document.querySelector('.feat-main-title');
    if (featTitle) {
        const light = document.createElement('div');
        light.className = 'cursor-light';
        light.style.opacity = '0';
        featTitle.appendChild(light);
        featTitle.addEventListener('mousemove', e => {
            const r = featTitle.getBoundingClientRect();
            light.style.left    = (e.clientX - r.left) + 'px';
            light.style.top     = (e.clientY - r.top) + 'px';
            light.style.opacity = '1';
        });
        featTitle.addEventListener('mouseleave', () => light.style.opacity = '0');
    }

    // ── AI SECTION ──
    const aiResults = [
        {
            title: "Đề xuất cần phê duyệt",
            summary: "Hiện tại bạn có <strong>9 đề xuất</strong> cần phê duyệt:",
            list: [
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 đề xuất", text: " được gắn dấu sao" },
                { color: "#ef4444", textColor: "#f87171", bold: "3 đề xuất", text: " quá hạn" },
                { color: "#fb923c", textColor: "#fb923c", bold: "2 đề xuất", text: " có thời hạn dưới 1 ngày" },
                { color: "#60A5FA", textColor: "#93c5fd", bold: "5 đề xuất", text: " đã được cấp dưới phê duyệt, bạn là người duyệt cuối" },
                { color: "#34d399", textColor: "#6ee7b7", bold: "3 đề xuất", text: " liên quan chi phí cần bạn phê duyệt để tiếp tục dự án" },
            ]
        },
        {
            title: "Tóm tắt công việc tuần này",
            summary: "Team bạn đã hoàn thành <strong>87% KPI</strong> tuần này:",
            list: [
                { color: "#22c55e", textColor: "#4ade80", bold: "12 task", text: " đã hoàn thành đúng hạn" },
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 task",  text: " đang trong tiến trình" },
                { color: "#ef4444", textColor: "#f87171", bold: "1 task",  text: " bị trễ deadline cần xử lý" },
                { color: "#60A5FA", textColor: "#93c5fd", bold: "5 cuộc họp", text: " đã diễn ra, 2 còn lại trong tuần" },
                { color: "#a78bfa", textColor: "#c4b5fd", bold: "2 thành viên", text: " đang nghỉ phép, cần phân công lại" },
            ]
        },
        {
            title: "Tình hình tài chính tháng này",
            summary: "Doanh thu đạt <strong>92% kế hoạch</strong>, chi phí tốt:",
            list: [
                { color: "#22c55e", textColor: "#4ade80", bold: "4.2 tỷ VNĐ", text: " doanh thu tháng này" },
                { color: "#60A5FA", textColor: "#93c5fd", bold: "1.8 tỷ VNĐ", text: " chi phí vận hành, thấp hơn 8% dự kiến" },
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 khoản",    text: " chi phí phát sinh cần phê duyệt" },
                { color: "#34d399", textColor: "#6ee7b7", bold: "Lợi nhuận", text: " tháng này ước đạt 2.4 tỷ VNĐ" },
                { color: "#fb923c", textColor: "#fb923c", bold: "Cảnh báo:", text: " ngân sách marketing sắp hết hạn mức" },
            ]
        },
        {
            title: "Lịch họp hôm nay",
            summary: "Bạn có <strong>4 cuộc họp</strong> quan trọng hôm nay:",
            list: [
                { color: "#60A5FA", textColor: "#93c5fd", bold: "09:00", text: " — Họp kick-off dự án Q2 (60 phút)" },
                { color: "#22c55e", textColor: "#4ade80", bold: "11:00", text: " — Review sprint với team kỹ thuật" },
                { color: "#f59e0b", textColor: "#fbbf24", bold: "14:00", text: " — Báo cáo tháng với Ban giám đốc" },
                { color: "#a78bfa", textColor: "#c4b5fd", bold: "16:30", text: " — 1-on-1 với trưởng phòng Marketing" },
                { color: "#34d399", textColor: "#6ee7b7", bold: "Gợi ý:",  text: " chuẩn bị slide báo cáo trước 13:30" },
            ]
        }
    ];

    function aiSelect(el, idx) {
        document.querySelectorAll('.ai-chat-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');

        const data    = aiResults[idx];
        const card    = document.getElementById('aiResultCard');
        const title   = document.getElementById('aiResultTitle');
        const summary = document.getElementById('aiResultSummary');
        const list    = document.getElementById('aiResultList');
        if (!card || !title || !summary || !list) return;

        card.classList.remove('visible');
        list.innerHTML = '';

        setTimeout(() => {
            title.textContent = data.title;
            summary.innerHTML = data.summary;
            card.classList.add('visible');

            data.list.forEach((row, i) => {
                setTimeout(() => {
                    const div = document.createElement('div');
                    div.className = 'ai-result-row';
                    div.style.cssText = 'opacity:0;transform:translateX(-10px);transition:all 0.4s cubic-bezier(0.16,1,0.3,1)';
                    div.innerHTML = `<div class="ai-result-dot" style="background:${row.color}"></div><span><strong style="color:${row.textColor}">${row.bold}</strong>${row.text}</span>`;
                    list.appendChild(div);
                    requestAnimationFrame(() => requestAnimationFrame(() => {
                        div.style.opacity   = '1';
                        div.style.transform = 'translateX(0)';
                    }));
                }, i * 350);
            });
        }, 220);
    }

    const aiItems = document.querySelectorAll('.ai-chat-item');
    aiItems.forEach((item, i) => item.addEventListener('click', () => aiSelect(item, i)));

    let aiAutoIdx = 0, aiHovered = false;
    document.querySelector('.ai-chat-panel')?.addEventListener('mouseenter', () => aiHovered = true);
    document.querySelector('.ai-chat-panel')?.addEventListener('mouseleave', () => aiHovered = false);
    setInterval(() => {
        if (!aiHovered && aiItems.length > 0) {
            aiAutoIdx = (aiAutoIdx + 1) % aiItems.length;
            aiSelect(aiItems[aiAutoIdx], aiAutoIdx);
        }
    }, 3500);

    // Cursor glow AI title
    const aiHeroTitle  = document.getElementById('aiHeroTitle');
    const aiTitleLight = document.getElementById('aiTitleLight');
    if (aiHeroTitle && aiTitleLight) {
        aiHeroTitle.addEventListener('mousemove', e => {
            const r = aiHeroTitle.getBoundingClientRect();
            aiTitleLight.style.left    = (e.clientX - r.left) + 'px';
            aiTitleLight.style.top     = (e.clientY - r.top) + 'px';
            aiTitleLight.style.opacity = '1';
        });
        aiHeroTitle.addEventListener('mouseleave', () => aiTitleLight.style.opacity = '0');
    }

    // ── JOURNEY SECTION ──
    let journeyIdx = 0;
    const journeyBarWidths = ['25%', '50%', '75%', '100%'];

    function journeyGoTo(idx) {
        document.getElementById('jslide-' + journeyIdx)?.classList.remove('active');
        document.querySelectorAll('.journey-tab').forEach((tab, i) => tab.classList.toggle('active', i === idx));
        const bar = document.getElementById('journeyBar');
        if (bar) bar.style.width = journeyBarWidths[idx];

        journeyIdx = idx;
        const newSlide = document.getElementById('jslide-' + idx);
        if (!newSlide) return;
        newSlide.classList.add('active');

        newSlide.querySelectorAll('.jflow-item').forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(10px)';
            const delay = parseInt(item.getAttribute('data-delay') || 0);
            setTimeout(() => {
                item.style.opacity   = '1';
                item.style.transform = 'translateX(0)';
            }, delay);
        });

        newSlide.querySelectorAll('.jflow-node').forEach((n, i) => {
            n.style.opacity = '0';
            n.style.transform = 'translateY(8px)';
            setTimeout(() => {
                n.style.transition = 'all 0.4s cubic-bezier(0.16,1,0.3,1)';
                n.style.opacity    = '1';
                n.style.transform  = 'translateY(0)';
                n.classList.add('show');
            }, i * 150);
        });
    }

    document.querySelectorAll('.journey-tab').forEach((tab, i) => tab.addEventListener('click', () => journeyGoTo(i)));

    let journeyHovered = false;
    document.getElementById('journeyPanel')?.addEventListener('mouseenter', () => journeyHovered = true);
    document.getElementById('journeyPanel')?.addEventListener('mouseleave', () => journeyHovered = false);
    setTimeout(() => setInterval(() => { if (!journeyHovered) journeyGoTo((journeyIdx + 1) % 4); }, 4000), 1500);

    // Cursor glow journey title
    const journeyTitle      = document.getElementById('journeyTitle');
    const journeyTitleLight = document.getElementById('journeyTitleLight');
    if (journeyTitle && journeyTitleLight) {
        journeyTitle.addEventListener('mousemove', e => {
            const r = journeyTitle.getBoundingClientRect();
            journeyTitleLight.style.left    = (e.clientX - r.left) + 'px';
            journeyTitleLight.style.top     = (e.clientY - r.top) + 'px';
            journeyTitleLight.style.opacity = '1';
        });
        journeyTitle.addEventListener('mouseleave', () => journeyTitleLight.style.opacity = '0');
    }

    // Trigger nodes khi vào viewport
    const journeySection = document.getElementById('how');
    if (journeySection) {
        new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    document.querySelector('.journey-slide.active')?.querySelectorAll('.jflow-node').forEach((n, i) => {
                        n.style.opacity = '0';
                        n.style.transform = 'translateY(8px)';
                        setTimeout(() => {
                            n.style.transition = 'all 0.4s cubic-bezier(0.16,1,0.3,1)';
                            n.style.opacity    = '1';
                            n.style.transform  = 'translateY(0)';
                        }, 300 + i * 150);
                    });
                }
            });
        }, { threshold: 0.2 }).observe(journeySection);
    }

    // ── INDUSTRIES SECTION ──
    let indIdx = 0;

    function indGoTo(idx) {
        document.getElementById('ind-' + indIdx)?.classList.remove('active');
        document.querySelectorAll('.ind-tab')[indIdx]?.classList.remove('active');
        indIdx = idx;
        document.getElementById('ind-' + idx)?.classList.add('active');
        document.querySelectorAll('.ind-tab')[idx]?.classList.add('active');
    }

    document.querySelectorAll('.ind-tab').forEach((tab, i) => tab.addEventListener('click', () => indGoTo(i)));

    let indHovered = false;
    document.querySelector('.industries-section')?.addEventListener('mouseenter', () => indHovered = true);
    document.querySelector('.industries-section')?.addEventListener('mouseleave', () => indHovered = false);
    setInterval(() => { if (!indHovered) indGoTo((indIdx + 1) % 8); }, 4000);

    // ── FLOATING AI BUTTON ──
    document.querySelector('.fab-ai')?.addEventListener('click', (e) => {
        e.preventDefault();
        document.querySelector('.ai-section')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    // ── MEGA MENU ──
    let currentMenu = null;

    function closeMega() {
        if (currentMenu) {
            document.getElementById(currentMenu)?.classList.remove('open');
            document.querySelector(`[data-menu="${currentMenu}"]`)?.classList.remove('open');
            currentMenu = null;
        }
        document.getElementById('megaOverlay')?.classList.remove('visible');
    }

    document.querySelectorAll('.nav-toggle').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const menuId = btn.getAttribute('data-menu');
            if (currentMenu === menuId) {
                closeMega();
            } else {
                closeMega();
                currentMenu = menuId;
                document.getElementById(menuId)?.classList.add('open');
                btn.classList.add('open');
                document.getElementById('megaOverlay')?.classList.add('visible');
            }
        });
    });

    document.getElementById('megaOverlay')?.addEventListener('click', closeMega);
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.mega-menu') && !e.target.closest('.nav-toggle')) closeMega();
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMega(); });

    // ── DEMO MODAL ──
    const demoOverlay = document.getElementById('demoModalOverlay');
    const demoClose   = document.getElementById('demoModalClose');

    function openDemoModal() {
        demoOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeDemoModal() {
        demoOverlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('[data-demo="open"], .btn-demo, .journey-cta-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openDemoModal();
        });
    });

    demoClose?.addEventListener('click', closeDemoModal);
    demoOverlay?.addEventListener('click', (e) => {
        if (e.target === demoOverlay) closeDemoModal();
    });

    document.getElementById('demoForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validate trước
        if (!validateDemoForm()) return;

        const confirmed = await novaConfirm({
            title: 'Xác nhận đăng ký?',
            message: 'Thông tin của bạn sẽ được gửi đến đội ngũ tư vấn NovaHRM.',
            confirmText: 'Đồng ý',
            cancelText: 'Huỷ',
            type: 'info'
        });

        if (!confirmed) return;

        const btn = document.getElementById('demoSubmitBtn');
        btn.textContent = 'Đang gửi...';
        btn.disabled = true;

        try {
            const res = await fetch('/demo-register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    full_name:    document.getElementById('df_name').value,
                    email:        document.getElementById('df_email').value,
                    phone:        document.getElementById('df_phone').value,
                    company_name: document.getElementById('df_company').value,
                    product:      document.getElementById('df_product').value,
                    position:     document.getElementById('df_position').value,
                    city:         document.getElementById('df_city').value,
                    company_size: document.getElementById('df_size').value,
                    _token:       document.querySelector('meta[name="csrf-token"]').content,
                })
            });

            const result = await res.json();

            if (result.success) {
                closeDemoModal();
                document.getElementById('demoForm').reset();
                novaToast(result.message, 'success');
            } else {
                novaToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
            }
        } catch (err) {
            novaToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
        } finally {
            btn.textContent = 'Nhận tư vấn giải pháp';
            btn.disabled = false;
        }
    });

    function loadProvinces() {
        const select = document.getElementById('df_city');
        if (!select) return;

        while (select.options.length > 1) {
            select.remove(1);
        }

        provinces.forEach(p => {
            const option = document.createElement('option');
            option.value = p.name;
            option.textContent = p.name;
            select.appendChild(option);
        });
    }

    loadProvinces();

    // VALIDATE HELPERS 
    function showError(inputEl, msg) {
        inputEl.classList.add('error');
        // Xóa error cũ nếu có
        const old = inputEl.parentElement.querySelector('.demo-field-error');
        if (old) old.remove();

        const err = document.createElement('div');
        err.className = 'demo-field-error';
        err.textContent = msg;
        inputEl.parentElement.appendChild(err);
    }

    function clearError(inputEl) {
        inputEl.classList.remove('error');
        const old = inputEl.parentElement.querySelector('.demo-field-error');
        if (old) old.remove();
    }

    function validateDemoForm() {
        let valid = true;

        const name     = document.getElementById('df_name');
        const email    = document.getElementById('df_email');
        const phone    = document.getElementById('df_phone');
        const company  = document.getElementById('df_company');
        const product  = document.getElementById('df_product');
        const position = document.getElementById('df_position');
        const city     = document.getElementById('df_city');
        const size     = document.getElementById('df_size');

        // Không cho nhập số vào họ tên
        document.getElementById('df_name')?.addEventListener('keypress', function(e) {
            if (/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Không cho paste số vào họ tên
        document.getElementById('df_name')?.addEventListener('input', function() {
            this.value = this.value.replace(/[0-9]/g, '');
            clearError(this);
        });

        // Họ và tên
        const nameRegex = /^[a-zA-ZÀ-ỹ\s]+$/;
        if (!name.value.trim()) {
            showError(name, 'Vui lòng nhập họ và tên');
            valid = false;
        } else if (name.value.trim().length < 2) {
            showError(name, 'Họ và tên phải có ít nhất 2 ký tự');
            valid = false;
        } else if (!nameRegex.test(name.value.trim())) {
            showError(name, 'Họ và tên không được chứa số hoặc ký tự đặc biệt');
            valid = false;
        } else {
            clearError(name);
        }

        // Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim()) {
            showError(email, 'Vui lòng nhập email');
            valid = false;
        } else if (!emailRegex.test(email.value.trim())) {
            showError(email, 'Email không đúng định dạng');
            valid = false;
        } else {
            clearError(email);
        }

        // Số điện thoại - đúng 10 số
        const phoneRegex = /^(0[3|5|7|8|9])+([0-9]{8})$/;
        if (!phone.value.trim()) {
            showError(phone, 'Vui lòng nhập số điện thoại');
            valid = false;
        } else if (!phoneRegex.test(phone.value.trim())) {
            showError(phone, 'Số điện thoại phải đúng 10 số (VD: 0912345678)');
            valid = false;
        } else {
            clearError(phone);
        }

        // Tên công ty
        if (!company.value.trim()) {
            showError(company, 'Vui lòng nhập tên công ty');
            valid = false;
        } else {
            clearError(company);
        }

        // Sản phẩm
        if (!product.value) {
            showError(product, 'Vui lòng chọn sản phẩm quan tâm');
            valid = false;
        } else {
            clearError(product);
        }

        // Vị trí
        if (!position.value) {
            showError(position, 'Vui lòng chọn vị trí công việc');
            valid = false;
        } else {
            clearError(position);
        }

        // Tỉnh thành
        if (!city.value) {
            showError(city, 'Vui lòng chọn tỉnh/thành phố');
            valid = false;
        } else {
            clearError(city);
        }

        // Quy mô
        if (!size.value) {
            showError(size, 'Vui lòng chọn quy mô nhân sự');
            valid = false;
        } else {
            clearError(size);
        }

        return valid;
    }

    // Clear error khi user nhập lại
    ['df_name','df_email','df_phone','df_company'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', function() {
            clearError(this);
        });
    });
    ['df_product','df_position','df_city','df_size'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', function() {
            clearError(this);
        });
    });
});