<?php

namespace Ballen\Clip\Utilities;

use Ballen\Collection\Collection;
use Ballen\Clip\Exceptions\CommandNotFoundException;

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
class CommandRouter
{

    /**
     * Configured routes
     * @var Collection
     */
    private $routes;

    /**
     * CLI arguments
     * @var ArgumentsParser 
     */
    private $arguments;

    public function __construct($arguments = [])
    {
        $this->routes = new Collection();
        $this->arguments = new ArgumentsParser($arguments);
    }

    /**
     * Register a new command handler.
     * @param string $command The command name
     * @param mixed $handler The command handler (see ClassMethodHandler)
     */
    public function add($command, $handler)
    {
        $this->routes->put($command, $handler);
    }

    /**
     * Dispatches the command handler.
     * @param string $call The command handler to execute.
     * @return void
     * @throws CommandNotFoundException
     */
    public function dispatch($call = null)
    {
        $command = $this->routes->get($this->arguments->getCommand(1), false);
        if ($this->routes->get($call, false)) {
            $command = $this->routes->get($call, false);
        }
        if ($command) {
            $handler = new ClassMethodHandler($command, $this->arguments);
            return $handler->call($this->arguments);
        }
        throw new CommandNotFoundException(sprintf('Command %s is not registered.', $call));
    }
}
