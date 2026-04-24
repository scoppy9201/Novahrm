import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    //  NAVBAR SCROLL 
    const navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });
    }

    // SCROLL REVEAL
    const reveals = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            } else {
                entry.target.classList.remove('visible');
            }
        });
    }, { threshold: 0.1 });
    reveals.forEach(el => revealObserver.observe(el));

    // SPOTLIGHT DASHBOARD 
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

    // FEATURE SLIDER
    let featIdx = 0;
    const featSlides = document.querySelectorAll('.feat-slide');
    const featDots = document.querySelectorAll('.feat-dot');

    function featGoTo(idx) {
        if (featSlides.length === 0) return;
        featSlides[featIdx].classList.remove('active');
        featDots[featIdx].classList.remove('active');
        featIdx = (idx + featSlides.length) % featSlides.length;
        featSlides[featIdx].classList.add('active');
        featDots[featIdx].classList.add('active');
    }

    function featSlide(dir) {
        featGoTo(featIdx + dir);
    }

    // Gán event cho arrows thay vì dùng onclick trong blade
    document.querySelector('.feat-prev')?.addEventListener('click', () => featSlide(-1));
    document.querySelector('.feat-next')?.addEventListener('click', () => featSlide(1));
    featDots.forEach((dot, i) => dot.addEventListener('click', () => featGoTo(i)));

    // Auto slide mỗi 5 giây
    setInterval(() => featSlide(1), 5000);

    // Cursor glow trên feat title
    const featTitle = document.querySelector('.feat-main-title');
    if (featTitle) {
        const light = document.createElement('div');
        light.className = 'cursor-light';
        light.style.opacity = '0';
        featTitle.appendChild(light);
        featTitle.addEventListener('mousemove', e => {
            const r = featTitle.getBoundingClientRect();
            light.style.left = (e.clientX - r.left) + 'px';
            light.style.top  = (e.clientY - r.top) + 'px';
            light.style.opacity = '1';
        });
        featTitle.addEventListener('mouseleave', () => {
            light.style.opacity = '0';
        });
    }

    // AI SECTION 
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
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 task", text: " đang trong tiến trình" },
                { color: "#ef4444", textColor: "#f87171", bold: "1 task", text: " bị trễ deadline cần xử lý" },
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
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 khoản", text: " chi phí phát sinh cần phê duyệt" },
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
                { color: "#34d399", textColor: "#6ee7b7", bold: "Gợi ý:", text: " chuẩn bị slide báo cáo trước 13:30" },
            ]
        }
    ];

    function aiSelect(el, idx) {
        document.querySelectorAll('.ai-chat-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');

        const data = aiResults[idx];
        const card    = document.getElementById('aiResultCard');
        const title   = document.getElementById('aiResultTitle');
        const summary = document.getElementById('aiResultSummary');
        const list    = document.getElementById('aiResultList');
        if (!card || !title || !summary || !list) return;

        card.classList.remove('visible');
        list.innerHTML = '';

        setTimeout(() => {
            title.textContent   = data.title;
            summary.innerHTML   = data.summary;
            list.innerHTML      = '';
            card.classList.add('visible');

            data.list.forEach((row, i) => {
                setTimeout(() => {
                    const div = document.createElement('div');
                    div.className = 'ai-result-row';
                    div.style.cssText = 'opacity:0; transform:translateX(-10px); transition:all 0.4s cubic-bezier(0.16,1,0.3,1)';
                    div.innerHTML = `
                        <div class="ai-result-dot" style="background:${row.color}"></div>
                        <span><strong style="color:${row.textColor}">${row.bold}</strong>${row.text}</span>
                    `;
                    list.appendChild(div);
                    requestAnimationFrame(() => requestAnimationFrame(() => {
                        div.style.opacity   = '1';
                        div.style.transform = 'translateX(0)';
                    }));
                }, i * 350);
            });
        }, 220);
    }

    // Gán event cho ai-chat-item thay vì onclick trong blade
    const aiItems = document.querySelectorAll('.ai-chat-item');
    aiItems.forEach((item, i) => {
        item.addEventListener('click', () => aiSelect(item, i));
    });

    // Auto cycle AI
    let aiAutoIdx = 0;
    let aiHovered = false;
    const aiPanel = document.querySelector('.ai-chat-panel');
    if (aiPanel) {
        aiPanel.addEventListener('mouseenter', () => aiHovered = true);
        aiPanel.addEventListener('mouseleave', () => aiHovered = false);
    }
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
        aiHeroTitle.addEventListener('mouseleave', () => {
            aiTitleLight.style.opacity = '0';
        });
    }

    // JOURNEY SECTION 
    let journeyIdx = 0;
    const journeyBarWidths = ['25%', '50%', '75%', '100%'];

    function journeyGoTo(idx) {
        const oldSlide = document.getElementById('jslide-' + journeyIdx);
        if (oldSlide) oldSlide.classList.remove('active');

        document.querySelectorAll('.journey-tab').forEach((tab, i) => {
            tab.classList.toggle('active', i === idx);
        });

        const bar = document.getElementById('journeyBar');
        if (bar) bar.style.width = journeyBarWidths[idx];

        journeyIdx = idx;
        const newSlide = document.getElementById('jslide-' + idx);
        if (!newSlide) return;
        newSlide.classList.add('active');

        // Animate jflow-item
        const items = newSlide.querySelectorAll('.jflow-item');
        items.forEach(item => {
            item.style.opacity   = '0';
            item.style.transform = 'translateX(10px)';
        });
        items.forEach(item => {
            const delay = parseInt(item.getAttribute('data-delay') || 0);
            setTimeout(() => {
                item.style.opacity   = '1';
                item.style.transform = 'translateX(0)';
            }, delay);
        });

        // Animate jflow-node — FIX: khai báo nodes từ newSlide
        const nodes = newSlide.querySelectorAll('.jflow-node');
        nodes.forEach((n, i) => {
            n.style.opacity   = '0';
            n.style.transform = 'translateY(8px)';
            setTimeout(() => {
                n.style.transition = 'all 0.4s cubic-bezier(0.16,1,0.3,1)';
                n.style.opacity    = '1';
                n.style.transform  = 'translateY(0)';
                n.classList.add('show');
            }, i * 150);
        });
    }

    // Gán event cho journey-tab thay vì onclick trong blade
    document.querySelectorAll('.journey-tab').forEach((tab, i) => {
        tab.addEventListener('click', () => journeyGoTo(i));
    });

    // Auto cycle journey
    let journeyHovered = false;
    const journeyPanel = document.getElementById('journeyPanel');
    if (journeyPanel) {
        journeyPanel.addEventListener('mouseenter', () => journeyHovered = true);
        journeyPanel.addEventListener('mouseleave', () => journeyHovered = false);
    }
    setTimeout(() => {
        setInterval(() => {
            if (!journeyHovered) journeyGoTo((journeyIdx + 1) % 4);
        }, 4000);
    }, 1500);

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
        journeyTitle.addEventListener('mouseleave', () => {
            journeyTitleLight.style.opacity = '0';
        });
    }

    // Trigger nodes khi section vào viewport
    const journeySection = document.getElementById('how');
    if (journeySection) {
        const journeyObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const activeSlide = document.querySelector('.journey-slide.active');
                    if (activeSlide) {
                        const nodes = activeSlide.querySelectorAll('.jflow-node');
                        nodes.forEach((n, i) => {
                            n.style.opacity   = '0';
                            n.style.transform = 'translateY(8px)';
                            setTimeout(() => {
                                n.style.transition = 'all 0.4s cubic-bezier(0.16,1,0.3,1)';
                                n.style.opacity    = '1';
                                n.style.transform  = 'translateY(0)';
                            }, 300 + i * 150);
                        });
                    }
                    journeyObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        journeyObserver.observe(journeySection);
    }

    // INDUSTRIES SECTION
    let indIdx = 0;

    function indGoTo(idx) {
        const oldPanel = document.getElementById('ind-' + indIdx);
        const oldTab   = document.querySelectorAll('.ind-tab')[indIdx];
        if (oldPanel) oldPanel.classList.remove('active');
        if (oldTab)   oldTab.classList.remove('active');

        indIdx = idx;

        const newPanel = document.getElementById('ind-' + idx);
        const newTab   = document.querySelectorAll('.ind-tab')[idx];
        if (newPanel) newPanel.classList.add('active');
        if (newTab)   newTab.classList.add('active');
    }

    // Gán event cho ind-tab thay vì onclick trong blade
    document.querySelectorAll('.ind-tab').forEach((tab, i) => {
        tab.addEventListener('click', () => indGoTo(i));
    });

    // Auto cycle industries
    let indHovered = false;
    document.querySelector('.industries-section')?.addEventListener('mouseenter', () => indHovered = true);
    document.querySelector('.industries-section')?.addEventListener('mouseleave', () => indHovered = false);
    setInterval(() => {
        if (!indHovered) indGoTo((indIdx + 1) % 8);
    }, 4000);

    // FLOATING AI BUTTON 
    document.querySelector('.fab-ai')?.addEventListener('click', (e) => {
        e.preventDefault();
        const aiSection = document.querySelector('.ai-section');
        if (aiSection) aiSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

}); 