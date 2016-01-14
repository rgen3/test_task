<?php

namespace bootstrap;

use classes\shapeFactory as Factory;

class bootstrap
{
    /**
     * Input data
     *
     * @var array
     */
    private static $data = [
        [
            'type' => 'circle',
            'properties' => [
                'radius' => 'value one',
                'custom' => 'value two',
                'color' => 123,
                'background' => 213
            ]
        ],
        [
            'type' => 'square',
            'properties' => [
                'color' => 333
            ]
        ],
        [
            'type' => 'incorrect_type',
            'properties' => [
                'color' => 333
            ]
        ],
        [
            'type' => 'triangle',
            'properties' => [
                'smth' => 23
            ]
        ]
    ];

    /**
     * Run the script
     */
    public static function run()
    {
        $data = self::getData();

        while (list($key, $array) = each($data))
        {
            $shape = Factory::create($array['type'], $array['properties']);

            if ($shape === false)
                break;

            if (($errors = $shape->create()) instanceof \classes\shapeErrors)
            {
                echo $errors;
                break;
            }
        }

    }

    /**
     * Process and get the input data
     *
     * @return array
     */
    protected static function getData()
    {
        // data process here
        return self::$data;
    }

}