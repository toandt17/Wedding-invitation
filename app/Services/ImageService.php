<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function getOptimizedImageUrl(string $originalUrl, array $options = []): string
    {
        $width = $options['width'] ?? 800;
        $quality = $options['quality'] ?? 80;

        $cacheKey = "image_" . md5($originalUrl . $width . $quality);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($originalUrl, $width, $quality) {
            try {
                // Tạo tên file mới cho ảnh đã tối ưu
                $pathInfo = pathinfo($originalUrl);
                $optimizedPath = 'optimized/' . $pathInfo['filename'] . '_' . $width . 'w_' . $quality . 'q.' . $pathInfo['extension'];

                // Kiểm tra nếu ảnh đã được tối ưu
                if (!file_exists(public_path($optimizedPath))) {
                    // Tải và tối ưu ảnh
                    $image = Image::make($originalUrl);
                    $image->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    // Lưu ảnh đã tối ưu
                    $image->save(public_path($optimizedPath), $quality);
                }

                return asset($optimizedPath);
            } catch (\Exception $e) {
                return $originalUrl; // Trả về URL gốc nếu có lỗi
            }
        });
    }
}
