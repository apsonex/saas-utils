<?php

//

if (!function_exists('encode_id')) {
    function encode_id($id, $salt = null, $minLength = 8, $alphabets = null): string
    {
        return (new \Hashids\Hashids($salt ?: config('app.key'), $minLength ?: 8, $alphabets ?: 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmpqrstuvwxyz123456789'))->encode($id);
    }
}

if (!function_exists('decode_id')) {
    function decode_id($id, $salt = null, $minLength = 8, $alphabets = null): array
    {
        return (new \Hashids\Hashids($salt ?: config('app.key'), $minLength ?: 8, $alphabets ?: 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmpqrstuvwxyz123456789'))->decode($id);
    }
}

if (!function_exists('slack')) {
    function slack(): \Psr\Log\LoggerInterface
    {
        return Illuminate\Support\Facades\Log::channel('slack');
    }
}

if (!function_exists('is_json')) {
    function is_json($string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($text = ''): string
    {
        $string = str($text);

        $replacements = [
            // "&#34;" is shorter than "&quot;"
            '&quot;' => '&#34;',
            // Fix several potential issues in how browsers intepret attributes values
            '+'      => '&#43;',
            '#'      => '&#35;',
            '&'      => '&#38;',
            '<'      => '&#60;',
            '>'      => '&#62;',
            '?'      => '&#63;',
            '='      => '&#61;',
            '@'      => '&#64;',
            '`'      => '&#96;',
            '^'      => '&#94;',
            // Some DB engines will transform UTF8 full-width characters their classical version
            // if the data is saved in a non-UTF8 field
            //    '<'      => '&#xFF1C;',
            //    '>'      => '&#xFF1E;',
            //    '+'      => '&#xFF0B;',
            //    '='      => '&#xFF1D;',
            //    '@'      => '&#xFF20;',
            //    '`'      => '&#xFF40;',
        ];

        collect($replacements)->map(function ($k, $v) use (&$string) {
            $string = $string->replace($v, $k, $string);
        });

        return htmlspecialchars((string)$string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}