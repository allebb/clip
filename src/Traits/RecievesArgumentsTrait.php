<?php

namespace Ballen\Clip\Traits;

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
trait RecievesArgumentsTrait
{

    /**
     * Injects the parent consructor with the CLI arguments.
     */
    public function __construct($argv)
    {
        parent::__construct($argv);
    }
}
