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
class RequiredOptionsExampleHander extends ConsoleApplication implements CommandInterface
{

    private $name;
    private $age;

    use RecievesArgumentsTrait;

    /**
     * Handle the command.
     */
    public function handle()
    {
        if (!$this->arguments()->requiredOptions(['name', 'age'])) {
            $this->writeln('The --name and --age options are mandatory!')->exitWithError();
        }
        $this->name = $this->arguments()->options()->get('name');
        $this->age = $this->arguments()->options()->get('age');
        $this->writeln(sprintf('Hello %s, thanks for confirming your age as %s years old!', $this->name, $this->age))->exitWithSuccess();
    }
}
