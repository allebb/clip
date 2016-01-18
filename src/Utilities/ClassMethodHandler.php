<?php

namespace Ballen\Clip\Utilities;

/**
 * Clip
 * 
 * A package for speeding up development of PHP console (CLI) applications.
 *
 * @author Bobby Allen <ballen@bobbyallen.me>
 * @license https://raw.githubusercontent.com/bobsta63/clip/master/LICENSE
 * @link https://github.com/bobsta63/clip
 * @link http://www.bobbyallen.me
 *
 */
class ClassMethodHandler
{

    const CHAR_DOT = '.';
    const CHAR_AT = '@';

    /**
     * Class of which will be instantiated at runtime.
     * @var string 
     */
    protected $class;

    /**
     * The method of which should be called at runtime.
     * @var string
     */
    protected $method = 'handle';

    /**
     * Optional argument to pass through when calling the Class contructor.
     * @var array 
     */
    protected $arguments = [];

    /**
     * Creates a new instance
     * @param string $handler
     * @param array $arguments Optional argument to pass to the class constructor.
     */
    public function __construct($handler, $arguments = [])
    {
        $this->arguments = $arguments;
        $this->extract($handler);
        $this->validate();
    }

    /**
     * Calls the requested class and method name passing in the optional arguments.
     * @return void
     */
    public function call()
    {
        $instance = new $this->class($this->arguments);
        return call_user_func($instance->{$this->method});
    }

    /**
     * Extracts the class and method name.
     * @param string|array $handler The handler parameter
     * @return void
     */
    private function extract($handler)
    {
        if (is_array($handler)) {
            return $this->fromClassMethodArray($handler);
        }
        if (strpos($handler, '@') !== false) {
            return $this->fromAtNotation($handler);
        }
        if (strpos($handler, '.') !== false) {
            return $this->fromDotNotation($handler);
        }
        return $this->fromClassName($handler);
    }

    /**
     * Validates that the current class and methods exist and are callable.
     * @return void
     */
    private function validate()
    {
        
    }

    /**
     * Extracts the class name and method from the Class Method string in "@" notation (eg. Class@Method).
     * @param string|array $handler The handler parameter
     * @return void
     */
    private function fromAtNotation($handler)
    {
        $parts = explode(CHAR_DOT, $handler);
        if (count($parts) !== 2) {
            // Not the correct number of array items value.
        }
        $this->class = $parts[0];
        $this->method = $parts[1];
    }

    /**
     * Extracts the class name and method from the Class Method string in "dot" notation (eg. Class.Method).
     * @param string|array $handler The handler parameter
     * @return void
     */
    private function fromDotNotation($handler)
    {
        $parts = explode(CHAR_AT, $handler);
        if (count($parts) !== 2) {
            // Not the correct number of array items value.
        }
        $this->class = $parts[0];
        $this->method = $parts[1];
    }

    /**
     * Extracts the class name (no method present) from a single string.
     * @param string|array $handler The handler parameter
     * @return void
     */
    private function fromClassName($handler)
    {
        
    }

    /**
     * Extracts the class and method name from an array eg (['Class', 'Method'])
     * @param string|array $handler The handler parameter
     * @return void
     */
    private function fromClassMethodArray($handler)
    {
        
    }
}
