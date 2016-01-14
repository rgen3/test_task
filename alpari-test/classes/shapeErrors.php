<?php

namespace classes;


/**
 * Class shapeErrors
 *
 * Error processing class
 *
 * @package classes
 */
class shapeErrors
{
    /**
     * Array of errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Instance
     * @var
     */
    private static $instance;

    /**
     * shapeErrors constructor.
     */
    protected function __construct(){}

    /**
     * Get the instance of error class
     *
     * @return shapeErrors
     */
    public static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new shapeErrors();

        return self::$instance;
    }

    /**
     * Adds some params to error object
     *
     * @param $name
     * @param $type
     * @param string $message
     */
    public function add($name, $type, $message = '')
    {
        $this->errors[$name] = "---\n{$type}\n{$name} : {$message}\n---";
    }

    /**
     * @param $name
     * @return null
     */
    public function get($name)
    {
        $result = null;

        if (array_key_exists($name, $this->errors))
            $result = $this->errors[$name];

        return $result;
    }

    /**
     * Count current errors
     *
     * @return int
     */
    public function count()
    {
        return count($this->errors);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) implode(PHP_EOL, $this->errors);
    }
}