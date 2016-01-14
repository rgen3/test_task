<?php

namespace classes;

use shapes;

class shapeFactory
{

    private static $shape_namespace = 'shapes';

    /**
     * Returns an instance of a shape
     *
     * @param $shape
     * @param $params
     * @return string
     */
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
            echo "ERROR MESSAGE : {$e->getMessage()}";
            $shape = false;
        }

        return $shape;
    }
}