<?php

namespace common\services;

class UploadService
{
    public static function createImgWithBase64($pathWithName, $b64)
    {
        // Obtain the original content (usually binary data)
        $bin = base64_decode($b64);

        // Gather information about the image using the GD library
        $size = getImageSizeFromString($bin);

        // Check the MIME type to be sure that the binary data is an image
        if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
            die('Base64 value is not a valid image');
        }

        // Mime types are represented as image/gif, image/png, image/jpeg, and so on
        // Therefore, to extract the image extension, we subtract everything after the “image/” prefix
        $ext = substr($size['mime'], 6);

        // Make sure that you save only the desired file extensions
        if (!in_array($ext, ['png', 'jpeg', 'jpg', 'svg'])) {
            die('Unsupported image type');
        }

        // Specify the location where you want to save the image
        //$img_file = "$pathWithName.{$ext}";
        $ext = str_replace('jpeg', 'jpg', $ext);

        // Save binary data as raw data (that is, it will not remove metadata or invalid contents)
        // In this case, the PHP backdoor will be stored on the server
        $fullPath = $pathWithName . '.' . $ext;
        if (file_put_contents($fullPath, $bin)) {
            if($ext == 'jpg') {
                self::resizeJpg($fullPath, 228, 228, '-228x228.jpg');
                self::resizeJpg($fullPath, 500, 500, '-500x500.jpg');
            } elseif($ext == 'png') {
                self::resizePng($fullPath, 228, 228, '-228x228.png');
                self::resizePng($fullPath, 500, 500, '-500x500.png');
            }

            return $ext;
        } else {
            return false;
        }
    }

    public static function resizeJpg($filename, $width, $height, $extSize)
    {
        // получение новых размеров
        list($width_orig, $height_orig) = getimagesize($filename);
        $ratio_orig = $width_orig / $height_orig;
        if ($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }
        // ресэмплирование
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        // сохраняем
        imagejpeg($image_p, str_replace('.jpg', $extSize, $filename));
    }

    public static function resizePng($filename, $width, $height, $extSize)
    {
        list($width_orig, $height_orig) = getimagesize($filename);
        $ratio_orig = $width_orig/$height_orig;
        if ($width/$height > $ratio_orig) {
            $width = $height*$ratio_orig;
        } else {
            $height = $width/$ratio_orig;
        }
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefrompng($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
        imagepng($image_p, str_replace('.png', $extSize, $filename));
    }
}
