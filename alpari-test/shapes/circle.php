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
        'background' => 'integer',
    ];

    /**
     * Draw a circle
     */
    public function draw()
    {
        printf("We draw a circle with params \n %s \n", print_r(self::$validation_params, true));
    }

}