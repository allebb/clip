#!/usr/bin/env php
<?php
use Ballen\Clip\Utilities\CommandRouter;
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
// Initiate the Composer autoloader.
$bindir = dirname(__FILE__);
require_once $bindir . '/../vendor/autoload.php';

// If not using Composer in your project you'll need to "require" the command handlers..
require_once 'Commands/TestHandler.php';
require_once 'Commands/HelpHandler.php';
require_once 'Commands/UserHandler.php';
require_once 'Commands/FlagsHandler.php';

$app = new CommandRouter($argv);

// Add our command and their handler class mappings
$app->add('test', 'Commands\TestHandler@handle'); // Registering commands using the "at" notation and specifying the class method.
$app->add('help', Commands\HelpHandler::class); // Registering command using class name (string)
$app->add('check:name', ['Commands\UserHandler', 'handle']); // Registering the command handler using array notation.
$app->add('flags', 'Commands\FlagsHandler.handle'); // Registering the command handler using "dot" notation.

try {
    $app->dispatch();
} catch (CommandNotFoundException $exception) {
    // If the requested command is not found we'll display the 'help' text by default?
    $app->dispatch('help');
}

