<?php

namespace STukenov\NovaCKEditor5Classic\Jobs;

use STukenov\NovaCKEditor5Classic\Models\PendingAttachment;

class PruneStaleAttachments
{
    /**
     * Prune the stale attachments from the system.
     *
     * @return void
     */
    public function __invoke()
    {
        config('ckeditor5Classic.pending_attachment_model')::where('created_at', '<=', now()->subDays(1))
            ->orderBy('id', 'desc')
            ->chunk(100, function ($attachments): void {
                $attachments->each->purge();
            });
    }
}
