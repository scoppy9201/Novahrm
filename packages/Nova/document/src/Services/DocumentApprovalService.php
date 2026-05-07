<?php

namespace Nova\document\Services;

use Nova\document\Models\Document;
use Nova\document\Models\DocumentApproval;

class DocumentApprovalService
{
    public function approve(Document $document, int $actorId, ?string $note): void
    {
        $nextStatus = $document->category->requires_signature ? 'signing' : 'approved';

        $document->update(['status' => $nextStatus]);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $actorId,
            'action'      => 'approved',
            'note'        => $note,
        ]);
    }

    public function reject(Document $document, int $actorId, ?string $note): void
    {
        $document->update(['status' => 'rejected']);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $actorId,
            'action'      => 'rejected',
            'note'        => $note,
        ]);
    }

    public function requestRevision(Document $document, int $actorId, string $note): void
    {
        $document->update(['status' => 'draft']);

        DocumentApproval::create([
            'document_id' => $document->id,
            'actor_id'    => $actorId,
            'action'      => 'revision_requested',
            'note'        => $note,
        ]);
    }
}