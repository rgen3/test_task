<?php

namespace classes;

use \interfaces\shape as shapeInterface;

abstract class shapeAbstract implements shapeInterface
{
    /**
     * @var array
     */
    protected static $validation_params = [];

    /**
     * @var array
     */
    protected $validation_errors = [];

    /**
     * shapeAbstract constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->data = $params;
        $this->validation();

        if (!empty($this->validation_errors))
            throw new Exception("Validation errors" . PHP_EOL . print_r($this->validation_errors, true));
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        if (!array_key_exists($this->data[$name]))
            throw new Exception("Invalid attribute name");

        return $this->data[$name];
    }

    /**
     *
     */
    protected function validation()
    {
        $called_class = get_called_class();
        $validation = array_merge(self::$validation_params, $called_class::$validation_params);

        $obj &= $this;

        array_walk(
            $validation,
            function ($value, $key) use (&$obj)
            {
                $method = 'validate' . ucfirst($value);
                if ($error = ($this->$method($obj->$key) !== false))
                {
                    $obj->validation_errors[] = $error;
                }
            }
        );
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validateRequired($value)
    {
        return isset($value);
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validateInteger($value)
    {
        return is_int($value);
    }

    protected function validateFloat($value)
    {
        return is_float($value);
    }

    protected function validateDimension($value)
    {
        return in_array($value, ['2d', '3d']);
    }
}