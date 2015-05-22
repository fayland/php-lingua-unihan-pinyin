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
        'delimiter'    => ' ',
        'accent'       => true
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
        preg_match_all('/./u', $string, $matches);
        foreach ($matches[0] as $m) {
            $m2 = strtoupper(bin2hex(iconv('UTF-8', 'UTF-16BE', $m)));
            if (isset($dict[$m2])) {
                $xxx = $dict[$m2];
                $zzz = mb_split('/\s+/', $xxx, 2);
                // print "$m -> $m2 -> $xxx -> $zzz[0]\n";
                $all[] = $zzz[0];
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

        return $dict[$m2];
    }
}