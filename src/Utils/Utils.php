<?php

namespace Apsonex\SaasUtils\Utils;

class Utils
{

    /**
     * Check is email has valid mx record
     */
    public static function validEmail(string $email): bool
    {
        $emailArray = explode('@', $email);

        return checkdnsrr(array_pop($emailArray), 'MX');
    }

    /**
     * Check if imagick installed
     */
    public static function imagickInstalled(): bool
    {
        return extension_loaded('imagick') && class_exists('Imagick');
    }

    /**
     * Array to file
     */
    public static function arrayToFile(string $path, array $array): bool|int
    {
        return \Illuminate\Support\Facades\File::put(
            $path,
            "<?php\n" . "return " . var_export($array, true) . ";"
        );
    }

    /**
     * Random readable string
     */
    public static function readableRandomString($words = 1, $length = 6): string
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

    /**
     * Encode ids
     */
    public static function encodeId($id, $salt = null, $minLength = 8, $alphabets = null): string
    {
        return (new \Hashids\Hashids($salt ?: config('app.key'), $minLength ?: 8, $alphabets ?: 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmpqrstuvwxyz123456789'))->encode($id);
    }

    /**
     * Decode Ids
     */
    public static function decodeId($id, $salt = null, $minLength = 8, $alphabets = null): array
    {
        return (new \Hashids\Hashids($salt ?: config('app.key'), $minLength ?: 8, $alphabets ?: 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmpqrstuvwxyz123456789'))->decode($id);
    }

    /**
     * Check is string is a valid json
     */
    public static function isJson($string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Purify HTML String
     */
    public static function purifyHtmlString($string, $config = []): string
    {
        return \Stevebauman\Purify\Facades\Purify::clean($string, $config);
    }

    /**
     * Sanitize Input
     */
    public static function sanitizeInput($text = ''): string
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
            $string = $string->replace($v, $k);
        });

        return htmlspecialchars((string)$string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}