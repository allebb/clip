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
class UserHandler extends ConsoleApplication implements CommandInterface
{

    use RecievesArgumentsTrait;

    /**
     * Example array of allowed usernames.
     * @var array
     */
    private $allowed_usernames = [
        'john',
        'joe',
        'james',
        'jacob'
    ];

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->writeln('Choosing from a list of: John, Joe, James or Jacob...');
        $username = $this->input('What is your pretend name?', false);
        if (!$this->checkUsername($username)) {
            $this->writeln('Sorry you cannot be called ' . $username . ' today!');
            $this->exitWithError();
        }
        $this->writeln('Cool ' . ucfirst($username) . ' nice to meet you!');
        $this->exitWithSuccess();
    }

    private function checkUsername($username)
    {
        if (in_array(strtolower($username), $this->allowed_usernames)) {
            return true;
        }
    }
}
