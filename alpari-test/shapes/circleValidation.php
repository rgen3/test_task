<?php

namespace shapes;

/**
 * Class circleValidation
 *
 * Custom validation class for a shape
 *
 * @package shapes
 */
class circleValidation extends \classes\shapeValidation
{
    /**
     * Custom validation method
     *
     * @param $value
     * @return bool
     */
    public static function validateCustom($value)
    {
        return false;
    }
}