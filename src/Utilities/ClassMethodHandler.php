<?php

namespace Ballen\Clip\Utilities;

use Ballen\Clip\Interfaces\CommandInterface;

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

    /**
     * Character for splitting the "dot" notation on command handlers.
     */
    const CHAR_DOT = '.';

    /**
     * Character for splitting the "at" notation on command handlers.
     */
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
     * Optional argument(s) to pass through when calling the Class contructor.
     * @var mixed
     */
    protected $constructor_arguments;

    /**
     * Creates a new instance
     * @param string|array $handler
     * @param array $constructor_arguments Optional arguments to pass to the class constructor.
     */
    public function __construct($handler, $constructor_arguments = [])
    {
        $this->constructor_arguments = $constructor_arguments;
        $this->extract($handler);
        $this->validate();
    }

    /**
     * Calls the requested class and method name passing in the optional arguments.
     * @param mixed $params Optional parameters to pass to the class method.
     * @return void
     */
    public function call($params = null)
    {
        $method = $this->method;

        if (!empty($this->constructor_arguments)) {
            $instance = new $this->class($this->constructor_arguments);
        } else {
            $instance = new $this->class();
        }
        if (!is_null($params)) {
            return $instance->$method($params);
        }
        return $instance->$method();
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
        if (strpos($handler, self::CHAR_AT) !== false) {
            return $this->fromAtNotation($handler);
        }
        if (strpos($handler, self::CHAR_DOT) !== false) {
            return $this->fromDotNotation($handler);
        }
        return $this->fromClassName($handler);
    }

    /**
     * Validates that the current class and methods exist and are callable.
     * @return void
     * @throws \RuntimeException
     */
    private function validate()
    {
        if (!class_exists($this->class)) {
            throw new \RuntimeException(sprintf('Class %s does not exist, is this the correct namespace?', $this->class));
        }
        if (!in_array($this->method, get_class_methods($this->class))) {
            throw new \RuntimeException(sprintf('The method "%s" does not exist in "%s" class.', $this->method, $this->class));
        }
    }

    /**
     * Extracts the class name and method from the Class Method string in "@" notation (eg. Class@Method).
     * @param string|array $handler The handler parameter
     * @return void
     * @throws \InvalidArgumentException
     */
    private function fromAtNotation($handler)
    {
        $parts = explode(self::CHAR_AT, $handler);
        if (count($parts) != 2) {
            throw new \InvalidArgumentException('Invalid Class Method format from "at" notation.');
        }
        $this->class = $parts[0];
        $this->method = $parts[1];
    }

    /**
     * Extracts the class name and method from the Class Method string in "dot" notation (eg. Class.Method).
     * @param string|array $handler The handler parameter
     * @return void
     * @throws \InvalidArgumentException
     */
    private function fromDotNotation($handler)
    {
        $parts = explode(self::CHAR_DOT, $handler);
        if (count($parts) != 2) {
            throw new \InvalidArgumentException('Invalid Class Method format from "dot" notation.');
        }
        $this->class = $parts[0];
        $this->method = $parts[1];
    }

    /**
     * Extracts the class name (no method present) from a single string.
     * @param string|array $handler The handler parameter
     * @return void
     * @throws \InvalidArgumentException
     */
    private function fromClassName($handler)
    {
        if (!is_subclass_of($handler, CommandInterface::class)) {
            throw new \InvalidArgumentException(sprintf('The command class must implement the "CommandInterface" interface.'));
        }
        $this->class = $handler;
    }

    /**
     * Extracts the class and method name from an array eg (['Class', 'Method'])
     * @param string|array $handler The handler parameter
     * @return void
     * @throws \InvalidArgumentException
     */
    private function fromClassMethodArray($handler)
    {
        if (count($handler) != 2) {
            throw new \InvalidArgumentException('Class method array constructor can only contain 2 elements.');
        }
        $this->class = $handler[0];
        $this->method = $handler[1];
    }
}
