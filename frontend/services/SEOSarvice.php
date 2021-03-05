<?php

namespace frontend\services;


class SEOSarvice
{
    public static function setHeaderLastModified($LastModified_unix = null)
    {
        $LastModified_unix = $LastModified_unix == null ? (time() - (60*60*24*7)) : $LastModified_unix;
        //$LastModified_unix = time();//strtotime($product['date_modified']); // 1601386944
        $LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
        $IfModifiedSince = false;
        if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
            $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
            $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
        if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            exit;
        }
        header('Last-Modified: ' . $LastModified);
    }
}
