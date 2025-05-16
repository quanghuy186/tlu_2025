<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Lưu file được upload.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @return string
     */
    public function saveFile(UploadedFile $file, string $directory = 'message_files'): string
    {
        $fileName = time() . '_' . Str::random(10) . '_' . $file->getClientOriginalName();
        $path = $file->storeAs($directory, $fileName, 'public');
        
        return Storage::url($path);
    }

    /**
     * Xác định loại tệp dựa trên mime type.
     *
     * @param string $mimeType
     * @return string
     */
    public function getFileType(string $mimeType): string
    {
        if (Str::startsWith($mimeType, 'image/')) {
            return 'image';
        } elseif (Str::startsWith($mimeType, 'video/')) {
            return 'video';
        } elseif (Str::startsWith($mimeType, 'audio/')) {
            return 'audio';
        } elseif (in_array($mimeType, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ])) {
            return 'document';
        } else {
            return 'file';
        }
    }

    /**
     * Lấy kích thước file ở định dạng đọc được.
     *
     * @param int $bytes
     * @return string
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $i = 0;
        while ($bytes > 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Xoá file từ storage.
     *
     * @param string $fileUrl
     * @return bool
     */
    public function deleteFile(string $fileUrl): bool
    {
        $path = str_replace('/storage/', '', $fileUrl);
        return Storage::disk('public')->delete($path);
    }
}