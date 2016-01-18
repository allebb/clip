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
    protected $constructor_arguments = [];

    /**
     * Creates a new instance
     * @param string $handler
     * @param array $constructor_arguments Optional argument to pass to the class constructor.
     */
    public function __construct($handler, $constructor_arguments = [])
    {
        $this->constructor_arguments = $constructor_arguments;
        $this->extract($handler);
        $this->validate();
    }

    /**
     * Calls the requested class and method name passing in the optional arguments.
     * @param array $method_arguments Optional arguments when calling the method.
     * @return void
     */
    public function call($method_arguments = [])
    {
        $instance = new $this->class($this->arguments);
        return call_user_func_array($instance->{$this->method}(), $method_arguments);
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
        if (!class_exists($this->class)) {
            throw new \RuntimeException(sprintf('Class %s does not exist, is this the correct namespace?', $this->class));
        }
        if (in_array($this->method, get_class_methods($this->class))) {
            throw new \RuntimeException(sprintf('The method "%s" does not exist in "%s" class.', $this->method, $this->class));
        }
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
            throw new \InvalidArgumentException('Invalid Class Method format from "at" notation.');
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
            throw new \InvalidArgumentException('Invalid Class Method format from "dot" notation.');
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
        $this->class = $handler;
    }

    /**
     * Extracts the class and method name from an array eg (['Class', 'Method'])
     * @param string|array $handler The handler parameter
     * @return void
     */
    private function fromClassMethodArray($handler)
    {
        if (count($handler) !== 2) {
            throw new \InvalidArgumentException('Class Method array constructor can only contain 2 elements.');
        }
        $this->class = $handler[0];
        $this->method = $handler[1];
    }
}
