<?php

namespace Ballen\Clip\Utilities;

use Ballen\Clip\Interfaces\CommandInterface;
use Ballen\Collection\Collection;
use RuntimeException;
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
    private $arguments;

    public function __construct($arguments = [])
    {
        $this->routes = new Collection();
        $this->arguments = new ArgumentsParser($arguments);
    }

    public function add($command, CommandInterface $handler)
    {
        $this->routes->put($command, $handler);
    }

    public function dispatch($command = false)
    {
        $handler = $this->routes->get($this->arguments->getCommand(1), false);
        if ($this->routes->get($command, false)) {
            $handler = $this->routes->get($command, false);
        }
        if ($handler) {
            return $handler->handle($this->arguments);
        }
        throw new CommandNotFoundException('Command ' . $command . ' is not registered.');
    }
}
