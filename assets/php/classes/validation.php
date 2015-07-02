<?php

class validation {

    public static function required($value){
        return (self::min_length($value, 1) || filter_var($value, FILTER_VALIDATE_BOOLEAN)) && !is_null($value) & !empty($value);
    }

    public static function max_length($value, $max_length, $mb = true) {
        if ($mb){
            $length = mb_strlen($value);
        }else{
            $length = strlen($value);
        }

        return $length <= $max_length || empty($value);
    }

    public static function min_length($value, $min_length, $mb = true) {
        if ($mb){
            $length = mb_strlen($value);
        }else{
            $length = strlen($value);
        }

        return $length >= $min_length || empty($value);
    }

    public static function valid_email($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL) || empty($value);
    }

    public static function valid_phone($value) {
        return (bool) preg_match("/^((8|\+7|7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/", $value) || empty($value);
    }
}