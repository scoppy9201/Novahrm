{{-- partials/modals/modal-approve.blade.php --}}

<div class="doc-modal-overlay" id="modal-approve">
    <div class="doc-modal doc-modal-sm">
        <div class="doc-modal-head">
            <div class="doc-modal-title">Xác nhận phê duyệt</div>
            <button class="doc-btn doc-btn-ghost doc-btn-icon" onclick="closeModal('modal-approve')">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('documents.approvals.approve', $document) }}">
            @csrf
            <div class="doc-modal-body">
                <div class="doc-alert doc-alert-success">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    <div>
                        Bạn đang phê duyệt tài liệu <strong>{{ $document->file_name }}</strong>.
                        Hành động này sẽ được ghi lại vào lịch sử.
                    </div>
                </div>

                <div class="doc-form-group">
                    <label class="doc-form-label" for="approve-note">Ghi chú (tuỳ chọn)</label>
                    <textarea
                        class="doc-textarea"
                        id="approve-note"
                        name="note"
                        rows="3"
                        placeholder="Thêm ghi chú cho lần phê duyệt này..."
                    ></textarea>
                </div>
            </div>

            <div class="doc-modal-foot">
                <button type="button" class="doc-btn doc-btn-secondary" onclick="closeModal('modal-approve')">Huỷ</button>
                <button type="submit" class="doc-btn doc-btn-success">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Xác nhận duyệt
                </button>
            </div>
        </form>
    </div>
</div>