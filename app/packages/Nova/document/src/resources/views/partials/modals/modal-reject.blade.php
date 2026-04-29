{{-- partials/modals/modal-reject.blade.php --}}

<div class="doc-modal-overlay" id="modal-reject">
    <div class="doc-modal doc-modal-sm">
        <div class="doc-modal-head">
            <div class="doc-modal-title">Từ chối tài liệu</div>
            <button class="doc-btn doc-btn-ghost doc-btn-icon" onclick="closeModal('modal-reject')">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('documents.approvals.reject', $document) }}">
            @csrf
            <div class="doc-modal-body">
                <div class="doc-alert doc-alert-error">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        Tài liệu sẽ bị trả về trạng thái <strong>Từ chối</strong>. Nhân viên sẽ cần chỉnh sửa và gửi lại.
                    </div>
                </div>

                <div class="doc-form-group">
                    <label class="doc-form-label" for="reject-note">Lý do từ chối *</label>
                    <textarea
                        class="doc-textarea"
                        id="reject-note"
                        name="note"
                        rows="4"
                        placeholder="Nêu rõ lý do để nhân viên có thể chỉnh sửa đúng hướng..."
                        required
                    ></textarea>
                </div>
            </div>

            <div class="doc-modal-foot">
                <button type="button" class="doc-btn doc-btn-secondary" onclick="closeModal('modal-reject')">Huỷ</button>
                <button type="submit" class="doc-btn doc-btn-danger">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Xác nhận từ chối
                </button>
            </div>
        </form>
    </div>
</div>