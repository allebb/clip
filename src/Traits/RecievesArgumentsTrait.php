<?php

namespace Ballen\Clip\Traits;

use Ballen\Clip\Utilities\ArgumentsParser;

/**
 * Clip
 * 
 * A package for speeding up development of PHP console (CLI) applications.
 *
 * @author Bobby Allen <ballen@bobbyallen.me>
 * @license https://raw.githubusercontent.com/bobsta63/clip/master/LICENSE
 * @link https://github.com/allebb/clip
 * @link http://www.bobbyallen.me
 *
 */
trait RecievesArgumentsTrait
{

    /**
     * Injects the parent consructor with the CLI arguments.
     */
    public function __construct(ArgumentsParser $argv)
    {
        parent::__construct($argv);
    }
}
