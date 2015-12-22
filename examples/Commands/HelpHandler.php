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
class HelpHandler extends ConsoleApplication implements CommandInterface
{

    /**
     * Handle the command.
     * @param ArgumentsParser $arguments
     */
    public function handle(ArgumentsParser $arguments)
    {
        $this->writeln();
        $this->writeln('Example help screen');
        $this->writeln();
        $this->writeln('Usage: helloworld [OPTIONS]');
        $this->writeln('A Hello World application to demonstrate Clip');
        $this->writeln();
        $this->writeln('Commands:');
        $this->writeln('  help       - This information screen');
        $this->writeln('  test       - A silly test example');
        $this->writeln('  check:name - User input example');
        $this->writeln();
        $this->exitWithSuccess();
    }
}
