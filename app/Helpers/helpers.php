<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('image_url')) {
    /**
     * Get image URL from path (support local & Cloudinary)
     */
    function image_url($path, $default = null)
    {
        if (empty($path)) {
            return $default ?? asset('images/no-image.png');
        }

        // Kalau sudah full URL (Cloudinary), return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Gunakan Storage facade untuk generate URL
        try {
            return Storage::disk('public')->url($path);
        } catch (\Exception $e) {
            return $default ?? asset('images/no-image.png');
        }
    }
}
