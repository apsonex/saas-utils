<?php

use Carbon\Carbon;
use Illuminate\Http\Request;

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

if (!function_exists('imagick_installed')) {
    function imagick_installed(): bool
    {
        return extension_loaded('imagick') && class_exists('Imagick');
    }
}

if (!function_exists('valid_email')) {
    function valid_email($email): bool
    {
        $emailArray = explode('@', $email);

        return checkdnsrr(array_pop($emailArray), 'MX');
    }
}

if (!function_exists('array_to_file')) {
    function array_to_file(string $path, array $array): bool|int
    {
        return \Illuminate\Support\Facades\File::put(
            $path,
            "<?php\n" . "return " . var_export($array, true) . ";"
        );
    }
}

if (!function_exists('readable_random_string')) {
    function readable_random_string($words = 1, $length = 6): string
    {
        $string = '';
        for ($o = 1; $o <= $words; $o++) {
            $vowels = ["a", "e", "i", "o", "u"];
            $consonants = [
                'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
                'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
            ];

            $word = '';
            for ($i = 1; $i <= $length; $i++) {
                $word .= $consonants[rand(0, 19)];
                $word .= $vowels[rand(0, 4)];
            }
            $string .= mb_substr($word, 0, $length);
            $string .= "-";
        }
        return mb_substr($string, 0, -1);
    }
}

if (!function_exists('is_testing')) {
    function is_testing(): bool
    {
        return app()->environment('testing');
    }
}

if (!function_exists('public_disk')) {
    function public_disk(): \Illuminate\Contracts\Filesystem\Filesystem
    {
        return \Illuminate\Support\Facades\Storage::disk('public');
        // if (config('filesystems.default') == 'local') {
        //     return \Illuminate\Support\Facades\Storage::disk('public');
        // }

        // return config('filesystems.disks.s3_public') ?
        //     \Illuminate\Support\Facades\Storage::disk('s3_public') :
        //     ;
    }
}

if (!function_exists('array_filter_nulls')) {
    function array_filter_nulls(array $arr): array
    {
        return array_filter($arr, function ($value) {
            return !is_null($value);
        });
    }
}

if (!function_exists('encode_email')) {
    function encode_email(string $email): string
    {
        $output = '';

        for ($i = 0; $i < strlen($email); $i++) {
            $output .= '&#' . ord($email[$i]) . ';';
        }
        return $output;
    }
}

if (!function_exists('create_from_format_to_utc')) {
    function create_from_format_to_utc($datetime, $timezone, $format = 'Y-m-d'): Carbon|null
    {
        if (!$datetime) return null;

        $instance = \Illuminate\Support\Carbon::createFromFormat($format, $datetime, $timezone)->utc();

        if ($instance instanceof Carbon) {
            return $instance;
        }

        return null;
    }
}

if (!function_exists('number_to_spell')) {
    function number_to_spell($number = null): ?int
    {
        if (!$number) return null;

        return (new \NumberFormatter('en', NumberFormatter::SPELLOUT))->format((int)$number);
    }
}

if (!function_exists('per_page_limit')) {
    function per_page_limit(Request $request, int $defaultLimit = 10, int $limit = 500, $pageName = 'per_page'): int
    {
        $perPage = $request->get($pageName, $defaultLimit);

        return (int)($perPage > $limit ? $defaultLimit : $perPage);
    }
}