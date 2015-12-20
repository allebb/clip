#!/usr/bin/env php
<?php
/**
 * An example CLI bootstap script.
 */
// Initiate the Composer autoloader.
$bindir = dirname(__FILE__);
require_once $bindir . '/../vendor/autoload.php';

// Load our example Test Applcation.
require_once 'MyTestApp.php';

// Create a new insance of your application class (that extends Clip)
$app = new MyTestApp($argv);

// Lets check if the user wanted to view the version number (by checking if the -v flag is set)
if ($app->arguments()->isFlagSet('v')) {
    $app->writeln('MyTestApp v' . $app->version());
    $app->exitWithSuccess();
}

// An example 'debug' mode to output all of the commands, options and flags passed to the tool (eg. ./testapp -d -ygh --pass command1 command2 command3 --user=bobby --user2="ballen" -q)
if ($app->arguments()->isFlagSet('d')) {
    $app->writearr(['Commands' => $app->arguments()->commands()]);
    $app->writearr(['Options' => $app->arguments()->options()]);
    $app->writearr(['Flags' => $app->arguments()->flags()]);
    $app->exitWithSuccess();
}

// Lets check the application "commands" and react to the user accordingly.
if ($app->arguments()->getCommand(1, false)) {
    switch ($app->arguments()->getCommand(1)) {
        case "list":
            $app->writeln('An example list may be displayed here!');
            break;
        case "new":
            $app->writeln('You created a new something called ' . $app->arguments()->getCommand(2, ''));
            break;
        case "delete":
            $app->writeln("You delete something called " . $app->arguments()->getCommand(2, ''));
            break;
        default:
            displayHelp($app);
    }
} else {
    displayHelp($app);
}

/**
 * The application 'help' screen text.
 */
function displayHelp(MyTestApp $app)
{
    $app->writeln();
    $app->writeln('Usage: testapp [OPTION]');
    $app->writeln();
    $app->writeln('Options:');
    $app->writeln(' list   List all example things');
    $app->writeln(' new    Creates a new example thing');
    $app->writeln(' delete Delete an example thing');
    $app->writeln();
    $app->writeln(' -d Displays output of all commands, options and flags');
    $app->writeln(' -v Displays the version number of MyTestApp');
    $app->writeln(' -h Displays this help screen.');
    $app->writeln();
}
