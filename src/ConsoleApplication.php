<?php

namespace Ballen\Clip;

use Ballen\Clip\Utilities\ArgumentsParser;
use InvalidArgumentException;

class ConsoleApplication
{

    /**
     * The CLI arguments
     * @var ArgumentsParser
     */
    private $arguments;

    public function __construct($argv = [])
    {
        $this->arguments = new ArgumentsParser($argv);
    }

    /**
     * Returns the CLI arguments exposed to the CLI application.
     * @return ArgumentsParser
     */
    public function arguments()
    {
        return $this->arguments;
    }

    /**
     * Enforces that the script must be run at the console.
     * @param boolean $enforced Enforce execution only through the CLI.
     * @return void
     */
    public function enforceCli($enforced = true)
    {
        if ($enforced && php_sapi_name() != "cli") {
            die('CLI excution permitted only!');
        }
    }

    /**
     * Checks that the user is root!
     * @return boolean
     */
    public function isSuperUser()
    {
        if (posix_getuid() == 0) {
            return true;
        }
        return false;
    }

    /**
     * Executes a system command.
     * @param string $command The command to execute.
     * @return string
     */
    public function call($command)
    {
        return system($command);
    }

    /**
     * Write to the CLI.
     * @param string $text The text to output.
     */
    public function write($text = '')
    {
        fwrite(STDOUT, $text);
    }

    /**
     * Write a line of characters (or an empty line) to the CLI.
     * @param string $line The text to output.
     */
    public function writeln($text = '')
    {
        $this->write($text . PHP_EOL);
    }

    /**
     * Request user input
     * @param string $question The input question/text
     * @param string $default A default value if one is not selected.
     * @param array $options Valid options that are acceptable, these are case insensitive!
     * @return string
     */
    public function input($question, $default = '', $options = [])
    {
        if (empty($default)) {
            fwrite(STDOUT, $question . ' ');
        } elseif (empty($options)) {
            fwrite(STDOUT, $question . ' [' . $default . '] ');
        } else {
            foreach (strtolower($options) as $option) {
                if ($option === strtolower($default)) {
                    $option = strtoupper($option);
                }
                $available_options[] = $option;
            }

            $available_opts = rtrim(implode($available_options, '/'), '/');
            fwrite(STDOUT, $question . ' [' . $available_opts . '] ');
        }

        $answer = rtrim(fgets(STDIN), PHP_EOL);

        if (empty($answer)) {
            return $default;
        }

        if (count($options) > 0) {
            if (!in_array(strtolower($answer), array_map('strtolower', $options))) {
                return $this->input($question, $default, $options);
            }
            return $answer;
        }

        return $answer;
    }

    /**
     * Writes an array to the CLI output
     * @param array $array The array of data to write to the terminal.
     * @return void
     */
    public function writearr($array = [])
    {
        print_r($array);
    }

    /**
     * Exits with a specific status code.
     * @param int $status The status code to exit with.
     * @throws InvalidArgumentException
     */
    public function exitWithStatus($status = 0)
    {
        if (!is_int($status)) {
            throw new InvalidArgumentException('The status code must be an integer value.');
        }
        exit($status);
    }

    /**
     * Exits the CLI with status code 0 (Successful)
     * @return void
     */
    public function exitWithSuccess()
    {
        $this->exitWithStatus(0);
    }

    /**
     * Exits the CLI with statu code 1 (Error)
     * @return void
     */
    public function exitWithError()
    {
        $this->exitWithStatus(1);
    }
}
