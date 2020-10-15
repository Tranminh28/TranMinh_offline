<?php
class HelperBackend
{
    public static function formatDatetime($time, $format = 'd/m/Y H:i:s')
    {
        if ($time == NULL) return '';
        return date($format, strtotime($time));
    }
}