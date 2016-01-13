<?php

namespace classes;

use shapes;

class shapeFactory
{

    private static $shape_namespace = 'shapes';

    public static function create($shape, $params)
    {
        try
        {
            $shape = self::$shape_namespace . DIRECTORY_SEPARATOR . $shape;
            if (!class_exists($shape))
            {
                throw new \Exception("Shape {$shape} doesn't exists");
            }

            $shape = new $shape($params);
        }
        catch (\Exception $e)
        {
            // Handle exception
            $shape = false;
        }

        return $shape;
    }
}