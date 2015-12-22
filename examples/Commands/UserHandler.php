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
class UserHandler extends ConsoleApplication implements CommandInterface
{

    private $allowed_usernames = [
        'john',
        'joe',
        'james',
        'jacob'
    ];

    /**
     * Handle the command.
     * @param ArgumentsParser $arguments
     */
    public function handle(ArgumentsParser $arguments)
    {
        $this->writeln('Choosing from a list of: John, Joe, James or Jacob...');
        $username = $this->input('What is your pretend name?', false);
        if (!$this->checkUsername($username)) {
            $this->writeln('Sorry you cannot be called ' . $username . ' today!');
            $this->exitWithError();
        }
        $this->writeln('Cool ' . $username . ' nice to meet you!');
        $this->exitWithSuccess();
    }

    private function checkUsername($username)
    {
        if (in_array(strtolower($username), $this->allowed_usernames)) {
            return true;
        }
    }
}
