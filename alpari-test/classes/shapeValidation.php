<?php

namespace classes;

/**
 * Class shapeValidation
 *
 * Some validation staff
 *
 * @package classes
 */
class shapeValidation
{
    /**
     * @param $value
     * @return bool
     */
    public static function validateRequired($value)
    {
        $result = false;
        if (!isset($value))
            $result = "Validation required error";
        return $result;
    }

    /**
     * @param $value
     * @return bool
     */
    public static function validateInteger($value)
    {
        $result = false;
        if (!is_int($value))
        {
            $result = "{$value} : validate integer error";
        }

        return $result;
    }


    /**
     * Validate the dimensions of the shapes
     *
     * @param $value
     * @return bool|string
     */
    public static function validateDimension($value)
    {
        $result = false;
        if (!in_array($value, ['2d', '3d']))
        {
            $result = "{$value} : validate dimension error";
        }
        return $result;
    }

    /**
     * Calls for validation errors
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        if (!method_exists(__CLASS__, $name))
        {
            $var = $arguments[0];
            $validator = $arguments[1] . 'Validation';
            if (!class_exists($validator) OR !method_exists($validator, $name))
            {
                $error = \classes\shapeErrors::getInstance();
                $error->add($validator, "Bad validation class or method", " {$validator}::{$name}()");

                return true;
            }
            else
            {
                return $validator::$name($var);
            }
        }
    }
}