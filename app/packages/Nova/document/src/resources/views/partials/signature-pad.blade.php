{{-- partials/signature-pad.blade.php --}}
{{-- Usage: @include('document::partials.signature-pad', ['document' => $document]) --}}

<div class="doc-detail-card" id="signature-pad-card">
    <div class="doc-detail-card-head">
        <div class="doc-detail-card-title">Ký tài liệu</div>
        <span class="doc-badge doc-badge-signing">Chờ ký</span>
    </div>
    <div class="doc-detail-card-body">

        <div class="doc-alert doc-alert-info" style="margin-bottom:14px">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            <div style="font-size:11.5px;line-height:1.6">
                Vẽ chữ ký của bạn vào ô bên dưới, sau đó nhấn <strong>Ký ngay</strong> để xác nhận bằng OTP qua email.
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
            <button type="button" class="doc-btn doc-btn-primary" style="width:100%" id="btn-open-otp" disabled>
                <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Ký ngay — Xác nhận bằng OTP
            </button>
        </div>

    </div>
</div>

<script>
(function() {
    const canvas  = document.getElementById('sig-canvas');
    const wrap    = document.getElementById('sig-wrap');
    const btnClear  = document.getElementById('btn-clear-sig');
    const btnOpenOtp = document.getElementById('btn-open-otp');
    const ctx     = canvas.getContext('2d');
    let drawing   = false;
    let hasSig    = false;

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
        const r = canvas.getBoundingClientRect();
        const src = e.touches ? e.touches[0] : e;
        return { x: src.clientX - r.left, y: src.clientY - r.top };
    }

    function startDraw(e) {
        e.preventDefault();
        drawing = true;
        const p = getPos(e);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
    }

    function draw(e) {
        if (!drawing) return;
        e.preventDefault();
        const p = getPos(e);
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
        if (!hasSig) {
            hasSig = true;
            wrap.classList.add('has-signature');
            btnOpenOtp.disabled = false;
        }
    }

    function stopDraw() { drawing = false; }

    canvas.addEventListener('mousedown',  startDraw);
    canvas.addEventListener('mousemove',  draw);
    canvas.addEventListener('mouseup',    stopDraw);
    canvas.addEventListener('mouseleave', stopDraw);
    canvas.addEventListener('touchstart', startDraw, { passive: false });
    canvas.addEventListener('touchmove',  draw,      { passive: false });
    canvas.addEventListener('touchend',   stopDraw);

    btnClear.addEventListener('click', () => {
        const dpr = window.devicePixelRatio || 1;
        ctx.clearRect(0, 0, canvas.width / dpr, canvas.height / dpr);
        hasSig = false;
        wrap.classList.remove('has-signature');
        btnOpenOtp.disabled = true;
    });

    // Mở OTP modal + truyền signature image
    btnOpenOtp.addEventListener('click', () => {
        const sigImage = canvas.toDataURL('image/png');
        const hiddenSig = document.getElementById('hidden-signature-image');
        if (hiddenSig) hiddenSig.value = sigImage;
        openModal('modal-otp');
    });
})();
</script>