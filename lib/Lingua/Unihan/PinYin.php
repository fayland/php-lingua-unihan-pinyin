<?php

namespace Lingua\Unihan;

/**
 * Pinyin.php
 *
 * @author Fayland Lam <fayland@gmail.com>
 * @date   [2015-05-23]
 */

class PinYin {
    protected static $dictionary;
    protected static $settings = array(
        'delimiter' => ' ',
        'tone'      => true
    );
    private static $_instance;

    private function __construct() {
        if (is_null(static::$dictionary)) {
            $dict = array();

            $file = file_get_contents(__DIR__ . '/data/Mandarin.dat');
            $lines = explode("\n", $file);
            foreach ($lines as $l) {
                if (! strlen(trim($l))) continue;
                $xxx = preg_split('/\s+/', $l, 2);
                $dict[$xxx[0]] = $xxx[1];
            }

            self::$dictionary = $dict;
        }
    }

    private function __clone() {}

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new static;
        }

        return self::$_instance;
    }

    public static function set($key, $value) {
        static::$settings[$key] = $value;
    }

    public static function settings(array $settings = array()) {
        static::$settings = array_merge(static::$settings, $settings);
    }

    public static function pinyin($string, array $settings = array()) {
        $instance = static::getInstance();
        $settings = array_merge(self::$settings, $settings);

        $dict = self::$dictionary;

        $all = array();
        preg_match_all('/([\x00-\x7F]+)|(.)/u', $string, $matches);
        foreach ($matches[0] as $m) {
            $m2 = strtoupper(bin2hex(iconv('UTF-8', 'UTF-16BE', $m)));
            if (isset($dict[$m2])) {
                $xxx = $dict[$m2];
                $zzz = mb_split('/\s+/', $xxx, 2);
                // print "$m -> $m2 -> $xxx -> $zzz[0]\n";
                if ($settings['tone']) {
                    $all[] = $zzz[0];
                } else {
                    $all[] = $instance->removeTone($zzz[0]);
                }
            } else {
                $all[] = $m;
            }
        }

        return implode($settings['delimiter'], $all);
    }

    public static function polyphone($word, array $settings = array()) {
        $instance = static::getInstance();
        $settings = array_merge(self::$settings, $settings);

        $dict = self::$dictionary;

        $m2 = bin2hex(iconv('UTF-8', 'UTF-16BE', $m));
        if (! isset($dict[$m2])) return;

        if ($settings['tone']) {
            return $dict[$m2];
        } else {
            return $instance->removeTone($dict[$m2]);
        }
    }

    protected function removeTone($string)
    {
        $pinyin = array(
            1 => array('ā', 'ē', 'ī', 'ō', 'ū', 'ǖ', 'Ā', 'Ē', 'Ī', 'Ō', 'Ū', 'Ǖ'),
            2 => array('á', 'é', 'í', 'ó', 'ú', 'ǘ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ǘ'),
            3 => array('ǎ', 'ě', 'ǐ', 'ǒ', 'ǔ', 'ǚ', 'Ǎ', 'Ě', 'Ǐ', 'Ǒ', 'Ǔ', 'Ǚ'),
            4 => array('à', 'è', 'ì', 'ò', 'ù', 'ǜ', 'À', 'È', 'Ì', 'Ò', 'Ù', 'Ǜ'),
            5 => array('a', 'e', 'i', 'o', 'u', 'ü', 'A', 'E', 'I', 'O', 'U', 'Ü')
        );

        foreach (array(1, 2, 3, 4) as $i) {
            $string = str_replace($pinyin[$i], $pinyin[5], $string);
        }

        return $string;
    }
}