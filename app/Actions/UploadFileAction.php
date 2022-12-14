<?php

namespace App\Actions;

use App\Models\TemporaryFile;
use Illuminate\Support\Facades\Storage;
use Coderflex\LaravelTicket\Models\Ticket;

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

        if ($storage->exists('uploads/' . $ticket->id)) {
            $storage->deleteDirectory('uploads/' . $ticket->id);
        }
        
        $storage->move(
            'uploads/tmp/' . $folder . '/' . $temporaryFile->file_name, 
            'uploads/' . $ticket->id . '/' . $temporaryFile->file_name
        );
            
        $storage->deleteDirectory('uploads/tmp/' . $folder);
    }
}