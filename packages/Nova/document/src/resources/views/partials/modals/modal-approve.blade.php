{{-- partials/modals/modal-approve.blade.php --}}

<div class="doc-modal-overlay" id="modal-approve">
    <div class="doc-modal doc-modal-sm">
        <div class="doc-modal-head">
            <div class="doc-modal-title">@lang('documents::app.modals.approve_title')</div>
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
                        {{ __('documents::app.modals.approve_body', ['name' => $document->file_name]) }}
                    </div>
                </div>

                <div class="doc-form-group">
                    <label class="doc-form-label" for="approve-note">@lang('documents::app.modals.approve_note')</label>
                    <textarea
                        class="doc-textarea"
                        id="approve-note"
                        name="note"
                        rows="3"
                        placeholder="@lang('documents::app.modals.approve_note_placeholder')"
                    ></textarea>
                </div>
            </div>

            <div class="doc-modal-foot">
                <button type="button" class="doc-btn doc-btn-secondary" onclick="closeModal('modal-approve')">@lang('documents::app.common.cancel')</button>
                <button type="submit" class="doc-btn doc-btn-success">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    @lang('documents::app.modals.approve_submit')
                </button>
            </div>
        </form>
    </div>
</div>
