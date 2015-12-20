<?php

namespace Ballen\Clip\Utilities;

use Ballen\Collection\Collection;

class ArgumentsParser
{

    /**
     * Collection of CLI parsed "commands" eg. (--reset).
     * @var Collection
     */
    private $commands;

    /**
     * Collection of CLI parsed "options" eg. (--option=something).
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
     * Parses the PHP $argv variable and adds them to the relivant type collection.
     * @todo Clean up the nested loops etc.
     * @param array $args
     * @return void
     */
    private function parse($args)
    {
        $endofoptions = false;
        while ($arg = array_shift($args)) {

            if ($endofoptions) {
                $this->arguments->push($arg);
                continue;
            }

            if (substr($arg, 0, 2) === '--') {

                if (!strpos($arg, '=')) {
                    $this->flags->push(ltrim($arg, '--'));
                    continue;
                }

                $value = "";
                $com = substr($arg, 2);

                if (strpos($com, '=')) {
                    list($com, $value) = explode("=", $com, 2);
                } elseif (strpos($args[0], '-') !== 0) {
                    while (strpos($args[0], '-') !== 0)
                        $value .= array_shift($args) . ' ';
                    $value = rtrim($value, ' ');
                }

                if (empty($value)) {
                    $value = true;
                }
                $this->options->put($com, $value);
                continue;
            }

            if (substr($arg, 0, 1) === '-') {
                for ($i = 1; isset($arg[$i]); $i++)
                    $this->flags->push($arg[$i]);
                continue;
            }

            $this->commands->push($arg);
            continue;
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
}
