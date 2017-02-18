<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 9:12 PM
 */

namespace UrlShorter\Libs;


class FileUtils
{
    /**
     * Join parts with directory separator.
     * @param mixed $parts
     * @return string
     */
    public static function join(...$parts)
    {
        $parts = array_filter($parts, function ($part) {
            return nullify($part) !== null;
        });

        if (count($parts) === 0) {
            return null;
        }

        return (starts_with(reset($parts), '/') ? '/' : '').implode(DIRECTORY_SEPARATOR, array_map(function ($part) {
            return trim($part, DIRECTORY_SEPARATOR);
        }, $parts));
    }
}
