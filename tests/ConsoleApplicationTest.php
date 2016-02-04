<?php
use Ballen\Clip\Utilities\CommandRouter;
use Ballen\Clip\ConsoleApplication;
use Ballen\Clip\Traits\RecievesArgumentsTrait;
use Ballen\Clip\Interfaces\CommandInterface;

class ConsoleApplicationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Example $argv array, excute being 'php example_app.php help'
     * @var array
     */
    private $argv_example1 = ['example_app.php', 'help'];

    /**
     * Extended example $argv array, excute being 'php env add --DB_USER="ballen" --DB_PASS="my_password_here" --quiet --no-interaction -yRf'
     * @var array
     */
    private $argv_example2 = ['env', 'add', '--DB_USER="ballen"', '--DB_PASS="my_password_here"', '--quiet', '--no-interaction', '-yRf'];

    public function testCallingUnregisteredHandler()
    {
        $app = new CommandRouter($this->argv_example1);
        $this->setExpectedException('Ballen\Clip\Exceptions\CommandNotFoundException', 'Command  is not registered.');
        $app->dispatch();
    }

    public function testCallingExplicitUnregisteredHandler()
    {
        $command_name = 'a_command_name';
        $app = new CommandRouter($this->argv_example1);
        $this->setExpectedException('Ballen\Clip\Exceptions\CommandNotFoundException', sprintf('Command %s is not registered.', $command_name));
        $app->dispatch('a_command_name');
    }

    public function testRegisteringHandler()
    {
        $command_name = 'a_command_name';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, 'Test@handle');
        $this->setExpectedException('\RuntimeException', sprintf('Class %s does not exist, is this the correct namespace?', 'Test'));
        $app->dispatch($command_name);
    }

    public function testCallingRegisteredHandler()
    {
        $app = new CommandRouter($this->argv_example1);
        $app->add('test', 'TestHandler');
        $this->assertTrue($app->dispatch('test'));
    }

    public function testCallingAtNotationRegisteredHandler()
    {
        $app = new CommandRouter($this->argv_example1);
        $app->add('test', 'TestHandler@handle');
        $this->assertTrue($app->dispatch('test'));
    }

    public function testCallingNullAtNotationMethodHandler()
    {
        $command_name = 'test';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, 'TestHandler@dd@dd@');
        $this->setExpectedException('\InvalidArgumentException', 'Invalid Class Method format from "at" notation.');
        $app->dispatch($command_name);
    }

    public function testCallingInvalidAtNotationMethodHandler()
    {
        $command_name = 'test';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, 'TestHandler@invalidMethod');
        $this->setExpectedException('\RuntimeException', sprintf('The method "%s" does not exist in "TestHandler" class.', 'invalidMethod'));
        $app->dispatch($command_name);
    }

    public function testCallingDotNotationRegisteredHandler()
    {
        $app = new CommandRouter($this->argv_example1);
        $app->add('test', 'TestHandler.handle');
        $this->assertTrue($app->dispatch('test'));
    }

    public function testCallingNullDotNotationMethodHandler()
    {
        $command_name = 'test';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, 'TestHandler.dd.dd');
        $this->setExpectedException('\InvalidArgumentException', 'Invalid Class Method format from "dot" notation.');
        $app->dispatch($command_name);
    }

    public function testCallingInvalidDotNotationMethodHandler()
    {
        $command_name = 'test';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, 'TestHandler.invalidMethod');
        $this->setExpectedException('\RuntimeException', sprintf('The method "%s" does not exist in "TestHandler" class.', 'invalidMethod'));
        $app->dispatch($command_name);
    }

    public function testCallingArrayRegisteredHandler()
    {
        $app = new CommandRouter($this->argv_example1);
        $app->add('test', ['TestHandler', 'customMethodName']);
        $this->assertTrue($app->dispatch('test'));
    }

    public function testCallingNullArrayMethodHandler()
    {
        $command_name = 'test';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, ['TestHandler', 'customMethodName', 'dd', 'dd']);
        $this->setExpectedException('\InvalidArgumentException', 'lass method array constructor can only contain 2 elements.');
        $app->dispatch($command_name);
    }

    public function testCallingInvalidArrayMethodHandler()
    {
        $command_name = 'test';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, ['TestHandler', 'invalidMethod']);
        $this->setExpectedException('\RuntimeException', sprintf('The method "%s" does not exist in "TestHandler" class.', 'invalidMethod'));
        $app->dispatch($command_name);
    }

    public function testCallingInvalidHandlerClassNotImplementingConsoleInterface()
    {
        $command_name = 'test';
        $app = new CommandRouter($this->argv_example1);
        $app->add($command_name, 'TestInvalidHandler');
        $this->setExpectedException('\InvalidArgumentException', 'The command class must implement the "CommandInterface" interface.');
        $app->dispatch($command_name);
    }
}

/**
 * Simple example TestHandler Class
 */
class TestHandler extends ConsoleApplication implements CommandInterface
{

    use RecievesArgumentsTrait;

    public function handle()
    {
        return true;
    }

    public function customMethodName()
    {
        return true;
    }
}

/**
 * Simple example TestHandler Class not implemetning the CommandInteface.
 */
class TestInvalidHandler extends ConsoleApplication
{

    use RecievesArgumentsTrait;

    public function handle()
    {
        return true;
    }

    public function customMethodName()
    {
        return true;
    }
}
