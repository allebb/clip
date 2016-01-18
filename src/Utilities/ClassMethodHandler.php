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
     * Creates a new instance
     * @param string $handler
     * @param array $arguments Optional argument to pass to the class constructor.
     */
    public function __construct($handler, $arguments = [])
    {
        $this->extract();
    }

    /**
     * Extracts the class and method name.
     * @return void
     */
    private function extract()
    {
        
    }

    /**
     * Calls the requested class and method name passing in the optional arguments.
     * @return void
     */
    private function call()
    {
        
    }
}
