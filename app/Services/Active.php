<?php namespace App\Services;

use Illuminate\Support\Str;
use Route;

class Active {

    public static function pattern($patterns, $activeClass = '', $inactiveClass = '')
    {
        $currentRequest = Route::current();
        if (!$currentRequest) {
            return $inactiveClass;
        }
        $uri = urldecode($currentRequest->getPath());
        if (!is_array($patterns)) {
            $patterns = [$patterns];
        }
        foreach ($patterns as $p) {
            if (str_is($p, $uri)) {
                return $activeClass;
            }
        }
        return $inactiveClass;
    }
}