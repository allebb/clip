<?php

namespace Ballen\Clip\Utilities;

use Ballen\Collection\Collection;

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
class ArgumentsParser
{

    /**
     * Collection of CLI parsed "commands" eg. (reset).
     * @var Collection
     */
    private $commands;

    /**
     * Collection of CLI parsed "options" eg. (--option=something or --option="something").
     * @var Collection
     */
    private $options;

    /**
     * Collection of CLI parsed "flags" or serial of 'flags' eg. (-y or -yRf).
     * @var Collection
     */
    private $flags;

    /**
     * Collection of CLI parsed "arguments" eg. ().
     * @var Collection
     */
    private $arguments;

    /**
     * Instaniate with the argument array
     * @param array $arguments The CLI arguments array ($argv) to parse.
     */
    public function __construct(array $arguments = [])
    {

        $this->commands = new Collection();
        $this->options = new Collection();
        $this->flags = new Collection();
        $this->arguments = new Collection();
        $this->parse($arguments);
    }

    /**
     * Return the collection of commands (eg. help).
     * @return Collection
     */
    public function commands()
    {
        return $this->commands;
    }

    /**
     * Return the collection of options (eg. --username=bobby).
     * @return Collection
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Return the collection of flags (eg. -v or --pass).
     * @return Collection
     */
    public function flags()
    {
        return $this->flags;
    }

    /**
     * Return all CLI arguments in order.
     * @return Collection
     */
    public function arguments()
    {
        return $this->arguments;
    }

    /**
     * Parses the PHP $argv variable and adds them to the relivant type collection.
     * @todo Clean up the nested loops etc.
     * @param array $args
     * @return void
     */
    private function parse($args)
    {
        foreach ($args as $argument) {
            $this->arguments->push($argument);
            if ($this->detectFlags($argument)) {
                continue;
            }
            if ($this->detectOptions($argument)) {
                continue;
            }
            if ($this->detectConcatFlag($argument)) {
                continue;
            }
            $this->commands->push($argument);
        }
    }

    /**
     * Checks to see if a flag or serial flag (eg. -y or --pass) is set
     * @param string $flag The flag name/character (can be single or a serial character)
     * @return boolean
     */
    public function isFlagSet($flag)
    {
        if (in_array($flag, $this->flags->all()->toArray())) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve the value of an option (eg. --username=jbloggs or --username="jbloggs")
     * @param string $name The name of the option to return
     * @param type $default An optional default value if its not set.
     * @return mixed
     */
    public function getOption($name, $default = false)
    {
        return $this->options->get($name, $default);
    }

    /**
     * Returns a command from the command index (eg. new or list).
     * @param int $part Will return the Nth command. eg 1 for "./consoleapp new myapp" will return 'new'.
     * @param string $default An optional default value if the command index is not set.
     */
    public function getCommand($part, $default = false)
    {
        return $this->commands->get($part, $default);
    }

    /**
     * Detects and sets "flag" type arguments.
     * @param string $argument The argument string.
     * @return boolean
     */
    private function detectFlags($argument)
    {
        if ((substr($argument, 0, 2) === '--') && (!strpos($argument, '='))) {
            $this->flags->push(ltrim($argument, '--'));
            return true;
        }
        return false;
    }

    /**
     * Detects and sets "concatenated flag" type arguments.
     * @param string $argument The argument string.
     * @return boolean
     */
    private function detectConcatFlag($argument)
    {
        if (substr($argument, 0, 1) === '-') {
            for ($i = 1; isset($argument[$i]); $i++) {
                $this->flags->push($argument[$i]);
            }
            return true;
        }
        return false;
    }

    /**
     * Detects and sets "option" type arguments.
     * @param type $argument The argument string.
     * @return boolean
     */
    private function detectOptions($argument)
    {
        if (substr($argument, 0, 2) === '--') {
            $name = substr($argument, 2);
            $value = '';
            if (strpos($name, '=')) {
                list($name, $value) = explode('=', $argument, 2);
            }
            $this->options->put(ltrim($name, '-'), trim($value, '"'));
            return true;
        }
        return false;
    }
}
