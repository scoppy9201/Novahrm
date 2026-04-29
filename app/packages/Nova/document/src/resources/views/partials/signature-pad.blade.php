{{-- partials/signature-pad.blade.php --}}

<div class="doc-detail-card" id="signature-pad-card">
    <div class="doc-detail-card-head">
        <div class="doc-detail-card-title">Ký tài liệu</div>
        <span class="doc-badge doc-badge-signing">Chờ ký</span>
    </div>
    <div class="doc-detail-card-body">

        {{-- Bước hiển thị --}}
        <div class="sig-steps" style="display:flex;align-items:center;margin-bottom:16px">
            <div class="sig-step active" id="step-indicator-1">
                <div class="sig-step-num">1</div>
                <div class="sig-step-label">Vẽ chữ ký</div>
            </div>
            <div class="sig-step-line"></div>
            <div class="sig-step" id="step-indicator-2">
                <div class="sig-step-num">2</div>
                <div class="sig-step-label">Chọn vị trí</div>
            </div>
            <div class="sig-step-line"></div>
            <div class="sig-step" id="step-indicator-3">
                <div class="sig-step-num">3</div>
                <div class="sig-step-label">Xác nhận OTP</div>
            </div>
        </div>
        <div class="doc-alert doc-alert-info" style="margin-bottom:14px">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <div style="font-size:11.5px;line-height:1.6">
                Vẽ chữ ký bên dưới, sau đó chọn <strong>vị trí đặt chữ ký</strong> trên tài liệu PDF.
            </div>
        </div>

        <div class="doc-sig-wrap">
            <div class="doc-sig-canvas-wrap" id="sig-wrap" style="height:140px">
                <canvas id="sig-canvas" class="doc-sig-canvas" height="140"></canvas>
                <div class="doc-sig-placeholder">
                    <span class="doc-sig-placeholder-text">Vẽ chữ ký của bạn tại đây</span>
                </div>
            </div>

            <div class="doc-sig-actions">
                <span class="doc-sig-hint">Dùng chuột hoặc ngón tay để vẽ chữ ký</span>
                <button type="button" class="doc-btn doc-btn-secondary doc-btn-sm" id="btn-clear-sig">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Xoá
                </button>
            </div>
        </div>

        <div style="margin-top:14px">
            <button type="button" class="doc-btn doc-btn-primary" style="width:100%" id="btn-pick-position" disabled>
                <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Tiếp theo — Chọn vị trí ký
            </button>
        </div>

    </div>
</div>

