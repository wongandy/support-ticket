<?php

namespace App\Actions;

use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;

class UploadFileAction
{
    public function execute(Ticket $ticket, string $folder): void
    {
        $temporaryFile = TemporaryFile::where('folder', $folder)->first();
        
        $ticket->update([
            'upload' => $temporaryFile->file_name,
        ]);
        
        $temporaryFile->delete();

        $storage = Storage::disk('public');

        if ($ticket->getFirstMedia('tickets_attachments')) {
            if ($storage->exists($ticket->getFirstMedia('tickets_attachments')->id)) {
                $storage->deleteDirectory($ticket->getFirstMedia('tickets_attachments')->id);
            }

            $ticket->getFirstMedia('tickets_attachments')->delete();
        }

        $ticket->addMedia(storage_path('app/public/uploads/tmp/' . $folder . '/' . $temporaryFile->file_name))->toMediaCollection('tickets_attachments');
            
        $storage->deleteDirectory('uploads/tmp/' . $folder);
    }
}