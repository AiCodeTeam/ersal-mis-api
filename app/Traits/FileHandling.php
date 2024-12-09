<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileHandling
{
    /**
     * Upload a file and return its storage URL.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @param string|null $oldFilePath
     * @return string|null
     */
    public function uploadFile($file, $oldFilePath = null, $directory = null, )
    {
        if ($oldFilePath) {
            $this->deleteFile($oldFilePath);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');

        return $path ? asset('storage/' . $path) : null;
    }

    public function uploadFiles(array $files, string $directory = null)
    {
        $uploadedPaths = [];
    
        foreach ($files as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($directory, $filename, 'public');
    
            if ($path) {
                $uploadedPaths[] = asset('storage/' . $path);
            }
        }
    
        return $uploadedPaths;
    }


    /**
     * Delete a file from storage.
     *
     * @param string $filePath
     * @return void
     */
    public function deleteFile($filePath)
    {
        $relativePath = str_replace(asset('storage/'), '', $filePath);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