{{-- MODAL CHỌN VỊ TRÍ KÝ --}}
<div class="doc-modal-overlay" id="modal-position-picker">
    <div class="doc-modal doc-modal-lg" style="max-width:860px;max-height:90vh;display:flex;flex-direction:column">
        <div class="doc-modal-head" style="flex-shrink:0">
            <div>
                <div class="doc-modal-title">Chọn vị trí đặt chữ ký</div>
                <div style="font-size:11.5px;color:var(--doc-text-faint);margin-top:2px">
                    Click vào vị trí bạn muốn đặt chữ ký trên tài liệu
                </div>
            </div>
            <button class="doc-btn doc-btn-ghost doc-btn-icon" onclick="closePicker()">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Toolbar --}}
        <div style="padding:10px 22px;border-bottom:1px solid var(--doc-border);display:flex;align-items:center;gap:12px;flex-shrink:0;background:var(--doc-surface)">
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:11px;font-weight:700;color:var(--doc-text-faint);text-transform:uppercase;letter-spacing:0.06em">Trang</span>
                <button class="doc-btn doc-btn-secondary doc-btn-sm doc-btn-icon" id="btn-prev-page" disabled>
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <span style="font-size:12.5px;font-weight:700;color:var(--doc-text-dark)" id="page-indicator">1 / 1</span>
                <button class="doc-btn doc-btn-secondary doc-btn-sm doc-btn-icon" id="btn-next-page">
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>

            <div style="width:1px;height:20px;background:var(--doc-border)"></div>

            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:11px;font-weight:700;color:var(--doc-text-faint);text-transform:uppercase;letter-spacing:0.06em">Zoom</span>
                <button class="doc-btn doc-btn-secondary doc-btn-sm doc-btn-icon" id="btn-zoom-out">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                </button>
                <span style="font-size:12px;font-weight:700;color:var(--doc-text-dark);min-width:40px;text-align:center" id="zoom-label">100%</span>
                <button class="doc-btn doc-btn-secondary doc-btn-sm doc-btn-icon" id="btn-zoom-in">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                </button>
            </div>

            <div style="margin-left:auto;display:flex;align-items:center;gap:8px">
                <div id="position-status" style="font-size:11.5px;color:var(--doc-text-faint);display:none">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:#22c55e;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;display:inline-block;vertical-align:middle;margin-right:4px"><polyline points="20 6 9 17 4 12"/></svg>
                    Đã chọn vị trí trang <strong id="chosen-page">1</strong>
                </div>
            </div>
        </div>

        {{-- PDF Canvas area --}}
        <div style="flex:1;overflow:auto;padding:16px;background:#e2e8f0;display:flex;justify-content:center" id="pdf-scroll-area">
            <div style="position:relative;display:inline-block" id="pdf-container">
                <canvas id="pdf-canvas" style="display:block;box-shadow:0 4px 20px rgba(0,0,0,0.15);cursor:crosshair"></canvas>
                {{-- Overlay bắt click --}}
                <div id="pdf-click-overlay" style="position:absolute;inset:0;cursor:crosshair"></div>
                {{-- Preview chữ ký --}}
                <div id="sig-preview-box" style="
                    position:absolute;
                    display:none;
                    border:2px dashed var(--doc-primary);
                    background:rgba(255,255,255,0.85);
                    border-radius:4px;
                    pointer-events:none;
                    padding:2px;
                    box-shadow:0 2px 8px rgba(29,78,216,0.2);
                ">
                    <img id="sig-preview-img" style="display:block;width:100%;height:100%;object-fit:contain"/>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="doc-modal-foot" style="flex-shrink:0">
            <div style="font-size:11.5px;color:var(--doc-text-faint)">
                💡 Click vào PDF để đặt chữ ký. Kéo để di chuyển sau khi đặt.
            </div>
            <button type="button" class="doc-btn doc-btn-secondary" onclick="closePicker()">Huỷ</button>
            <button type="button" class="doc-btn doc-btn-primary" id="btn-confirm-position" disabled>
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Xác nhận vị trí — Ký ngay
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    let pdfDoc      = null;
    let currentPage = 1;
    let totalPages  = 1;
    let scale       = 1.2;
    let sigImage    = null;

    // Vị trí chữ ký (tọa độ PDF point, gốc bottom-left)
    let chosenPos   = null; // { page, pdfX, pdfY, pdfW, pdfH }

    // Kích thước chữ ký mặc định (đơn vị PDF point)
    const SIG_W = 120;
    const SIG_H = 40;

    // Canvas vẽ chữ ký 
    const canvas    = document.getElementById('sig-canvas');
    const wrap      = document.getElementById('sig-wrap');
    const btnClear  = document.getElementById('btn-clear-sig');
    const btnPick   = document.getElementById('btn-pick-position');
    const ctx       = canvas.getContext('2d');
    let drawing = false, hasSig = false;

    function resize() {
        const rect = wrap.getBoundingClientRect();
        const dpr  = window.devicePixelRatio || 1;
        canvas.width  = rect.width * dpr;
        canvas.height = 140 * dpr;
        canvas.style.width  = rect.width + 'px';
        canvas.style.height = '140px';
        ctx.scale(dpr, dpr);
        ctx.strokeStyle = '#0f172a';
        ctx.lineWidth   = 2;
        ctx.lineCap     = 'round';
        ctx.lineJoin    = 'round';
    }
    resize();
    window.addEventListener('resize', resize);

    function getPos(e) {
        const r   = canvas.getBoundingClientRect();
        const src = e.touches ? e.touches[0] : e;
        return { x: src.clientX - r.left, y: src.clientY - r.top };
    }

    canvas.addEventListener('mousedown',  e => { e.preventDefault(); drawing = true; const p = getPos(e); ctx.beginPath(); ctx.moveTo(p.x, p.y); });
    canvas.addEventListener('mousemove',  e => { if (!drawing) return; e.preventDefault(); const p = getPos(e); ctx.lineTo(p.x, p.y); ctx.stroke(); markHasSig(); });
    canvas.addEventListener('mouseup',    () => drawing = false);
    canvas.addEventListener('mouseleave', () => drawing = false);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); drawing = true; const p = getPos(e); ctx.beginPath(); ctx.moveTo(p.x, p.y); }, { passive: false });
    canvas.addEventListener('touchmove',  e => { if (!drawing) return; e.preventDefault(); const p = getPos(e); ctx.lineTo(p.x, p.y); ctx.stroke(); markHasSig(); }, { passive: false });
    canvas.addEventListener('touchend',   () => drawing = false);

    function markHasSig() {
        if (!hasSig) {
            hasSig = true;
            wrap.classList.add('has-signature');
            btnPick.disabled = false;
        }
    }

    btnClear.addEventListener('click', () => {
        const dpr = window.devicePixelRatio || 1;
        ctx.clearRect(0, 0, canvas.width / dpr, canvas.height / dpr);
        hasSig = false;
        wrap.classList.remove('has-signature');
        btnPick.disabled = true;
        sigImage = null;
    });

    // Mở picker 
    btnPick.addEventListener('click', () => {
        sigImage = canvas.toDataURL('image/png');
        document.getElementById('sig-preview-img').src = sigImage;
        openModal('modal-position-picker');
        setStepActive(2);
        if (!pdfDoc) loadPdf();
    });

    window.closePicker = function() {
        closeModal('modal-position-picker');
        setStepActive(1);
    };

    // Load PDF bằng PDF.js 
    function loadPdf() {
        const pdfUrl = '{{ route('documents.preview', $document) }}';

        // Load PDF.js từ CDN nếu chưa có
        if (typeof pdfjsLib === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
            script.onload = () => {
                pdfjsLib.GlobalWorkerOptions.workerSrc =
                    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                doLoadPdf(pdfUrl);
            };
            document.head.appendChild(script);
        } else {
            doLoadPdf(pdfUrl);
        }
    }

    function doLoadPdf(url) {
        pdfjsLib.getDocument(url).promise.then(pdf => {
            pdfDoc     = pdf;
            totalPages = pdf.numPages;
            currentPage = 1;
            renderPage(currentPage);
            updatePageControls();
        }).catch(err => {
            console.error('PDF load error:', err);
        });
    }

    function renderPage(pageNum) {
        pdfDoc.getPage(pageNum).then(page => {
            const viewport = page.getViewport({ scale });
            const pdfCanvas = document.getElementById('pdf-canvas');
            const pdfCtx    = pdfCanvas.getContext('2d');

            pdfCanvas.width  = viewport.width;
            pdfCanvas.height = viewport.height;
            pdfCanvas.style.width  = viewport.width  + 'px';
            pdfCanvas.style.height = viewport.height + 'px';

            page.render({ canvasContext: pdfCtx, viewport }).promise.then(() => {
                // Nếu đã chọn vị trí ở trang này thì hiển thị lại preview
                if (chosenPos && chosenPos.page === pageNum) {
                    showPreviewAt(chosenPos.screenX, chosenPos.screenY);
                } else {
                    document.getElementById('sig-preview-box').style.display = 'none';
                }
            });
        });
    }

    // Click chọn vị trí 
    document.getElementById('pdf-click-overlay').addEventListener('click', function(e) {
        const pdfCanvas = document.getElementById('pdf-canvas');
        const rect      = pdfCanvas.getBoundingClientRect();

        const screenX = e.clientX - rect.left;
        const screenY = e.clientY - rect.top;

        // Chuyển tọa độ screen → PDF point (gốc bottom-left)
        const pdfX = screenX / scale;
        const pdfY = screenY / scale; 

        chosenPos = {
            page:    currentPage,
            pdfX:    Math.max(0, pdfX),
            pdfY:    Math.max(0, pdfY),
            pdfW:    SIG_W,
            pdfH:    SIG_H,
            screenX: screenX,
            screenY: screenY,
        };

        showPreviewAt(screenX, screenY);

        // Cập nhật status
        document.getElementById('position-status').style.display = 'flex';
        document.getElementById('chosen-page').textContent = currentPage;
        document.getElementById('btn-confirm-position').disabled = false;
    });

    // Hiện preview chữ ký tại vị trí click 
    function showPreviewAt(screenX, screenY) {
        const pdfCanvas = document.getElementById('pdf-canvas');
        const previewW  = SIG_W * scale;
        const previewH  = SIG_H * scale;

        // Căn giữa preview vào điểm click
        let left = screenX - previewW / 2;
        let top  = screenY - previewH / 2;

        // Giữ trong bounds
        left = Math.max(0, Math.min(left, pdfCanvas.width  - previewW));
        top  = Math.max(0, Math.min(top,  pdfCanvas.height - previewH));

        const box = document.getElementById('sig-preview-box');
        box.style.left    = left + 'px';
        box.style.top     = top  + 'px';
        box.style.width   = previewW + 'px';
        box.style.height  = previewH + 'px';
        box.style.display = 'block';

        // Cập nhật screenX/Y sau khi clamp
        if (chosenPos) {
            chosenPos.screenX = left + previewW / 2;
            chosenPos.screenY = top  + previewH / 2;
        }
    }

    // Phân trang 
    function updatePageControls() {
        document.getElementById('page-indicator').textContent = `${currentPage} / ${totalPages}`;
        document.getElementById('btn-prev-page').disabled = currentPage <= 1;
        document.getElementById('btn-next-page').disabled = currentPage >= totalPages;
    }

    document.getElementById('btn-prev-page').addEventListener('click', () => {
        if (currentPage > 1) { currentPage--; renderPage(currentPage); updatePageControls(); }
    });
    document.getElementById('btn-next-page').addEventListener('click', () => {
        if (currentPage < totalPages) { currentPage++; renderPage(currentPage); updatePageControls(); }
    });

    // Zoom
    document.getElementById('btn-zoom-in').addEventListener('click', () => {
        if (scale < 2.5) { scale = Math.round((scale + 0.2) * 10) / 10; updateZoom(); }
    });
    document.getElementById('btn-zoom-out').addEventListener('click', () => {
        if (scale > 0.6) { scale = Math.round((scale - 0.2) * 10) / 10; updateZoom(); }
    });
    function updateZoom() {
        document.getElementById('zoom-label').textContent = Math.round(scale * 100) + '%';
        renderPage(currentPage);
    }

    // Xác nhận vị trí → mở OTP 
    document.getElementById('btn-confirm-position').addEventListener('click', () => {
        if (!chosenPos) return;

        // Lấy kích thước thật của trang PDF (đơn vị point)
        pdfDoc.getPage(chosenPos.page).then(page => {
            const viewport = page.getViewport({ scale: 1 }); 
            const pageWidthPt  = viewport.width;  
            const pageHeightPt = viewport.height;

            // Tọa độ screen (đã scale) → PDF point gốc
            const pdfX = (chosenPos.screenX - SIG_W * scale / 2) / scale;
            const pdfY = (chosenPos.screenY - SIG_H * scale / 2) / scale;

            // PDF point → mm  (1 point = 25.4/72 mm)
            const PT_TO_MM = 25.4 / 72;
            const mmX = pdfX * PT_TO_MM;
            const mmY = pdfY * PT_TO_MM;
            const mmW = SIG_W * PT_TO_MM;
            const mmH = SIG_H * PT_TO_MM;

            // Clamp trong trang
            const pageMmW = pageWidthPt  * PT_TO_MM;
            const pageMmH = pageHeightPt * PT_TO_MM;

            document.getElementById('hidden-signature-image').value = sigImage;
            document.getElementById('hidden-page-number').value     = chosenPos.page;
            document.getElementById('hidden-pos-x').value           = Math.max(0, Math.min(mmX, pageMmW - mmW)).toFixed(2);
            document.getElementById('hidden-pos-y').value           = Math.max(0, Math.min(mmY, pageMmH - mmH)).toFixed(2);
            document.getElementById('hidden-width').value           = mmW.toFixed(2);
            document.getElementById('hidden-height').value          = mmH.toFixed(2);

            closeModal('modal-position-picker');
            openModal('modal-otp');
            setStepActive(3);
        });
    });

    // Step indicator 
    function setStepActive(step) {
        [1, 2, 3].forEach(i => {
            const el = document.getElementById(`step-indicator-${i}`);
            el.classList.remove('active', 'done');
            if (i < step)  el.classList.add('done');
            if (i === step) el.classList.add('active');
        });
    }

})();
</script>