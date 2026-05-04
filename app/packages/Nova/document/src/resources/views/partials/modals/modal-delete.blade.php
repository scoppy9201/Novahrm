{{-- partials/modals/modal-delete.blade.php --}}

<div class="doc-modal-overlay" id="modal-delete">
    <div class="doc-modal doc-modal-sm">
        <div class="doc-modal-head">
            <div class="doc-modal-title">@lang('documents::app.modals.delete_title')</div>
            <button class="doc-btn doc-btn-ghost doc-btn-icon" onclick="closeModal('modal-delete')">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="doc-modal-body">
            <div class="doc-alert doc-alert-error">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                <div>
                    {{ __('documents::app.modals.delete_body', ['name' => $document->file_name]) }}
                </div>
            </div>
        </div>

        <div class="doc-modal-foot">
            <button type="button" class="doc-btn doc-btn-secondary" onclick="closeModal('modal-delete')">@lang('documents::app.common.cancel')</button>
            <form method="POST" action="{{ route('documents.destroy', $document) }}" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="doc-btn doc-btn-danger">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    @lang('documents::app.modals.delete_submit')
                </button>
            </form>
        </div>
    </div>
</div>
