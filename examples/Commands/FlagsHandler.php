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
class FlagsHandler extends ConsoleApplication implements CommandInterface
{

    use RecievesArgumentsTrait;

    /**
     * Handle the command.
     */
    public function handle()
    {
        if ($this->arguments()->getOption('country', false)) {
            $this->writeln('Country specified was ' . ucfirst($this->arguments()->getOption('country')) . '.');
            $this->exitWithSuccess();
        }
        $this->writeln('Flags huh? - Run this helloworld.php flags --country="england" and see what happens!');
        $this->exitWithError();
    }
}
