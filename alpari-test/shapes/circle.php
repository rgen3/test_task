<?php

namespace shapes;

class circle extends \classes\shapeAbstract
{
    /**
     * @var array
     */
    protected static $validation_params = [
        'radius'     => 'required',
        'custom'     => 'custom',
        'color'      => 'integer',
        'background' => 'integer'
    ];

    /**
     *
     */
    public function draw()
    {
        printf("We draw a circle with params \n %s \n", print_r(self::$validation_params, true));
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validateCustom($value)
    {
        // Here goes custom validation rule
        return false;
    }
}