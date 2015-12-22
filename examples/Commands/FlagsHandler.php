<?php

namespace Commands;

use Ballen\Clip\ConsoleApplication;
use Ballen\Clip\Interfaces\CommandInterface;
use Ballen\Clip\Utilities\ArgumentsParser;

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
class FlagsHandler extends ConsoleApplication implements CommandInterface
{

    /**
     * Handle the command.
     * @param ArgumentsParser $arguments
     */
    public function handle(ArgumentsParser $arguments)
    {
        if ($arguments->getOption('country', false)) {
            $this->writeln('Country specified was ' . ucfirst($arguments->getOption('country')) . '.');
            $this->exitWithSuccess();
        }
        $this->writeln('Flags huh? - Run this helloworld.php flags --country="england" and see what happens!');
        $this->exitWithError();
    }
}
