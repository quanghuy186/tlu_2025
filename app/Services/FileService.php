<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Save an uploaded file
     *
     * @param UploadedFile $file
     * @return string The file URL
     */
    public function saveFile(UploadedFile $file)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = 'messages/' . date('Y/m/d');
        
        $file->storeAs('public/' . $path, $filename);
        
        return Storage::url($path . '/' . $filename);
    }

    /**
     * Determine message type based on file MIME type
     *
     * @param string $mimeType
     * @return string
     */
    public function getFileType(string $mimeType): string
    {
        if (strpos($mimeType, 'image/') === 0) {
            return 'image';
        }
        
        if (strpos($mimeType, 'video/') === 0) {
            return 'video';
        }
        
        if (strpos($mimeType, 'audio/') === 0) {
            return 'audio';
        }
        
        return 'file';
    }
}