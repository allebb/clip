<?php

namespace Commands;

use Ballen\Clip\ConsoleApplication;
use Ballen\Clip\Traits\RecievesArgumentsTrait;
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
class TestHandler extends ConsoleApplication implements CommandInterface
{

    use RecievesArgumentsTrait;

    /**
     * Handle the command using a named method (insread of the default handle() method)
     */
    public function displayTest()
    {
        $this->writeln('Hello, recieved the "test" command just fine!');
        $this->exitWithSuccess();
    }
}
