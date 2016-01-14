<?php

namespace classes;

use \interfaces\shape as shapeInterface,
    \classes\shapeValidation as validation;

abstract class shapeAbstract implements shapeInterface
{
    /**
     * Validation params for a shape
     *
     * @var array
     */
    protected static $validation_params = [];

    /**
     * Validation errors for a shape
     *
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
        $this->validation_errors = \classes\shapeErrors::getInstance();
    }

    /**
     * Method to check is it possible to draw a shape
     */
    public function create()
    {
        $this->validation();

        if ($this->validation_errors->count())
        {
            return $this->validation_errors;
        }

        $this->draw();

        return false;
    }

    /**
     * Return array of errors
     * or empty array if there are no errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->validation_errors;
    }

    /**
     * Prints error list for a shape
     */
    public function displayErrors()
    {
        print_r($this->getErrors());
    }

    /**
     * Getter
     *
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        try
        {
            if (!array_key_exists($name, $this->data))
                throw new \Exception("{$name} is not set");

            $result = $this->data[$name];
        }
        catch (\Exception $e)
        {
            $this->validation_errors->add($name, "Getter error", $e->getMessage());
            $result = null;
        }

        return $result;
    }

    /**
     * Validates input params
     */
    protected function validation()
    {
        $called_class = get_called_class();
        $validation = array_merge(self::$validation_params, $called_class::$validation_params);

        array_walk(
            $validation,
            function ($value, $key) use ($called_class)
            {
                $method = 'validate' . ucfirst($value);
                try
                {
                    if (($error = validation::$method($this->$key, $called_class)) !== false)
                    {
                        throw new \Exception("{$called_class} - {$error}");
                    }
                }
                catch(\Exception $e)
                {
                    $this->validation_errors->add($key, 'Validation error', $e->getMessage());
                }
            }
        );
    }
}