<?php

namespace bootstrap;

use classes\shapeFactory as Factory;

class bootstrap
{
    /**
     * @var array
     */
    private static $data = [
        [
            'type' => 'circle',
            'properties' => [
                'property_one' => 'value one',
                'property_two' => 'value two',
                'property_three' => 'value three'
            ]
        ],
        [
            'type' => 'square',
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
     *
     */
    public static function run()
    {
        $data = self::getData();

        while (list($key, $array) = each($data))
        {
            $shape = Factory::create($array['type'], $array['properties']);

            if (!$shape)
            {
                // handle error
                continue;
            }
            $shape->draw();
        }

    }

    /**
     * @return array
     */
    protected static function getData()
    {
        // data process here
        return self::$data;
    }

}